<?php
require_once 'connection.php';

$editingBook = null;
$genreOptions = ["Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"];

// Handle add/edit/delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = $_POST['action'] ?? '';
	if ($action === 'add') {
		$stmt = $conn->prepare("INSERT INTO book (title, author, genre, year, image, link, rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
		$stmt = $conn->prepare("INSERT INTO book (title, author, genre, year, image, link, rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssissd",
			$_POST['title'],
			$_POST['author'],
			$_POST['genre'],
			$_POST['year'],
			$imagePath,
			$_POST['link'],
			$_POST['rating']
		);
		$stmt->execute();
		$stmt->close();
		header('Location: book-management.php');
		exit;
	}
	if ($action === 'edit') {
		$stmt = $conn->prepare("UPDATE book SET title=?, author=?, genre=?, year=?, image=?, link=?, rating=? WHERE id=?");
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
		if (empty($imagePath)) {
			$imagePath = $editingBook['image'];
		}
		$stmt = $conn->prepare("UPDATE book SET title=?, author=?, genre=?, year=?, image=?, link=?, rating=? WHERE id=?");
		$stmt->bind_param("sssissdi",
			$_POST['title'],
			$_POST['author'],
			$_POST['genre'],
			$_POST['year'],
			$imagePath,
			$_POST['link'],
			$_POST['rating'],
			$_POST['id']
		);
	$stmt->execute();
	header('Location: book-management.php');
	exit;
	}
	if ($action === 'delete') {
		$stmt = $conn->prepare("DELETE FROM book WHERE id=?");
		$stmt->bind_param("i", $_POST['id']);
		$stmt->execute();
		$stmt->close();
		header('Location: book-management.php');
		exit;
	}
}

// Fetch books
$books = [];
$result = $conn->query("SELECT * FROM book ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
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
?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Book Management</title>
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
							<a href="login.php" class="nav-link">🔑 Login</a>
							<a href="signup.php" class="nav-link">✨ Sign Up</a>
						</nav>
					</header>
					<main class="main-content">
						<div class="book-management-view" style="background-color: #e8f5e8; padding: 20px; border-radius: 15px; border: 3px solid #4ade80;">
							<div class="management-header">
								<div class="header-info">
									<h2>Manage Your Books ✨</h2>
									<p>Add, edit, or remove books from your collection</p>
								</div>
								<button class="add-book-btn" onclick="document.getElementById('bookFormOverlay').style.display='block';">
									<span class="btn-icon">➕</span>
									<span class="btn-text">Add New Book</span>
								</button>
							</div>
							<div id="bookFormOverlay" class="book-form-overlay" style="display:<?php echo ($editingBook || isset($_GET['edit'])) ? 'block' : 'none'; ?>;">
								<div class="book-form-container">
									<div class="form-header">
										<h3><?php echo $editingBook ? 'Edit Book 📝' : 'Add New Book ✨'; ?></h3>
										<button class="close-btn" onclick="document.getElementById('bookFormOverlay').style.display='none';">✕</button>
									</div>
									<form method="post" class="book-form">
										<input type="hidden" name="action" value="<?php echo $editingBook ? 'edit' : 'add'; ?>">
										<?php if ($editingBook) { echo '<input type="hidden" name="id" value="'.$editingBook['id'].'">'; } ?>
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
											<!-- Move script outside PHP logic -->
<script>
function openEditModal(bookId) {
	window.location.href = 'book-management.php?edit=' + bookId;
	setTimeout(function() {
		document.getElementById('bookFormOverlay').style.display = 'block';
	}, 200);
}
</script>
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
	// Ensure all fields are defined to avoid warnings
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
			<form method="get" style="display:inline;">
				<input type="hidden" name="edit" value="<?php echo $book['id']; ?>">
				<button type="submit" class="edit-btn">✏️ Edit</button>
			</form>
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
			</body>
			</html>
<!-- Toast Notification -->
<div id="toast" style="display:none;position:fixed;bottom:30px;right:30px;z-index:9999;background:#4ade80;color:#fff;padding:1rem 2rem;border-radius:12px;font-weight:600;box-shadow:0 4px 20px rgba(74,222,128,0.2);transition:all 0.3s ease;">Action successful!</div>
<script>
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

// Toast Notification
function showToast(e) {
	setTimeout(function() {
		document.getElementById('toast').style.display = 'block';
		setTimeout(function() {
			document.getElementById('toast').style.display = 'none';
		}, 2000);
	}, 100);
}
</script>
</body>
</html>
