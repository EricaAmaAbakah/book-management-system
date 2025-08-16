<?php
require_once '../config/database.php';
require_once '../includes/session.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$user = getCurrentUser();
$database = new Database();
$db = $database->getConnection();

// Get POST data
$book_id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$genre = $_POST['genre'] ?? '';
$year = $_POST['year'] ?? '';
$link = $_POST['link'] ?? '';
$description = $_POST['description'] ?? '';
$image = $_POST['image'] ?? '';

if (!$book_id) {
    echo json_encode(['success' => false, 'message' => 'Book ID required']);
    exit;
}

try {
    $query = "UPDATE books SET title = ?, author = ?, genre = ?, year = ?, link = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $result = $stmt->execute([$title, $author, $genre, $year, $link, $description, $image, $book_id]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Book updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Book not found or no changes made']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
