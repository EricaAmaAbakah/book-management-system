<?php
header('Content-Type: application/json');
require_once '../connection.php';
$data = json_decode(file_get_contents('php://input'), true);
$stmt = $conn->prepare("DELETE FROM book WHERE id=?");
$stmt->bind_param("i", $data['id']);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
?>
