

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cherub Library - Books</title>
  <link rel="stylesheet" href="books-header.css">
  <link rel="stylesheet" href="books.css">
</head>
<body class="books-header-bg">
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
        <a href="index.php" class="nav-link active">🏠 Home</a>
        <a href="#books" class="nav-link">📚 Books</a>
        <a href="login.php" class="nav-link">🔑 Login</a>
        <a href="signup.php" class="nav-link">✨ Sign Up</a>
      </nav>
    </header>
    <div class="floating-tabs-container">
      <div class="floating-tabs">
        <a href="book-management.php" class="tab-button" id="addBookTab">
          <span class="tab-icon">✨</span>
          <span class="tab-text">Add New Book</span>
        </a>
      </div>
    </div>
    <?php
    require_once 'connection.php';
    $books = [];
    $result = $conn->query("SELECT * FROM book ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    ?>
    <main class="books-main-content">
      <div class="content-wrapper">
        <div class="books-display">
          <div class="section-header">
            <h2>Your Kawaii Collection ♡</h2>
            <div class="book-count">
              <span class="count-number"><?php echo count($books); ?></span>
              <span class="count-text">books found</span>
            </div>
          </div>
          <div class="books-grid">
            <?php if (count($books) === 0): ?>
              <div class="no-books-found">
                <div class="no-books-icon">📚</div>
                <h3>No books found</h3>
                <p>Try adding a new book or adjusting your filters!</p>
              </div>
            <?php else: ?>
              <?php foreach ($books as $book): ?>
                <?php
                  $bookTitle = isset($book['title']) ? $book['title'] : '';
                  $bookAuthor = isset($book['author']) ? $book['author'] : '';
                  $bookGenre = isset($book['genre']) ? $book['genre'] : '';
                  $bookYear = isset($book['year']) ? $book['year'] : '';
                  $bookImage = !empty($book['image']) ? $book['image'] : '/placeholder.svg';
                  $bookRating = isset($book['rating']) ? $book['rating'] : '';
                  $bookLink = isset($book['link']) ? $book['link'] : '#';
                ?>
                <div class="book-card book-card-large" style="cursor:pointer;box-shadow:0 8px 32px rgba(255,107,157,0.12);border-radius:20px;padding:2rem;display:flex;flex-direction:column;align-items:center;gap:1rem;transition:all 0.3s;" onclick="showBookModal('<?php echo addslashes($bookTitle); ?>','<?php echo addslashes($bookAuthor); ?>','<?php echo addslashes($bookGenre); ?>','<?php echo addslashes($bookYear); ?>','<?php echo addslashes($bookImage); ?>','<?php echo addslashes($bookRating); ?>','<?php echo addslashes($bookLink); ?>')">
                  <div class="book-cover-container" style="margin-bottom:1rem;">
                    <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="<?php echo htmlspecialchars($bookTitle); ?>" class="book-cover" style="width:120px;height:160px;object-fit:cover;border-radius:12px;box-shadow:0 4px 20px rgba(255,107,157,0.15);">
                  </div>
                  <div class="book-info" style="text-align:center;">
                    <h3 class="book-title" style="font-size:1.3rem;color:#ff6b9d;margin-bottom:0.5rem;"><?php echo htmlspecialchars($bookTitle); ?></h3>
                    <p class="book-author" style="color:#666;margin-bottom:0.5rem;">by <?php echo htmlspecialchars($bookAuthor); ?></p>
                    <span class="book-genre" style="background:rgba(255,107,157,0.1);color:#ff6b9d;padding:0.25rem 0.5rem;border-radius:8px;font-size:0.9rem;font-weight:600;margin-right:0.5rem;"><?php echo htmlspecialchars($bookGenre); ?></span>
                    <span class="book-year" style="background:rgba(107,157,255,0.1);color:#6b9dff;padding:0.25rem 0.5rem;border-radius:8px;font-size:0.9rem;font-weight:600;"><?php echo htmlspecialchars($bookYear); ?></span>
                    <span class="book-rating" style="font-size:1.1rem;">⭐ <?php echo htmlspecialchars($bookRating); ?></span>
                    <a href="<?php echo htmlspecialchars($bookLink); ?>" target="_blank" class="read-now-btn" style="display:inline-block;background:#4ade80;color:#fff;padding:0.5rem 1.5rem;border-radius:12px;text-decoration:none;font-weight:600;margin-top:0.5rem;">📖 Read Now</a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- Book Details Modal -->
  <div id="bookDetailsModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;">
    <div id="bookDetailsContent" style="background:#fff;padding:2rem 2.5rem;border-radius:20px;max-width:400px;width:90vw;box-shadow:0 8px 40px rgba(0,0,0,0.2);position:relative;">
      <button onclick="closeBookModal()" style="position:absolute;top:1rem;right:1rem;background:#ff6b9d;color:#fff;border:none;border-radius:50%;width:2rem;height:2rem;font-size:1.2rem;cursor:pointer;">✕</button>
      <div id="modalBookImage" style="text-align:center;margin-bottom:1rem;"></div>
      <h2 id="modalBookTitle" style="color:#ff6b9d;margin-bottom:0.5rem;"></h2>
      <p id="modalBookAuthor" style="color:#666;margin-bottom:0.5rem;"></p>
      <div style="margin-bottom:0.5rem;"><span id="modalBookGenre" style="background:rgba(255,107,157,0.1);color:#ff6b9d;padding:0.25rem 0.5rem;border-radius:8px;font-size:0.9rem;font-weight:600;margin-right:0.5rem;"></span><span id="modalBookYear" style="background:rgba(107,157,255,0.1);color:#6b9dff;padding:0.25rem 0.5rem;border-radius:8px;font-size:0.9rem;font-weight:600;"></span></div>
      <div style="margin-bottom:1rem;font-size:1.1rem;"><span id="modalBookRating"></span></div>
      <a id="modalBookLink" href="#" target="_blank" style="display:inline-block;background:#4ade80;color:#fff;padding:0.5rem 1.5rem;border-radius:12px;text-decoration:none;font-weight:600;">📖 Read Now</a>
    </div>
  </div>
  <script>
  // Book Modal Logic
  function showBookModal(title, author, genre, year, image, rating, link) {
    document.getElementById('modalBookImage').innerHTML = '<img src="'+image+'" alt="'+title+'" style="width:120px;height:160px;object-fit:cover;border-radius:12px;box-shadow:0 4px 20px rgba(255,107,157,0.15);">';
    document.getElementById('modalBookTitle').textContent = title;
    document.getElementById('modalBookAuthor').textContent = 'by ' + author;
    document.getElementById('modalBookGenre').textContent = genre;
    document.getElementById('modalBookYear').textContent = year;
    document.getElementById('modalBookRating').textContent = '⭐ ' + rating;
    document.getElementById('modalBookLink').href = link;
    document.getElementById('bookDetailsModal').style.display = 'flex';
  }
  function closeBookModal() {
    document.getElementById('bookDetailsModal').style.display = 'none';
  }
    const books = [
      {
        id: 1,
        title: "Sweet Dreams",
        author: "Luna Chan",
        genre: "Romance",
        year: 2023,
        image: "/cute-pink-book-cover.png",
        link: "https://example.com/sweet-dreams",
        rating: 4.8,
      },
      {
        id: 2,
        title: "Ocean Tales",
        author: "Miku Blue",
        genre: "Fantasy",
        year: 2022,
        image: "/blue-ocean-fantasy-book.png",
        link: "https://example.com/ocean-tales",
        rating: 4.9,
      },
      {
        id: 3,
        title: "Sunny Days",
        author: "Pom Pom",
        genre: "Adventure",
        year: 2024,
        image: "/yellow-sunny-adventure-book.png",
        link: "https://example.com/sunny-days",
        rating: 4.7,
      },
      {
        id: 4,
        title: "Magical Forest",
        author: "Sakura Hana",
        genre: "Fantasy",
        year: 2023,
        image: "/green-magical-forest-book.png",
        link: "https://example.com/magical-forest",
        rating: 4.6,
      },
      {
        id: 5,
        title: "City Lights",
        author: "Neon Star",
        genre: "Romance",
        year: 2021,
        image: "/purple-city-lights-book.png",
        link: "https://example.com/city-lights",
        rating: 4.5,
      },
      {
        id: 6,
        title: "Cozy Café",
        author: "Mocha Bean",
        genre: "Slice of Life",
        year: 2024,
        image: "/cozy-brown-cafe-book.png",
        link: "https://example.com/cozy-cafe",
        rating: 4.8,
      },
    ];
    function filterBooks() {
      const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
      const genre = document.getElementById('genreSelect').value;
      const year = document.getElementById('yearSelect').value;
      const filtered = books.filter(book => {
        const matchesSearch = book.title.toLowerCase().includes(searchTerm) || book.author.toLowerCase().includes(searchTerm);
        const matchesGenre = genre === 'All' || book.genre === genre;
        const matchesYear = year === 'All' || book.year.toString() === year;
        return matchesSearch && matchesGenre && matchesYear;
      });
      renderBooks(filtered);
    }
    function renderBooks(filteredBooks) {
      const grid = document.getElementById('booksGrid');
      const noBooks = document.getElementById('noBooks');
      const bookCount = document.getElementById('bookCount');
      grid.innerHTML = '';
      bookCount.textContent = filteredBooks.length;
      if (filteredBooks.length === 0) {
        noBooks.style.display = '';
        return;
      }
      noBooks.style.display = 'none';
      filteredBooks.forEach(book => {
        const card = document.createElement('div');
        card.className = 'book-card book-card-tiny';
        card.onclick = () => showBookDetails(book.id);
        card.innerHTML = `
          <div class='book-cover-container'>
            <img src='${book.image || "/placeholder.svg"}' alt='${book.title}' class='book-cover'>
            <div class='book-overlay'>
              <button class='view-details-button'>View Details</button>
            </div>
          </div>
          <div class='book-info'>
            <h3 class='book-title'>${book.title}</h3>
            <p class='book-author'>by ${book.author}</p>
            <span class='book-genre'>${book.genre}</span>
          </div>
        `;
        grid.appendChild(card);
      });
    }
    function showBookDetails(id) {
      const book = books.find(b => b.id === id);
      if (!book) return;
      const modal = document.getElementById('bookDetailsModal');
      modal.innerHTML = `
        <div class='book-details-overlay' onclick='closeBookDetails()'>
          <div class='book-details-modal' onclick='event.stopPropagation()'>
            <button class='modal-close-btn' onclick='closeBookDetails()'>✕</button>
            <div class='modal-content'>
              <div class='modal-book-cover'>
                <img src='${book.image || "/placeholder.svg"}' alt='${book.title}' />
              </div>
              <div class='modal-book-info'>
                <div class='modal-header'>
                  <h2 class='modal-title'>${book.title}</h2>
                </div>
                <div class='modal-author'>
                  <span class='author-label'>✍️ Author:</span>
                  <span class='author-name'>${book.author}</span>
                </div>
                <div class='modal-details'>
                  <div class='detail-item'>
                    <span class='detail-label'>� Genre:</span>
                    <span class='detail-value'>${book.genre}</span>
                  </div>
                  <div class='detail-item'>
                    <span class='detail-label'>� Published:</span>
                    <span class='detail-value'>${book.year}</span>
                  </div>
                </div>
                <div class='modal-actions'>
                  <a href='${book.link}' target='_blank' rel='noopener noreferrer' class='read-now-btn'>📖 Read Now</a>
                  <button class='close-modal-btn' onclick='closeBookDetails()'>Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
      modal.style.display = '';
    }
    function closeBookDetails() {
      document.getElementById('bookDetailsModal').style.display = 'none';
    }
    // Initial render
    renderBooks(books);
  </script>
</body>
</html>
