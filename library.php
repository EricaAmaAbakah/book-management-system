<?php
// Access Your Library Page
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Your Library - Serenity Library</title>
  <link rel="stylesheet" href="books.css">
</head>
<body>
  <div class="books-page gradient-bg">
    <header class="header">
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
        <div class="library-controls">
          <div class="search-section">
            <div class="search-container">
              <div class="search-icon">🔍</div>
              <input type="text" placeholder="Search by title or author..." class="search-input" />
            </div>
          </div>
          <div class="filters-section">
            <div class="filter-group">
              <label class="filter-label">📚 Genre</label>
              <select class="filter-select">
                <option>All</option>
                <option>Romance</option>
                <option>Fantasy</option>
                <option>Mystery</option>
                <option>Sci-Fi</option>
                <option>Adventure</option>
                <option>Drama</option>
                <option>Comedy</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">📅 Year</label>
              <select class="filter-select">
                <option>All</option>
                <option>2024</option>
                <option>2023</option>
                <option>2022</option>
                <option>2021</option>
                <option>2020</option>
                <option>2019</option>
                <option>2018</option>
              </select>
            </div>
          </div>
        </div>
        <div class="books-display">
          <div class="section-header">
            <h2>Your Kawaii Collection ♡</h2>
            <div class="book-count">
              <span class="count-number"><?php echo count($books); ?></span>
              <span class="count-text">books found</span>
            </div>
          </div>
          <div class="books-grid">
            <?php foreach ($books as $book): ?>
            <div class="book-card book-card-tiny" onclick="showDetails('<?php echo addslashes($book['title']); ?>','<?php echo addslashes($book['author']); ?>','<?php echo addslashes($book['genre']); ?>','<?php echo $book['year']; ?>','<?php echo $book['image']; ?>','<?php echo $book['link']; ?>')">
              <div class="book-cover-container">
                <img src="<?php echo $book['image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover" />
                <div class="book-overlay">
                  <button class="view-details-button">View Details</button>
                </div>
              </div>
              <div class="book-info">
                <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                <p class="book-author">by <?php echo htmlspecialchars($book['author']); ?></p>
                <span class="book-genre"><?php echo htmlspecialchars($book['genre']); ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- Book Details Modal -->
        <div id="bookDetailsModal" class="book-details-overlay" style="display:none;">
          <div class="book-details-modal">
            <button class="modal-close-btn" onclick="closeDetails()">✕</button>
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
                <div class="modal-details">
                  <div class="detail-item">
                    <span class="detail-label">📚 Genre:</span>
                    <span class="detail-value" id="modalBookGenre"></span>
                  </div>
                  <div class="detail-item">
                    <span class="detail-label">📅 Published:</span>
                    <span class="detail-value" id="modalBookYear"></span>
                  </div>
                </div>
                <div class="modal-actions">
                  <a id="modalBookLink" href="#" target="_blank" rel="noopener noreferrer" class="read-now-btn">📖 Read Now</a>
                  <button class="close-modal-btn" onclick="closeDetails()">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          function showDetails(title, author, genre, year, image, link) {
            document.getElementById('bookDetailsModal').style.display = 'flex';
            document.getElementById('modalBookTitle').textContent = title;
            document.getElementById('modalBookAuthor').textContent = author;
            document.getElementById('modalBookGenre').textContent = genre;
            document.getElementById('modalBookYear').textContent = year;
            document.getElementById('modalBookImage').src = image;
            document.getElementById('modalBookLink').href = link;
          }
          function closeDetails() {
            document.getElementById('bookDetailsModal').style.display = 'none';
          }
        </script>
      </div>
    </main>
  </div>
</body>
</html>
