<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book - Cherub Library</title>
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="styles/books.css">
    <link rel="stylesheet" href="add books/add-books.css">
    <link rel="stylesheet" href="styles/library.css">
</head>
<body>
        <style>
        body {
            background: linear-gradient(135deg, #fce7f3 0%, #ddd6fe 25%, #bfdbfe 50%, #ccfbf1 75%, #fef3c7 100%) !important;
            color: #2563eb;
            min-height: 100vh;
            position: relative;
        }
        .add-books-page-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #fce7f3 0%, #ddd6fe 25%, #bfdbfe 50%, #ccfbf1 75%, #fef3c7 100%);
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at 20% 80%, rgba(255, 182, 193, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(173, 216, 230, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 224, 0.3) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        </style>
        <div class="add-books-page-container">
    <header class="add-books-header-nav">
            <div class="library-logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="library-nav">
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link">📚 Books</a>
                <a href="account.php" class="nav-link">👤 Account</a>
                <a href="logout.php" class="nav-link">🚪 Logout</a>
            </nav>
        </header>
        <main class="main-content">
            <div class="add-book-form-container">
                <div class="form-header">
                    <h2 class="form-title">Add a New Book</h2>
                    <p class="form-description">Fill in the details to add a book to your collection</p>
                </div>
                <form action="add-book.php" method="post" enctype="multipart/form-data" class="add-book-form-modern">
                    <div class="form-group">
                        <label for="title">Book Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Choose a genre</option>
                            <option value="Romance">Romance</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                            <option value="Slice of Life">Slice of Life</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year Published</label>
                        <input type="number" id="year" name="year" min="1900" max="2024" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Book Cover</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="link">Book Link</label>
                        <input type="url" id="link" name="link" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating (1-5)</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" step="0.1">
                    </div>
                    <button type="submit" class="primary-btn">Add Book</button>
                                </form>
                                <script>
                                document.querySelector('.add-book-form-modern').addEventListener('submit', async function(e) {
                                    e.preventDefault();
                                    const form = e.target;
                                    const formData = new FormData(form);
                                    const data = Object.fromEntries(formData.entries());
                                    // Convert year and rating to numbers
                                    if (data.year) data.year = Number(data.year);
                                    if (data.rating) data.rating = Number(data.rating);
                                    // Handle image upload (base64)
                                    const imageInput = form.querySelector('input[type="file"][name="image"]');
                                    if (imageInput && imageInput.files && imageInput.files[0]) {
                                        const file = imageInput.files[0];
                                        const reader = new FileReader();
                                        reader.onload = async function(evt) {
                                            data.image = evt.target.result;
                                            await submitBook(data);
                                        };
                                        reader.readAsDataURL(file);
                                    } else {
                                        await submitBook(data);
                                    }
                                    async function submitBook(bookData) {
                                        const response = await fetch('api/books.php', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify(bookData)
                                        });
                                        const result = await response.json();
                                        if (result.success) {
                                            alert('Book added successfully!');
                                            window.location.href = 'books.php';
                                        } else {
                                            alert('Failed to add book: ' + result.message);
                                        }
                                    }
                                });
                                </script>
            </div>
        </main>
    </div>
</body>
</html>
