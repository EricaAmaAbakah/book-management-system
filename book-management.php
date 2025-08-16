<?php session_start(); ?>
<?php
include 'config/database.php';

$editingBook = null;
$genreOptions = ["Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"];

// Handle add/edit/delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? ''; 
    if ($action === 'add') {
        $imagePath = '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid('book_', true) . '.' . pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            }
        }
        $stmt = $pdo->prepare("INSERT INTO book (title, author, genre, year, image, link, rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['author'],
            $_POST['genre'],
            $_POST['year'],
            $imagePath,
            $_POST['link'],
            $_POST['rating']
        ]);
        header('Location: book-management.php');
        exit;
    }
    if ($action === 'edit') {
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid('book_', true) . '.' . pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            }
        }
        $stmt = $pdo->prepare("UPDATE book SET title=?, author=?, genre=?, year=?, image=?, link=?, rating=? WHERE id=?");
        $stmt->execute([
            $_POST['title'],
            $_POST['author'],
            $_POST['genre'],
            $_POST['year'],
            $imagePath,
            $_POST['link'],
            $_POST['rating'],
            $_POST['id']
        ]);
        header('Location: book-management.php');
        exit;
    }
    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM book WHERE id=?");
        $stmt->execute([$_POST['id']]);
        header('Location: book-management.php');
        exit;
    }
}

// Fetch books
$books = [];
$stmt = $pdo->query("SELECT * FROM book ORDER BY id DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $books[] = $row;
}

// Editing book
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    foreach ($books as $b) {
        if ($b['id'] == $editId) {
            $editingBook = $b;
            break;
        }
    }
}

// Calculate next available Book ID for new books
$nextBookId = 1;
if (!empty($books)) {
    $ids = array_map('intval', array_column($books, 'id'));
    $maxId = max($ids);
    $nextBookId = $maxId + 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management - Cherub Library</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="book-management.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link">📚 Books</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="account.php" class="nav-link">👤 Account (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a>
                    <span class="nav-user-fullname" style="margin-left:8px;font-weight:bold;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                    <a href="logout.php" class="nav-link">🚪 Logout</a>
                    <?php if(isset($_SESSION['profile_pic'])): ?>
                        <img src="images/<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile" style="height:30px;vertical-align:middle;border-radius:50%;margin-left:8px;">
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php" class="nav-link">🔑 Login</a>
                    <a href="signup.php" class="nav-link">✨ Sign Up</a>
                <?php endif; ?>
            </nav>
        </header>
        <main class="main-content">
            <div class="book-management-view" style="background-color: #e8f5e8; padding: 20px; border-radius: 15px; border: 3px solid #4ade80;">
                <div class="management-header">
                    <div class="header-info">
                        <h2>Manage Your Books ✨</h2>
                        <p>Add, edit, or remove books from your collection</p>
                    </div>
                    <a href="/add-books/add-book-page" class="add-book-btn" style="background: #10b981; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; display: inline-block;">
                        <span class="btn-icon">➕</span>
                        <span class="btn-text">Add New Book</span>
                    </a>
                    <a href="/add%20books" class="add-book-btn" style="margin-left: 1rem; background: #6366f1; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; display: inline-block;">
                        <span class="btn-icon">📝</span>
                        <span class="btn-text">React Add Books Page</span>
                    </a>
                </div>
                <div id="bookFormOverlay" class="book-form-overlay" style="display:<?php echo ($editingBook || isset($_GET['edit'])) ? 'block' : 'none'; ?>;">
                    <div class="book-form-container">
                        <div class="form-header">
                            <h3><?php echo $editingBook ? 'Edit Book 📝' : 'Add New Book ✨'; ?></h3>
                            <button class="close-btn" onclick="document.getElementById('bookFormOverlay').style.display='none';">✕</button>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="book-form">
                            <input type="hidden" name="action" value="<?php echo $editingBook ? 'edit' : 'add'; ?>">
                            <?php if ($editingBook && isset($editingBook['id'])): ?>
                                <div class="form-group">
                                    <label>🆔 Book ID</label>
                                    <input type="text" name="id" value="<?php echo htmlspecialchars($editingBook['id']); ?>" readonly />
                                </div>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingBook['id']); ?>">
                                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editingBook['image'] ?? ''); ?>">
                            <?php else: ?>
                                <div class="form-group">
                                    <label>🆔 Book ID</label>
                                    <input type="text" value="<?php echo $nextBookId; ?>" readonly />
                                </div>
                            <?php endif; ?>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>📖 Book Title</label>
                                    <input type="text" name="title" value="<?php echo isset($editingBook['title']) ? htmlspecialchars($editingBook['title']) : ''; ?>" placeholder="Enter book title..." required />
                                </div>
                                <div class="form-group">
                                    <label>✍️ Author</label>
                                    <input type="text" name="author" value="<?php echo isset($editingBook['author']) ? htmlspecialchars($editingBook['author']) : ''; ?>" placeholder="Enter author name..." required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>📚 Genre</label>
                                    <select name="genre" required>
                                        <?php foreach ($genreOptions as $g) {
                                            $selected = (isset($editingBook['genre']) && $editingBook['genre'] === $g) ? 'selected' : '';
                                            echo "<option value='$g' $selected>$g</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>📅 Year Published</label>
                                    <input type="number" name="year" value="<?php echo isset($editingBook['year']) ? htmlspecialchars($editingBook['year']) : date('Y'); ?>" min="1000" max="2100" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>🖼️ Book Cover</label>
                                <input type="file" name="image_file" accept="image/*" onchange="previewImage(event)" />
                                <div id="imagePreviewContainer" class="image-preview-container">
                                    <?php if ($editingBook && $editingBook['image']) {
                                        echo '<img src="'.htmlspecialchars($editingBook['image']).'" alt="Book cover preview" class="image-preview" /><span class="preview-text">Preview</span>';
                                    } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>🔗 Book Link</label>
                                <input type="url" name="link" value="<?php echo isset($editingBook['link']) ? htmlspecialchars($editingBook['link']) : ''; ?>" placeholder="https://example.com/read-book" required />
                            </div>
                            <div class="form-group">
                                <label>⭐ Rating (1-5)</label>
                                <input type="number" name="rating" value="<?php echo isset($editingBook['rating']) ? htmlspecialchars($editingBook['rating']) : '4.0'; ?>" min="1" max="5" step="0.1" />
                            </div>
                            <div class="form-actions">
                                <button type="button" class="cancel-btn" onclick="document.getElementById('bookFormOverlay').style.display='none';">Cancel</button>
                                <button type="submit" class="submit-btn"><?php echo $editingBook ? 'Update Book 💖' : 'Add Book ✨'; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="books-management-section">
                    <div class="section-header">
                        <h3>Your Book Collection</h3>
                        <div class="collection-count">
                            <span class="count-number"><?php echo count($books); ?></span>
                            <span class="count-text">books total</span>
                        </div>
                    </div>
                    <div class="management-books-grid">
<?php foreach ($books as $book):
    $bookTitle = isset($book['title']) ? $book['title'] : '';
    $bookAuthor = isset($book['author']) ? $book['author'] : '';
    $bookGenre = isset($book['genre']) ? $book['genre'] : '';
    $bookYear = isset($book['year']) ? $book['year'] : '';
    $bookImage = !empty($book['image']) ? $book['image'] : '/placeholder.svg';
    $bookRating = isset($book['rating']) ? $book['rating'] : '';
?>
    <div class="management-book-card">
        <div class="book-cover-small">
            <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="<?php echo htmlspecialchars($bookTitle); ?>" />
        </div>
        <div class="book-details">
            <h4><?php echo htmlspecialchars($bookTitle); ?></h4>
            <p>by <?php echo htmlspecialchars($bookAuthor); ?></p>
            <div class="book-meta-small">
                <span><?php echo htmlspecialchars($bookGenre); ?></span>
                <span><?php echo htmlspecialchars($bookYear); ?></span>
                <span>⭐ <?php echo htmlspecialchars($bookRating); ?></span>
            </div>
        </div>
        <div class="book-actions">
            <button onclick="window.location.href='book-management.php?edit=<?php echo $book['id']; ?>'" class="library-edit-btn">Edit Details ✏️</button>
            <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book? 🥺');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <button type="submit" class="delete-btn">🗑️ Delete</button>
            </form>
        </div>
    </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
function openEditModal(bookId) {
    window.location.href = 'book-management.php?edit=' + bookId;
}

// Live Image Preview
function previewImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview';
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Floating Decorations Animation
document.querySelectorAll('.float-icon').forEach(function(icon, i) {
    icon.style.position = 'absolute';
    icon.style.left = (10 + i * 60) + 'px';
    icon.style.top = (10 + Math.sin(i) * 30) + 'px';
    icon.animate([
        { transform: 'translateY(0px)' },
        { transform: 'translateY(-15px)' },
        { transform: 'translateY(0px)' }
    ], {
        duration: 2000 + i * 300,
        iterations: Infinity
    });
});
</script>
</body>
</html>
