<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

class Books {
    private $conn;
    private $table_name = "books";

    public function __construct($db) {
        $this->conn = $db;
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function create($book_data) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => 'Please log in first'];
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, title, author, genre, year, image, link, rating, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $rating = $book_data['rating'] ?? round(rand(35, 50) / 10, 1);
        $description = $book_data['description'] ?? "A wonderful " . strtolower($book_data['genre']) . " story by " . $book_data['author'] . ".";

        if ($stmt->execute([
            $_SESSION['user_id'],
            $book_data['title'],
            $book_data['author'],
            $book_data['genre'],
            $book_data['year'],
            $book_data['image'] ?? null,
            $book_data['link'] ?? null,
            $rating,
            $description
        ])) {
            $book_id = $this->conn->lastInsertId();
            return [
                'success' => true,
                'message' => 'Book added successfully',
                'book_id' => $book_id
            ];
        }

        return ['success' => false, 'message' => 'Failed to add book'];
    }

    public function read($book_id = null) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => 'Please log in first'];
        }

        if ($book_id) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$book_id, $_SESSION['user_id']]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                return ['success' => true, 'book' => $book];
            } else {
                return ['success' => false, 'message' => 'Book not found'];
            }
        } else {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$_SESSION['user_id']]);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['success' => true, 'books' => $books];
        }
    }

    public function update($book_id, $book_data) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => 'Please log in first'];
        }

        $query = "UPDATE " . $this->table_name . " 
                  SET title = ?, author = ?, genre = ?, year = ?, image = ?, link = ?, description = ?
                  WHERE id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([
            $book_data['title'],
            $book_data['author'],
            $book_data['genre'],
            $book_data['year'],
            $book_data['image'] ?? null,
            $book_data['link'] ?? null,
            $book_data['description'] ?? null,
            $book_id,
            $_SESSION['user_id']
        ])) {
            return ['success' => true, 'message' => 'Book updated successfully'];
        }

        return ['success' => false, 'message' => 'Failed to update book'];
    }

    public function delete($book_id) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => 'Please log in first'];
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$book_id, $_SESSION['user_id']])) {
            return ['success' => true, 'message' => 'Book deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete book'];
    }

    public function search($search_term, $genre = null, $year = null) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => 'Please log in first'];
        }

        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";
        $params = [$_SESSION['user_id']];

        if ($search_term) {
            $query .= " AND (title LIKE ? OR author LIKE ?)";
            $search_param = "%$search_term%";
            $params[] = $search_param;
            $params[] = $search_param;
        }

        if ($genre && $genre !== 'All') {
            $query .= " AND genre = ?";
            $params[] = $genre;
        }

        if ($year && $year !== 'All') {
            $query .= " AND year = ?";
            $params[] = $year;
        }

        $query .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['success' => true, 'books' => $books];
    }
}

// Handle requests
$database = new Database();
$db = $database->getConnection();
$database->createTables();

$books = new Books($db);

$method = $_SERVER['REQUEST_METHOD'];
$book_id = $_GET['id'] ?? null;

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $books->create($data);
        echo json_encode($result);
        break;

    case 'GET':
        $search = $_GET['search'] ?? null;
        $genre = $_GET['genre'] ?? null;
        $year = $_GET['year'] ?? null;

        if ($search || $genre || $year) {
            $result = $books->search($search, $genre, $year);
        } else {
            $result = $books->read($book_id);
        }
        echo json_encode($result);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $books->update($book_id, $data);
        echo json_encode($result);
        break;

    case 'DELETE':
        $result = $books->delete($book_id);
        echo json_encode($result);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
