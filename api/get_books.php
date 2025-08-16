<?php
require_once '../config/database.php';
require_once '../includes/session.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user = getCurrentUser();
$database = new Database();
$db = $database->getConnection();

try {
    // Get all books for all users
    $query = "SELECT * FROM books ORDER BY created_at DESC";
    $stmt = $db->query($query);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'books' => $books]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
