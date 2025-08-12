<?php
// Manage Books Page
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
        <a href="manage-books.php" class="tab-button">
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
