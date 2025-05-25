const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
const peerConnection = new RTCPeerConnection({
    iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
});

const SIGNALING_SERVER = 'signal_server.php';

const urlParams = new URLSearchParams(window.location.search);
const receiverId = urlParams.get('receiver_id');
let isCaller = !!receiverId;
let localStream;

// Mostrar avatar del usuario logueado
fetch("get_user_avatar.php")
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById("user-avatar").src = data.img;
        }
    });

// Captura de video local
navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    .then(stream => {
        localStream = stream;
        localVideo.srcObject = stream;
        stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
        notifyReady(); // <--- avisa que estoy listo
        if (isCaller) waitForReceiverThenOffer();
    })
    .catch(error => {
        alert("No se pudo acceder a la cámara: " + error);
    });

//NOTIFICAR DE LISTO
function notifyReady() {
    fetch("ready_check.php", {
        method: "POST"
    });
}

function waitForReceiverThenOffer() {
    const check = () => {
        fetch(`ready_check.php?other=${receiverId}`)
            .then(res => res.json())
            .then(data => {
                if (data.other_ready) {
                    console.log("Ambos usuarios están listos. Enviando oferta.");
                    createOffer();
                } else {
                    console.log("Esperando al receptor...");
                    setTimeout(check, 2000);
                }
            });
    };
    check();
}

// ICE Candidates
peerConnection.onicecandidate = e => {
    if (e.candidate) {
        sendSignal({ type: 'candidate', candidate: e.candidate });
    }
};

peerConnection.ontrack = event => {
    remoteVideo.srcObject = event.streams[0];
};

// Oferta y respuesta
function createOffer() {
    peerConnection.createOffer()
        .then(offer => peerConnection.setLocalDescription(offer))
        .then(() => sendSignal({ type: 'offer', sdp: peerConnection.localDescription }))
        .catch(console.error);
}

function createAnswer(offer) {
    peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
        .then(() => peerConnection.createAnswer())
        .then(answer => peerConnection.setLocalDescription(answer))
        .then(() => sendSignal({ type: 'answer', sdp: peerConnection.localDescription }))
        .catch(console.error);
}

// Señalización
function receiveSignal() {
    fetch(SIGNALING_SERVER)
        .then(res => res.json())
        .then(data => {
            if (data.type === 'offer') {
                createAnswer(data.sdp);
            } else if (data.type === 'answer') {
                peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
            } else if (data.type === 'candidate') {
                peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
            }
        });
}

function sendSignal(message) {
    fetch(`ignal_server.php?to=${receiverId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(message)
    });
}

setInterval(receiveSignal, 2000);

function endCall() {
    peerConnection.close();
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
    }
    fetch("end_call.php", {
        method: "POST"
    }).then(() => {
        alert("Llamada finalizada");
        window.location.href = 'chat_priv.php';
    });
}

