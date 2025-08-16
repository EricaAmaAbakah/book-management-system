<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Magical Library - Cherub Library</title>
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="books/books.css">
    <link rel="stylesheet" href="styles/books.css">
    <link rel="stylesheet" href="styles/library.css">
</head>
<body style="background: linear-gradient(135deg, #fce7f3 0%, #ddd6fe 25%, #bfdbfe 50%, #ccfbf1 75%, #fef3c7 100%) !important; color: #2563eb; min-height: 100vh; position: relative;">
    <?php session_start(); ?>
        <style>
        .library-page-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #fce7f3 0%, #ddd6fe 25%, #bfdbfe 50%, #ccfbf1 75%, #fef3c7 100%) !important;
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
        <div class="library-page-container">
        <header class="library-header-nav">
            <div class="library-logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="library-nav">
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link active">📚 Books</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="/account" class="nav-link" id="accountNavLink">👤 Account<?php if(isset($_SESSION['user_name'])) echo " (" . htmlspecialchars($_SESSION['user_name']) . ")"; ?></a>
                    <a href="logout.php" class="nav-link">🚪 Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">🔑 Login</a>
                    <a href="signup.php" class="nav-link">✨ Sign Up</a>
                <?php endif; ?>
            </nav>
        </header>

        <div class="library-hero">
            <div class="floating-decorations">
                <span class="float-icon">🎀</span>
                <span class="float-icon">💖</span>
                <span class="float-icon">🌟</span>
                <span class="float-icon">🦋</span>
                <span class="float-icon">🌸</span>
            </div>
            <h1 class="library-main-title">Your Magical Library ✨</h1>
            <p class="library-subtitle">Discover wonderful stories in your kawaii collection</p>
        </div>

        <div class="library-controls" style="position: relative;">
            <div class="search-section">
                <div class="search-wrapper">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="searchInput" placeholder="Search by title or author..." class="library-search-input">
                </div>
            </div>
            <!-- Add Book button moved below genre and year filters -->

            <div class="filter-section">
                <div class="filter-group">
                    <label class="filter-label">Genre</label>
                    <select id="genreFilter" class="library-filter-select">
                        <option value="All">All Genres</option>
                        <option value="Romance">Romance</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Slice of Life">Slice of Life</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Year</label>
                    <select id="yearFilter" class="library-filter-select">
                        <option value="All">All Years</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                </div>
            </div>
            <div style="width:100%;display:flex;justify-content:center;margin-top:1.5rem;margin-bottom:1.2rem;">
                <a href="add-book.php" class="add-books-float-btn" title="Add Book" style="position:static;box-shadow:0 2px 8px rgba(0,0,0,0.10);font-size:1.1rem;">➕ Add Book</a>
            </div>
        </div>

        <div class="library-books-container">
            <div id="booksGrid" class="library-books-grid"></div>
            <div id="noResults" class="library-no-results" style="display: none;">
                <div class="no-results-icon">📚</div>
                <h3>No books found</h3>
                <p>Try adjusting your search or filters</p>
            </div>
        </div>

        <!-- Book Details Modal -->
        <div id="bookModal" class="library-modal-overlay" style="display: none;">
            <div class="library-modal compact-modal">
                <button class="library-modal-close" onclick="closeBookModal()">✕</button>
                <div class="library-modal-content">
                    <div class="library-modal-image">
                        <img id="modalImage" src="/placeholder.svg" alt="">
                    </div>
                    <div class="library-modal-details">
                        <div id="viewMode">
                            <h2 id="modalTitle" class="library-modal-title"></h2>
                            <p id="modalAuthor" class="library-modal-author"></p>
                            <div class="library-modal-meta">
                                <span id="modalGenre" class="modal-genre-tag"></span>
                                <span id="modalYear" class="modal-year-tag"></span>
                                <div class="modal-rating">
                                    <span class="stars">⭐</span>
                                    <span id="modalRating"></span>
                                </div>
                            </div>
                            <p id="modalDescription" class="library-modal-description"></p>
                            <div class="modal-actions">
                                <a id="modalReadLink" href="#" target="_blank" class="library-read-btn">Read Now ✨</a>
                                <button onclick="startEditMode()" class="library-edit-btn">Edit Details ✏️</button>
                            </div>
                        </div>

                        <div id="editMode" class="edit-form" style="display: none;">
                            <div class="edit-image-section">
                                <label class="edit-image-label">Book Cover</label>
                                <div class="edit-image-upload">
                                    <input type="file" accept="image/*" id="bookCoverUpload" class="edit-file-input">
                                    <label for="bookCoverUpload" class="edit-upload-btn">📷 Upload Cover</label>
                                    <div id="editImagePreview" class="edit-image-preview" style="display: none;">
                                        <img id="previewImage" src="/placeholder.svg" alt="Preview">
                                    </div>
                                </div>
                            </div>

                            <input type="text" id="editTitle" class="edit-input edit-title" placeholder="Book title">
                            <input type="text" id="editAuthor" class="edit-input edit-author" placeholder="Author name">
                            <div class="edit-row">
                                <select id="editGenre" class="edit-select">
                                    <option value="Romance">Romance</option>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Mystery">Mystery</option>
                                    <option value="Sci-Fi">Sci-Fi</option>
                                    <option value="Adventure">Adventure</option>
                                    <option value="Slice of Life">Slice of Life</option>
                                </select>
                                <input type="number" id="editYear" class="edit-input edit-year" min="1900" max="2024">
                            </div>
                            <input type="url" id="editLink" class="edit-input" placeholder="Book link">
                            <textarea id="editDescription" class="edit-textarea" placeholder="Book description" rows="3"></textarea>
                            <div class="edit-actions">
                                <button onclick="saveBookEdit()" class="save-btn">Save Changes ✨</button>
                                <button onclick="cancelEdit()" class="cancel-btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/library.js"></script>
<script>
let currentBookId = null;
function debugCurrentBook() {
    console.log("[v0] Current Book ID:", currentBookId);
    return currentBookId;
}
function openBookDetails(bookId) {
    console.log("[v0] Opening book details for ID:", bookId);
    if (!bookId || bookId === 'undefined' || bookId === 'null') {
        alert('Invalid book ID provided');
        console.log("[v0] Invalid book ID:", bookId);
        return;
    }
    currentBookId = parseInt(bookId);
    console.log("[v0] Set currentBookId to:", currentBookId);
    fetch(`api/get_book.php?id=${currentBookId}`)
        .then(response => response.json())
        .then(data => {
            console.log("[v0] API response:", data);
            if (data.success) {
                const book = data.book;
                document.getElementById('modalTitle').textContent = book.title;
                document.getElementById('modalAuthor').textContent = `by ${book.author}`;
                document.getElementById('modalGenre').textContent = book.genre;
                document.getElementById('modalYear').textContent = book.year;
                document.getElementById('modalDescription').textContent = book.description || 'No description available';
                document.getElementById('modalImage').src = book.image || '/placeholder.svg';
                document.getElementById('modalReadLink').href = book.link || '#';
                                document.getElementById('bookModal').style.display = 'flex';
                                // Re-trigger floatyPop animation for cuteness
                                const modal = document.querySelector('.library-modal.compact-modal');
                                if (modal) {
                                    modal.style.animation = 'none';
                                    // Force reflow
                                    void modal.offsetWidth;
                                    modal.style.animation = '';
                                }
            } else {
                alert('Error loading book: ' + data.message);
            }
        })
        .catch(error => {
            console.error('[v0] Error:', error);
            alert('Error loading book details');
        });
}
function startEditMode() {
    console.log("[v0] Starting edit mode, currentBookId:", currentBookId);
    if (!currentBookId) {
        alert('No book selected for editing. Please close and reopen the book details.');
        console.log("[v0] No currentBookId set");
        return;
    }
    fetch(`api/get_book.php?id=${currentBookId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const book = data.book;
                console.log("[v0] Loading book data for editing:", book);
                document.getElementById('editTitle').value = book.title || '';
                document.getElementById('editAuthor').value = book.author || '';
                document.getElementById('editGenre').value = book.genre || 'Romance';
                document.getElementById('editYear').value = book.year || '';
                document.getElementById('editLink').value = book.link || '';
                document.getElementById('editDescription').value = book.description || '';
                if (book.image) {
                    document.getElementById('previewImage').src = book.image;
                    document.getElementById('editImagePreview').style.display = 'block';
                }
                document.getElementById('viewMode').style.display = 'none';
                document.getElementById('editMode').style.display = 'block';
            } else {
                alert('Error loading book for editing: ' + data.message);
            }
        })
        .catch(error => {
            console.error('[v0] Error:', error);
            alert('Error loading book for editing');
        });
}
function saveBookEdit() {
    console.log("[v0] Attempting to save, currentBookId:", currentBookId);
    if (!currentBookId) {
        alert('No book selected for saving. Please close and reopen the book details.');
        console.log("[v0] Save failed: No currentBookId");
        return;
    }
    const title = document.getElementById('editTitle').value.trim();
    const author = document.getElementById('editAuthor').value.trim();
    console.log("[v0] Form data - Title:", title, "Author:", author);
    if (!title || !author) {
        alert('Title and Author are required fields');
        return;
    }
    const formData = new FormData();
    formData.append('id', currentBookId);
    formData.append('title', title);
    formData.append('author', author);
    formData.append('genre', document.getElementById('editGenre').value);
    formData.append('year', document.getElementById('editYear').value);
    formData.append('link', document.getElementById('editLink').value.trim());
    formData.append('description', document.getElementById('editDescription').value.trim());
    const coverFile = document.getElementById('bookCoverUpload').files[0];
    if (coverFile) {
        const reader = new FileReader();
        reader.onload = function(e) {
            formData.append('image', e.target.result);
            submitBookUpdate(formData);
        };
        reader.readAsDataURL(coverFile);
    } else {
        const existingImage = document.getElementById('previewImage').src;
        formData.append('image', existingImage);
        submitBookUpdate(formData);
    }
}
function submitBookUpdate(formData) {
    console.log("[v0] Submitting update for book ID:", currentBookId);
    fetch('api/update_book.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("[v0] Update response:", data);
        if (data.success) {
            alert('Book updated successfully!');
            cancelEdit();
            location.reload();
        } else {
            alert('Error updating book: ' + data.message);
        }
    })
    .catch(error => {
        console.error('[v0] Update error:', error);
        alert('Error saving book changes');
    });
}
function cancelEdit() {
    document.getElementById('viewMode').style.display = 'block';
    document.getElementById('editMode').style.display = 'none';
    document.getElementById('bookCoverUpload').value = '';
    document.getElementById('editImagePreview').style.display = 'none';
}
function closeBookModal() {
    document.getElementById('bookModal').style.display = 'none';
    cancelEdit();
    // Don't reset currentBookId here to maintain state
}
function deleteBook(bookId) {
    if (!confirm('Are you sure you want to delete this book?')) return;
    fetch('api/delete-book.php?id=' + bookId, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Book deleted!');
                location.reload();
            } else {
                alert('Delete failed: ' + data.message);
            }
        });
}
</script>
<script>
// Fallback: if /account returns 404, redirect to account.php
document.addEventListener('DOMContentLoaded', function() {
    var link = document.getElementById('accountNavLink');
    if (link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/account', {method: 'HEAD'}).then(function(resp) {
                if (resp.ok) {
                    window.location.href = '/account';
                } else {
                    window.location.href = 'account.php';
                }
            }).catch(function() {
                window.location.href = 'account.php';
            });
        });
    }
});
</script>
</body>
</html>
