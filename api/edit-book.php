<?php
header('Content-Type: application/json');
require_once '../connection.php';
$data = json_decode(file_get_contents('php://input'), true);
$stmt = $conn->prepare("UPDATE book SET title=?, author=?, genre=?, year=?, image=?, link=? WHERE id=?");
$stmt->bind_param("ssssssi", $data['title'], $data['author'], $data['genre'], $data['year'], $data['image'], $data['link'], $data['id']);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
?>
