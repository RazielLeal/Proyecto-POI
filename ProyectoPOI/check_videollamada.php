<?php
session_start();
require 'php/confi.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT vc.call_id, vc.caller_id, u.fname, u.lname 
        FROM video_calls vc
        JOIN users u ON vc.caller_id = u.user_id
        WHERE vc.receiver_id = ? AND vc.status = 'pending'
        ORDER BY vc.created_at DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($call = $result->fetch_assoc()) {
    echo json_encode([
        "call_pending" => true,
        "caller_id" => $call['caller_id'],
        "caller_name" => $call['fname'] . " " . $call['lname']
    ]);
} else {
    echo json_encode(["call_pending" => false]);
}
?>
