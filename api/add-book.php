<?php
header('Content-Type: application/json');
require_once '../connection.php';
$data = json_decode(file_get_contents('php://input'), true);
$stmt = $conn->prepare("INSERT INTO book (title, author, genre, year, image, link) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $data['title'], $data['author'], $data['genre'], $data['year'], $data['image'], $data['link']);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $conn->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
?>
