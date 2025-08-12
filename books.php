<?php
session_start();
$isLoggedIn = isset($_SESSION['student_fullname']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serenity Library - Books</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="books.css">
</head>
<body style="overflow-y:auto;">
  <div class="container books-page gradient-bg" style="min-height:100vh;">
    <header class="header">
      <div class="logo">
        <div class="logo-icon">🌸</div>
        <div class="logo-text">
          <h1>Cherub Library</h1>
          <p>Save books you love ♡</p>
        </div>
      </div>
      <nav class="nav">
        <a href="index.php" class="nav-link active">🏠 Home</a>
        <a href="#books" class="nav-link">📚 Books</a>
        <a href="login.php" class="nav-link">🔑 Login</a>
        <a href="signup.php" class="nav-link">✨ Sign Up</a>
      </nav>
    </header>

    <div class="floating-tabs-container">
      <div class="floating-tabs">
        <button class="tab-button" id="libraryTab" onclick="showTab('library')">
          <span class="tab-icon">📚</span>
          <span class="tab-text">Access Your Library</span>
        </button>
        <button class="tab-button" id="addBookTab" onclick="showTab('addBook')">
          <span class="tab-icon">➕</span>
          <span class="tab-text">Add New Book</span>
        </button>
      </div>
    </div>
    <main class="books-main-content">
      <main class="books-main-content">
        <div class="content-wrapper">
          <div id="librarySection">
            <?php 
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
            <div class="library-controls">
              <div class="search-section">
                <div class="search-container">
                  <div class="search-icon">🔍</div>
                  <input type="text" placeholder="Search by title or author..." class="search-input" />
                </div>
              </div>
              <div class="filters-section">
                <div class="filter-group">
                  <label class="filter-label">Genre</label>
                  <select class="filter-select">
                    <option>All</option>
                    <option>Romance</option>
                    <option>Fantasy</option>
                    <option>Adventure</option>
                    <option>Slice of Life</option>
                  </select>
                </div>
                <div class="filter-group">
                  <label class="filter-label">Year</label>
                  <select class="filter-select">
                    <option>All</option>
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                    <option>2021</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="section-header">
              <h2>Your Kawaii Collection ♡</h2>
              <div class="book-count">
                <span class="count-number"><?php echo count($books); ?></span>
                <span class="count-text">books found</span>
              </div>
            </div>
            <div class="books-grid">
              <?php foreach ($books as $book): ?>
              <div class="book-card book-card-tiny">
                <div class="book-cover-container">
                  <img src="<?php echo $book['image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover" />
                  <div class="book-overlay">
                    <button class="view-details-button" onclick='showDetails("<?php echo addslashes($book['title']); ?>","<?php echo addslashes($book['author']); ?>","<?php echo addslashes($book['genre']); ?>","<?php echo $book['year']; ?>","<?php echo addslashes($book['image']); ?>","<?php echo addslashes($book['link']); ?>")'>View Details</button>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="addBookSection" style="display:none;">
            <?php 
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
                      <button class="edit-btn" onclick="editBook(<?php echo htmlspecialchars(json_encode($book)); ?>)">✏️ Edit</button>
                      <button class="delete-btn">🗑️ Delete</button>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
<script>
function showTab(tab) {
  document.getElementById('librarySection').style.display = tab === 'library' ? 'block' : 'none';
  document.getElementById('addBookSection').style.display = tab === 'addBook' ? 'block' : 'none';
  document.getElementById('libraryTab').classList.toggle('active', tab === 'library');
  document.getElementById('addBookTab').classList.toggle('active', tab === 'addBook');
}
// Default to library tab
showTab('library');

function editBook(book) {
  document.getElementById('addBookModal').style.display = 'flex';
  var form = document.querySelector('#addBookModal .book-form');
  if (!form) return;
  form.querySelector('input[placeholder="Enter book title..."]').value = book.title;
  form.querySelector('input[placeholder="Enter author name..."]').value = book.author;
  form.querySelector('select').value = book.genre;
  form.querySelector('input[type="number"]').value = book.year;
  form.querySelector('input[placeholder*="book-cover"]').value = book.image;
  form.querySelector('input[placeholder*="read-book"]').value = book.link;
  var ratingInput = form.querySelector('input[placeholder*="Rating"], input[type="number"][step]');
  if (ratingInput) ratingInput.value = book.rating;
}
</script>
        <!-- Book Management Section (Add/Edit/Delete) -->
        <?php if ($isLoggedIn): ?>
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
                      <option>Romance</option>
                      <option>Fantasy</option>
                      <option>Adventure</option>
                      <option>Slice of Life</option>
                      <option>Mystery</option>
                      <option>Sci-Fi</option>
                      <option>Horror</option>
                      <option>Comedy</option>
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
        </div>
        <?php endif; ?>
      </div>
    </main>
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
</body>
</html>
