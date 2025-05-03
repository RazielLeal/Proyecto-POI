const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#password");

    togglePassword.addEventListener("click", function () 
    {
        // Cambiar el tipo de input entre 'password' y 'text'
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        // Cambiar el ícono
        this.classList.toggle("fa-eye-slash");
    }
);