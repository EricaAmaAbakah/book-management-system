<?php
header('Content-Type: application/json');
require_once '../connection.php';
$result = $conn->query("SELECT * FROM book ORDER BY id DESC");
$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
echo json_encode($books);
?>
