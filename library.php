
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherub Library - Library</title>
    <link rel="stylesheet" href="./books.css">
</head>
<body>
    <div class="library-page-container">
      <header class="library-header-nav">
        <div class="library-logo">
          <div class="logo-icon">🌸</div>

          <div class="library-controls">
            <div class="search-section">
              <div class="search-container">
                <div class="search-icon">🔍</div>
                <input type="text" id="searchTerm" placeholder="Search by title or author..." class="search-input" oninput="filterBooks()">
              </div>
            </div>
            <div class="filters-section">
              <div class="filter-group">
                <label class="filter-label">📚 Genre</label>
                <select id="genreSelect" class="filter-select" onchange="filterBooks()">
                  <option value="All">All</option>
                  <option value="Romance">Romance</option>
                  <option value="Fantasy">Fantasy</option>
                  <option value="Mystery">Mystery</option>
                  <option value="Sci-Fi">Sci-Fi</option>
                  <option value="Adventure">Adventure</option>
                  <option value="Drama">Drama</option>
                  <option value="Comedy">Comedy</option>
                  <option value="Slice of Life">Slice of Life</option>
                </select>
              </div>
              <div class="filter-group">
                <label class="filter-label">📅 Year</label>
                <select id="yearSelect" class="filter-select" onchange="filterBooks()">
                  <option value="All">All</option>
                  <option value="2024">2024</option>
                  <option value="2023">2023</option>
                  <option value="2022">2022</option>
                  <option value="2021">2021</option>
                  <option value="2020">2020</option>
                  <option value="2019">2019</option>
                  <option value="2018">2018</option>
                </select>
              </div>
            </div>
          </div>

          <div class="books-display">
            <div class="section-header">
              <h2>Your Kawaii Collection ♡</h2>
              <div class="book-count">
                <span class="count-number" id="bookCount"></span>
                <span class="count-text">books found</span>
              </div>
            </div>
            <div class="books-grid" id="booksGrid"></div>
            <div id="noBooks" class="no-books-found" style="display:none;">
              <div class="no-books-icon">📚</div>
              <h3>No books found</h3>
              <p>Try adjusting your search or filters to find more books~</p>
            </div>
          </div>
              <option value="Romance">Romance</option>
              <option value="Fantasy">Fantasy</option>
              <option value="Adventure">Adventure</option>
              <option value="Slice of Life">Slice of Life</option>
            </select>
          </div>
          <div class="filter-group">
            <label class="filter-label">Year</label>
            <select id="yearSelect" class="library-filter-select" onchange="filterBooks()">
              <option value="All">All Years</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
            </select>
          </div>
        </div>
      </div>

      <div class="library-books-container">
        <div class="library-books-grid" id="booksGrid"></div>
        <div id="noBooks" class="library-no-results" style="display:none;">
          <div class="no-results-icon">�</div>
          <h3>No books found</h3>
          <p>Try adjusting your search or filters</p>
        </div>
      </div>

      <div id="bookDetailsModal" style="display:none;"></div>
    </div>
    <script>
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
          description: "A heartwarming tale of love and friendship in a magical world filled with cherry blossoms and sweet dreams.",
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
          description: "Dive into an underwater adventure with mermaids, sea creatures, and ancient ocean mysteries.",
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
          description: "Join our heroes on a bright adventure through sunflower fields and golden meadows.",
        },
        {
          id: 4,
          title: "Magical Forest",
          author: "Green Leaf",
          genre: "Fantasy",
          year: 2023,
          image: "/green-magical-forest-book.png",
          link: "https://example.com/magical-forest",
          rating: 4.6,
          description: "Explore an enchanted forest where every tree holds a secret and magic flows like rivers.",
        },
        {
          id: 5,
          title: "City Lights",
          author: "Purple Night",
          genre: "Romance",
          year: 2022,
          image: "/purple-city-lights-book.png",
          link: "https://example.com/city-lights",
          rating: 4.5,
          description: "A modern love story set against the backdrop of a bustling city filled with neon dreams.",
        },
        {
          id: 6,
          title: "Cozy Café",
          author: "Brown Sugar",
          genre: "Slice of Life",
          year: 2024,
          image: "/cozy-brown-cafe-book.png",
          link: "https://example.com/cozy-cafe",
          rating: 4.8,
          description: "Warm stories from a little café where every cup of coffee comes with a tale to tell.",
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
          <div class='library-modal-overlay' onclick='closeBookDetails()'>
            <div class='library-modal' onclick='event.stopPropagation()'>
              <button class='library-modal-close' onclick='closeBookDetails()'>✕</button>
              <div class='library-modal-content'>
                <div class='library-modal-image'>
                  <img src='${book.image || "/placeholder.svg"}' alt='${book.title}'>
                </div>
                <div class='library-modal-details'>
                  <h2 class='library-modal-title'>${book.title}</h2>
                  <p class='library-modal-author'>by ${book.author}</p>
                  <div class='library-modal-meta'>
                    <span class='modal-genre-tag'>${book.genre}</span>
                    <span class='modal-year-tag'>${book.year}</span>
                    <div class='modal-rating'><span class='stars'>⭐</span> <span>${book.rating}</span></div>
                  </div>
                  <p class='library-modal-description'>${book.description}</p>
                  <a href='${book.link}' target='_blank' rel='noopener noreferrer' class='library-read-btn'>Read Now ✨</a>
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cherub Library - Library</title>
  <link rel="stylesheet" href="./books.css" />
</head>
<body>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherub Library - Library</title>
    <link rel="stylesheet" href="./books.css">
        <div class="logo-text">
          <h1>Cherub Library</h1>
          <p>Save books you love ♡</p>
        </div>
      </div>
      <nav class="nav">
        <a href="/" class="nav-link">🏠 Home</a>
        <a href="/library" class="nav-link active">📚 Library</a>
        <a href="/add-books" class="nav-link">➕ Add Books</a>
        <a href="/account" class="nav-link">👤 Account</a>
      </nav>
    </header>
    <div class="library-container">
      <div class="library-header">
        <h1 class="library-title">📚 Your Kawaii Library ✨</h1>
        <p class="library-subtitle">Discover and explore your saved books</p>
      </div>
      <div class="search-filters">
        <div class="search-bar">
          <input type="text" id="searchTerm" placeholder="🔍 Search by title or author..." class="search-input" oninput="filterBooks()" />
        </div>
        <div class="filters">
          <select id="genreSelect" class="filter-select" onchange="filterBooks()">
            <option value="All">🎭 All Genres</option>
            <option value="Romance">📖 Romance</option>
            <option value="Fantasy">📖 Fantasy</option>
            <option value="Adventure">📖 Adventure</option>
            <option value="Slice of Life">📖 Slice of Life</option>
          </select>
          <select id="yearSelect" class="filter-select" onchange="filterBooks()">
            <option value="All">📅 All Years</option>
            <option value="2022">� 2022</option>
            <option value="2023">📅 2023</option>
            <option value="2024">📅 2024</option>
          </select>
        </div>
      </div>
      <div class="books-grid-small" id="booksGrid"></div>
      <div id="noBooks" class="no-books" style="display:none;">
        <p>🔍 No books found matching your search criteria</p>
      </div>
    </div>
    <div id="bookDetailsModal" style="display:none;"></div>
  </div>
  <script>
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
        description: "A heartwarming tale of love and friendship in a magical world filled with cherry blossoms and sweet dreams.",
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
        description: "Dive into an underwater adventure with mermaids, sea creatures, and ancient ocean mysteries.",
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
        description: "Join our heroes on a bright adventure through sunflower fields and golden meadows.",
      },
      {
        id: 4,
        title: "Magical Forest",
        author: "Green Leaf",
        genre: "Fantasy",
        year: 2023,
        image: "/green-magical-forest-book.png",
        link: "https://example.com/magical-forest",
        rating: 4.6,
        description: "Explore an enchanted forest where every tree holds a secret and magic flows like rivers.",
      },
      {
        id: 5,
        title: "City Lights",
        author: "Purple Night",
        genre: "Romance",
        year: 2022,
        image: "/purple-city-lights-book.png",
        link: "https://example.com/city-lights",
        rating: 4.5,
        description: "A modern love story set against the backdrop of a bustling city filled with neon dreams.",
      },
      {
        id: 6,
        title: "Cozy Café",
        author: "Brown Sugar",
        genre: "Slice of Life",
        year: 2024,
        image: "/cozy-brown-cafe-book.png",
        link: "https://example.com/cozy-cafe",
        rating: 4.8,
        description: "Warm stories from a little café where every cup of coffee comes with a tale to tell.",
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
      grid.innerHTML = '';
      if (filteredBooks.length === 0) {
        noBooks.style.display = '';
        return;
      }
      noBooks.style.display = 'none';
      filteredBooks.forEach(book => {
        const card = document.createElement('div');
        card.className = 'book-card-small';
        card.onclick = () => showBookDetails(book.id);
        card.innerHTML = `
          <div class='book-cover-small'>
            <img src='${book.image || "/placeholder.svg"}' alt='${book.title}' />
            <div class='book-overlay-small'>
              <button class='view-details-btn-small'>👁️</button>
            </div>
          </div>
          <div class='book-info-small'>
            <h3 class='book-title-small'>${book.title}</h3>
            <p class='book-author-small'>by ${book.author}</p>
            <div class='book-meta-small'>
              <span class='book-genre-small'>${book.genre}</span>
              <span class='book-year-small'>${book.year}</span>
            </div>
            <div class='book-rating-small'>⭐ ${book.rating}</div>
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
            <button class='close-modal' onclick='closeBookDetails()'>✕</button>
            <div class='modal-content'>
              <div class='modal-image'>
                <img src='${book.image || "/placeholder.svg"}' alt='${book.title}' />
              </div>
              <div class='modal-info'>
                <h2>${book.title}</h2>
                <p class='modal-author'>by ${book.author}</p>
                <div class='modal-meta'>
                  <span class='modal-genre'>📖 ${book.genre}</span>
                  <span class='modal-year'>📅 ${book.year}</span>
                  <span class='modal-rating'>⭐ ${book.rating}</span>
                </div>
                <p class='modal-description'>${book.description}</p>
                <a href='${book.link}' target='_blank' rel='noopener noreferrer' class='read-now-btn'>📖 Read Now ✨</a>
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
