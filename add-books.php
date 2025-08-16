<?php
session_start();
$genreOptions = ["Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"];
$books = [
  [ 'id' => 1, 'title' => 'Kawaii Love Story', 'author' => 'Sakura Tanaka', 'genre' => 'Romance', 'year' => 2023, 'image' => '/cute-pink-book-cover.png', 'link' => 'https://example.com/kawaii-love', 'rating' => 4.8 ],
  [ 'id' => 2, 'title' => 'Ocean Dreams', 'author' => 'Marina Blue', 'genre' => 'Fantasy', 'year' => 2022, 'image' => '/blue-ocean-fantasy-book.png', 'link' => 'https://example.com/ocean-dreams', 'rating' => 4.9 ],
  [ 'id' => 3, 'title' => 'Sunny Adventures', 'author' => 'Ray Sunshine', 'genre' => 'Adventure', 'year' => 2024, 'image' => '/yellow-sunny-adventure-book.png', 'link' => 'https://example.com/sunny-adventures', 'rating' => 4.7 ],
  [ 'id' => 4, 'title' => 'Magical Forest', 'author' => 'Luna Green', 'genre' => 'Fantasy', 'year' => 2021, 'image' => '/green-magical-forest-book.png', 'link' => 'https://example.com/magical-forest', 'rating' => 4.6 ],
  [ 'id' => 5, 'title' => 'City Lights', 'author' => 'Neon Purple', 'genre' => 'Drama', 'year' => 2023, 'image' => '/purple-city-lights-book.png', 'link' => 'https://example.com/city-lights', 'rating' => 4.5 ],
  [ 'id' => 6, 'title' => 'Cozy Café Tales', 'author' => 'Mocha Brown', 'genre' => 'Comedy', 'year' => 2022, 'image' => '/cozy-brown-cafe-book.png', 'link' => 'https://example.com/cozy-cafe', 'rating' => 4.4 ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add & Manage Books - Cherub Library</title>
  <link rel="stylesheet" href="./books.css">
</head>
<body>
  <div class="books-page">
    <header class="header">
      <div class="profile-section">
        <a href="/account" class="profile-link">
          <div class="profile-avatar">
            <img src="/cute-anime-girl-avatar.png" alt="Profile" class="avatar-img">
          </div>
          <div class="profile-info">
            <span class="profile-name">Kawaii Reader</span>
            <span class="profile-status">📚 Reading</span>
          </div>
        </a>
      </div>
      <div class="logo">
        <div class="logo-icon">🌸</div>
        <div class="logo-text">
          <h1>Cherub Library</h1>
          <p>Save books you love ♡</p>
        </div>
      </div>
      <nav class="nav">
        <a href="/" class="nav-link">🏠 Home</a>
        <a href="/library" class="nav-link">📚 Library</a>
        <a href="/add-books" class="nav-link active">➕ Add Books</a>
        <a href="/account" class="nav-link">👤 Account</a>
      </nav>
    </header>
    <div class="floating-tabs">
      <a href="library.php" class="tab-button">
        <span class="tab-icon">📚</span>
        <span class="tab-text">Access Your Library</span>
      </a>
      <a href="add-books.php" class="tab-button active">
        <span class="tab-icon">➕</span>
        <span class="tab-text">Add New Book</span>
      </a>
      <a href="book-management.php" class="tab-button">
        <span class="tab-icon">🛠️</span>
        <span class="tab-text">Manage Books</span>
      </a>
    </div>
      <div class="book-management-container">
        <div class="management-header" style="text-align:center; margin-top:2rem;">
          <h1 class="management-title">➕ Add & Manage Books ✨</h1>
          <p class="management-subtitle">Add, edit, or remove books from your collection</p>
        </div>
        <!-- Add/Edit Book Modal (matches book-management.php style) -->
        <div id="addBookModal" class="book-form-overlay" style="display:none;">
          <div class="book-form-container">
            <div class="form-header">
              <h3>Add New Book ✨</h3>
              <button class="close-btn" onclick="document.getElementById('addBookModal').style.display='none'">✕</button>
            </div>
            <form class="book-form" method="post" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-group">
                  <label>📖 Book Title</label>
                  <input type="text" name="title" placeholder="Enter book title..." required />
                </div>
                <div class="form-group">
                  <label>✍️ Author</label>
                  <input type="text" name="author" placeholder="Enter author name..." required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>📚 Genre</label>
                  <select name="genre" required>
                    <option value="">Select genre...</option>
                    <?php foreach ($genreOptions as $genre): ?>
                      <option value="<?= htmlspecialchars($genre) ?>"><?= htmlspecialchars($genre) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>📅 Year Published</label>
                  <input type="number" name="year" placeholder="2024" min="1900" max="2024" required />
                </div>
              </div>
              <div class="form-group">
                <label>🖼️ Book Cover</label>
                <input type="file" name="image" accept="image/*" />
              </div>
              <div class="form-group">
                <label>🔗 Book Link</label>
                <input type="url" name="link" placeholder="https://example.com/book-link" required />
              </div>
              <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="document.getElementById('addBookModal').style.display='none'">Cancel</button>
                <button type="submit" class="submit-btn">Add Book ✨</button>
              </div>
            </form>
          </div>
        </div>
        <button class="add-book-btn" onclick="document.getElementById('addBookModal').style.display='flex'">
          <span class="btn-icon">➕</span>
          <span class="btn-text">Add New Book</span>
        </button>
        <div class="books-management-section">
          <div class="section-header">
            <h3>Your Book Collection</h3>
            <div class="collection-count">
              <span class="count-number"><?php echo count($books); ?></span>
              <span class="count-text">books total</span>
            </div>
          </div>
          <div class="management-books-grid">
            <?php foreach ($books as $book): ?>
            <div class="management-book-card">
              <div class="book-cover-small">
                <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" />
              </div>
              <div class="book-details">
                <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                <p>by <?php echo htmlspecialchars($book['author']); ?></p>
                <div class="book-meta-small">
                  <span><?php echo htmlspecialchars($book['genre']); ?></span>
                  <span><?php echo $book['year']; ?></span>
                  <span>⭐ <?php echo $book['rating']; ?></span>
                </div>
              </div>
              <div class="book-actions">
                <button class="view-btn" onclick='viewBookDetails(<?php echo json_encode($book); ?>)'>👁️ View</button>
                <button class="edit-btn" onclick='editBook(<?php echo json_encode($book); ?>)'>✏️ Edit</button>
                <form method="post" style="display:inline;">
                  <input type="hidden" name="delete_id" value="<?php echo $book['id']; ?>">
                  <button type="submit" class="delete-btn">🗑️ Delete</button>
                </form>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- Book Details Modal -->
        <div id="bookDetailsModal" class="book-details-overlay" style="display:none;">
          <div class="book-details-modal">
            <button class="modal-close-btn" onclick="closeBookDetails()">✕</button>
            <div class="modal-content">
              <div class="modal-book-cover">
                <img id="modalBookImage" src="" alt="Book Cover" />
              </div>
              <div class="modal-book-info">
                <div class="modal-header">
                  <h2 class="modal-title" id="modalBookTitle"></h2>
                </div>
                <div class="modal-author">
                  <span class="author-label">✍️ Author:</span>
                  <span class="author-name" id="modalBookAuthor"></span>
                </div>
                <div class="modal-genre">
                  <span class="genre-label">Genre:</span>
                  <span class="genre-value" id="modalBookGenre"></span>
                </div>
                <div class="modal-year">
                  <span class="year-label">Year:</span>
                  <span class="year-value" id="modalBookYear"></span>
                </div>
                <div class="modal-link">
                  <a id="modalBookLink" href="#" target="_blank">Read More</a>
                </div>
                <div class="modal-rating">
                  <span class="rating-label">⭐ Rating:</span>
                  <span class="rating-value" id="modalBookRating"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>
</html>
  if (isset($form['delete_id'])) {
    $books = array_filter($books, function($b) use ($form) { return $b['id'] != $form['delete_id']; });
  } else {
    $newBook = [
      "id" => isset($form['edit_id']) ? intval($form['edit_id']) : (count($books) ? max(array_column($books, 'id')) + 1 : 1),
      "title" => $form['title'],
      "author" => $form['author'],
      "genre" => $form['genre'],
      "year" => intval($form['year']),
      "image" => $form['image'] ?: "/placeholder.svg",
      "link" => $form['link'],
      "rating" => floatval($form['rating']),
    ];
    if (isset($form['edit_id'])) {
      foreach ($books as &$b) {
        if ($b['id'] == $form['edit_id']) $b = $newBook;
      }
    } else {
      $books[] = $newBook;
    }
  }
  $_SESSION['books'] = $books;
  header('Location: add-books.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Books</title>
  <link rel="stylesheet" href="books.css">
</head>
<body>
<div class="book-management-view" style="background-color: #e8f5e8; padding: 20px; border-radius: 15px; border: 3px solid #4ade80; max-width: 900px; margin: 2rem auto;">
  <div class="management-header">
    <div class="header-info">
      <h2>Manage Your Books ✨</h2>
      <p>Add, edit, or remove books from your collection</p>
    </div>
    <button onclick="document.getElementById('addBookForm').style.display='block';document.getElementById('edit_id').value='';">➕ Add New Book</button>
  </div>

  <div id="addBookForm" style="display:none; margin-top:2rem;">
    <form method="post" class="book-form" style="background:#fff; padding:2rem; border-radius:15px;">
      <input type="hidden" name="edit_id" id="edit_id" value="">
      <div class="form-row">
        <div class="form-group">
          <label>📖 Book Title</label>
          <input type="text" name="title" id="form_title" required>
        </div>
        <div class="form-group">
          <label>✍️ Author</label>
          <input type="text" name="author" id="form_author" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>📚 Genre</label>
          <select name="genre" id="form_genre">
            <?php foreach ($genreOptions as $g): ?><option value="<?php echo $g; ?>"><?php echo $g; ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>📅 Year Published</label>
          <input type="number" name="year" id="form_year" min="1000" max="<?php echo date('Y')+10; ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label>🖼️ Book Cover Image URL</label>
        <input type="text" name="image" id="form_image">
      </div>
      <div class="form-group">
        <label>🔗 Book Link</label>
        <input type="url" name="link" id="form_link" required>
      </div>
      <div class="form-group">
        <label>⭐ Rating (1-5)</label>
        <input type="number" name="rating" id="form_rating" min="1" max="5" step="0.1">
      </div>
      <div class="form-actions">
        <button type="button" onclick="document.getElementById('addBookForm').style.display='none';">Cancel</button>
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>

  <div class="books-management-section" style="margin-top:2rem;">
    <div class="section-header">
      <h3>Your Book Collection</h3>
      <div class="collection-count">
        <span class="count-number"><?php echo count($books); ?></span>
        <span class="count-text">books total</span>
      </div>
    </div>
    <div class="management-books-grid">
      <?php foreach ($books as $book): ?>
      <div class="management-book-card" style="background:#fff; border-radius:15px; margin-bottom:1rem; padding:1rem; display:flex; gap:1rem; align-items:center;">
        <div class="book-cover-small" style="width:80px;">
          <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" style="width:100%; border-radius:10px;">
        </div>
        <div class="book-details" style="flex:1;">
          <h4><?php echo htmlspecialchars($book['title']); ?></h4>
          <p>by <?php echo htmlspecialchars($book['author']); ?></p>
          <div class="book-meta-small">
            <span><?php echo htmlspecialchars($book['genre']); ?></span>
            <span><?php echo $book['year']; ?></span>
            <span>⭐ <?php echo $book['rating']; ?></span>
          </div>
        </div>
        <div class="book-actions" style="display:flex; flex-direction:column; gap:0.5rem;">
          <form method="post" style="display:inline;">
            <input type="hidden" name="delete_id" value="<?php echo $book['id']; ?>">
            <button type="submit" class="delete-btn">🗑️ Delete</button>
          </form>
          <button class="edit-btn" onclick='editBook(<?php echo json_encode($book); ?>)'>✏️ Edit</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<script>
function editBook(book) {
  document.getElementById('addBookModal').style.display = 'flex';
  document.querySelector('input[name="title"]').value = book.title;
  document.querySelector('input[name="author"]').value = book.author;
  document.querySelector('select[name="genre"]').value = book.genre;
  document.querySelector('input[name="year"]').value = book.year;
  document.querySelector('input[name="image"]').value = book.image;
  document.querySelector('input[name="link"]').value = book.link;
  document.querySelector('input[name="rating"]').value = book.rating;
}
function viewBookDetails(book) {
  document.getElementById('bookDetailsModal').style.display = 'flex';
  document.getElementById('modalBookTitle').textContent = book.title;
  document.getElementById('modalBookAuthor').textContent = book.author;
  document.getElementById('modalBookGenre').textContent = book.genre;
  document.getElementById('modalBookYear').textContent = book.year;
  document.getElementById('modalBookImage').src = book.image;
  document.getElementById('modalBookLink').href = book.link;
  document.getElementById('modalBookRating').textContent = book.rating;
}
function closeBookDetails() {
  document.getElementById('bookDetailsModal').style.display = 'none';
}
</script>
</body>
</html>
$books = [
  [
    'id' => 1,
    'title' => 'Kawaii Love Story',
    'author' => 'Sakura Tanaka',
    'genre' => 'Romance',
    'year' => 2023,
    'image' => '/cute-pink-book-cover.png',
    'link' => 'https://example.com/kawaii-love',
    'rating' => 4.8,
  ],
  [
    'id' => 2,
    'title' => 'Ocean Dreams',
    'author' => 'Marina Blue',
    'genre' => 'Fantasy',
    'year' => 2022,
    'image' => '/blue-ocean-fantasy-book.png',
    'link' => 'https://example.com/ocean-dreams',
    'rating' => 4.9,
  ],
  [
    'id' => 3,
    'title' => 'Sunny Adventures',
    'author' => 'Ray Sunshine',
    'genre' => 'Adventure',
    'year' => 2024,
    'image' => '/yellow-sunny-adventure-book.png',
    'link' => 'https://example.com/sunny-adventures',
    'rating' => 4.7,
  ],
  [
    'id' => 4,
    'title' => 'Magical Forest',
    'author' => 'Luna Green',
    'genre' => 'Fantasy',
    'year' => 2021,
    'image' => '/green-magical-forest-book.png',
    'link' => 'https://example.com/magical-forest',
    'rating' => 4.6,
  ],
  [
    'id' => 5,
    'title' => 'City Lights',
    'author' => 'Neon Purple',
    'genre' => 'Drama',
    'year' => 2023,
    'image' => '/purple-city-lights-book.png',
    'link' => 'https://example.com/city-lights',
    'rating' => 4.5,
  ],
  [
    'id' => 6,
    'title' => 'Cozy Café Tales',
    'author' => 'Mocha Brown',
    'genre' => 'Comedy',
    'year' => 2022,
    'image' => '/cozy-brown-cafe-book.png',
    'link' => 'https://example.com/cozy-cafe',
    'rating' => 4.4,
  ],
];
$genreOptions = ["Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"];
?>
      <div class="container">
        <div class="header-content">
          <div class="logo">
            <div class="logo-icon"><img src="/book-open.svg" alt="BookOpen" style="width:40px;height:40px;vertical-align:middle;" /></div>
            <div class="logo-text">
              <h1>Serenity Library</h1>
              <p>Where stories come alive</p>
            </div>
          </div>
          <nav class="nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="books.php" class="nav-link active">Catalog</a>
            <a href="#events" class="nav-link">Events</a>
            <a href="#services" class="nav-link">Services</a>
            <a href="#about" class="nav-link">About</a>
          </nav>
        </div>
      </div>
    </header>
    <div class="floating-tabs-container">
      <div class="floating-tabs">
        <a href="library.php" class="tab-button">
          <span class="tab-icon">📚</span>
          <span class="tab-text">Access Your Library</span>
        </a>
      <a href="add-books.php" class="tab-button">
          <span class="tab-icon">➕</span>
          <span class="tab-text">Add New Book</span>
        </a>
      </div>
    </div>
    <main class="books-main-content">
      <div class="content-wrapper">
        <div class="book-management-view">
          <div class="management-header">
            <div class="header-info">
              <h2>Manage Your Books ✨</h2>
              <p>Add, edit, or remove books from your collection</p>
            </div>
            <button class="add-book-btn" onclick="document.getElementById('addBookModal').style.display='flex'">
              <span class="btn-icon">➕</span>
              <span class="btn-text">Add New Book</span>
            </button>
          </div>
          <!-- Add/Edit Book Modal -->
          <div id="addBookModal" class="book-form-overlay" style="display:none;">
            <div class="book-form-container">
              <div class="form-header">
                <h3>Add New Book ✨</h3>
                <button class="close-btn" onclick="document.getElementById('addBookModal').style.display='none'">✕</button>
              </div>
              <form class="book-form">
                <div class="form-row">
                  <div class="form-group">
                    <label>📖 Book Title</label>
                    <input type="text" placeholder="Enter book title..." required />
                  </div>
                  <div class="form-group">
                    <label>✍️ Author</label>
                    <input type="text" placeholder="Enter author name..." required />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>📚 Genre</label>
                    <select>
                      <?php foreach ($genreOptions as $genre): ?>
                        <option><?php echo $genre; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>📅 Year Published</label>
                    <input type="number" min="1000" max="2035" required />
                  </div>
                </div>
                <div class="form-group">
                  <label>🖼️ Book Cover Image URL</label>
                  <input type="url" placeholder="https://example.com/book-cover.jpg" />
                </div>
                <div class="form-group">
                  <label>🔗 Book Link</label>
                  <input type="url" placeholder="https://example.com/read-book" required />
                </div>
                <div class="form-group">
                  <label>⭐ Rating (1-5)</label>
                  <input type="number" min="1" max="5" step="0.1" />
                </div>
                <div class="form-actions">
                  <button type="button" class="cancel-btn" onclick="document.getElementById('addBookModal').style.display='none'">Cancel</button>
                  <button type="submit" class="submit-btn">Add Book ✨</button>
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
              <?php foreach ($books as $book): ?>
              <div class="management-book-card">
                <div class="book-cover-small">
                  <img src="<?php echo $book['image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" />
                </div>
                <div class="book-details">
                  <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                  <p>by <?php echo htmlspecialchars($book['author']); ?></p>
                  <div class="book-meta-small">
                    <span><?php echo htmlspecialchars($book['genre']); ?></span>
                    <span><?php echo $book['year']; ?></span>
                    <span>⭐ <?php echo $book['rating']; ?></span>
                  </div>
                </div>
                <div class="book-actions">
                  <button class="view-btn" onclick='viewBookDetails(<?php echo json_encode($book); ?>)'>👁️ View</button>
                  <button class="edit-btn">✏️ Edit</button>
                  <button class="delete-btn">🗑️ Delete</button>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Book Details Modal -->
      <div id="bookDetailsModal" class="book-details-overlay" style="display:none;">
        <div class="book-details-modal">
          <button class="modal-close-btn" onclick="closeBookDetails()">✕</button>
          <div class="modal-content">
            <div class="modal-book-cover">
              <img id="modalBookImage" src="" alt="Book Cover" />
            </div>
            <div class="modal-book-info">
              <div class="modal-header">
                <h2 class="modal-title" id="modalBookTitle"></h2>
              </div>
              <div class="modal-author">
                <span class="author-label">✍️ Author:</span>
                <span class="author-name" id="modalBookAuthor"></span>
              </div>
              <div class="modal-genre">
                <span class="genre-label">Genre:</span>
                <span class="genre-value" id="modalBookGenre"></span>
              </div>
              <div class="modal-year">
                <span class="year-label">Year:</span>
                <span class="year-value" id="modalBookYear"></span>
              </div>
              <div class="modal-link">
                <a id="modalBookLink" href="#" target="_blank">Read More</a>
              </div>
              <div class="modal-rating">
                <span class="rating-label">⭐ Rating:</span>
                <span class="rating-value" id="modalBookRating"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
<script>
function viewBookDetails(book) {
  document.getElementById('bookDetailsModal').style.display = 'flex';
  document.getElementById('modalBookTitle').textContent = book.title;
  document.getElementById('modalBookAuthor').textContent = book.author;
  document.getElementById('modalBookGenre').textContent = book.genre;
  document.getElementById('modalBookYear').textContent = book.year;
  document.getElementById('modalBookImage').src = book.image;
  document.getElementById('modalBookLink').href = book.link;
  document.getElementById('modalBookRating').textContent = book.rating;
}
function closeBookDetails() {
  document.getElementById('bookDetailsModal').style.display = 'none';
}
</script>
</body>
</html>
