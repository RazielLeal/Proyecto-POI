<?php
session_start();
header('Content-Type: application/json');
require 'php/confi.php';

if (!isset($_GET['chat_id'])) {
    echo json_encode(["error" => "Chat no seleccionado"]);
    exit;
}

$chat_id = intval($_GET['chat_id']);
$query = "SELECT messages.text, messages.date_sent, users.fname, users.lname 
          FROM messages 
          JOIN users ON messages.user_id = users.user_id 
          WHERE messages.chat_id = ? ORDER BY messages.date_sent ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $chat_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'sender' => $row['fname'] . ' ' . $row['lname'],
        'text' => $row['text'],
        'date_sent' => $row['date_sent']
    ];
}

echo json_encode([
    'messages' => $messages
]);
?>
