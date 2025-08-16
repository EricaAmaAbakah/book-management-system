<?php

include '../config/database.php';
$database = new Database();
$pdo = $database->getConnection();

if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM book WHERE id = ?");
        $stmt->execute([$book_id]);
        
        echo json_encode(['success' => true, 'message' => 'Book deleted successfully']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Book ID not provided']);
}
?>
