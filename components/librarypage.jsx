"use client"

import { useState } from "react"
import "./library.css"

const mockBooks = [
  {
    id: 1,
    title: "Sweet Dreams",
    author: "Luna Chan",
    genre: "Romance",
    year: 2023,
    image: "/cute-pink-book-cover.png",
    link: "https://example.com/sweet-dreams",
    rating: 4.8,
    description:
      "A heartwarming tale of love and friendship in a magical world filled with cherry blossoms and sweet dreams.",
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
]

const LibraryPage = () => {
  const [books, setBooks] = useState(mockBooks)
  const [searchTerm, setSearchTerm] = useState("")
  const [selectedGenre, setSelectedGenre] = useState("All")
  const [selectedYear, setSelectedYear] = useState("All")
  const [selectedBook, setSelectedBook] = useState(null)
  const [isEditing, setIsEditing] = useState(false)
  const [editFormData, setEditFormData] = useState({})
  const [imagePreview, setImagePreview] = useState("")

  const genres = ["All", ...new Set(books.map((book) => book.genre))]
  const years = ["All", ...new Set(books.map((book) => book.year.toString()))]

  const filteredBooks = books.filter((book) => {
    const matchesSearch =
      book.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
      book.author.toLowerCase().includes(searchTerm.toLowerCase())
    const matchesGenre = selectedGenre === "All" || book.genre === selectedGenre
    const matchesYear = selectedYear === "All" || book.year.toString() === selectedYear
    return matchesSearch && matchesGenre && matchesYear
  })

  const handleEditBook = (book) => {
    setEditFormData({
      title: book.title,
      author: book.author,
      genre: book.genre,
      year: book.year,
      link: book.link,
      rating: book.rating,
      description: book.description,
      image: book.image,
    })
    setImagePreview(book.image)
    setIsEditing(true)
  }

  const handleSaveEdit = () => {
    const updatedBooks = books.map((book) => (book.id === selectedBook.id ? { ...book, ...editFormData } : book))
    setBooks(updatedBooks)
    setSelectedBook({ ...selectedBook, ...editFormData })
    setIsEditing(false)
    setImagePreview("")
  }

  const handleCancelEdit = () => {
    setIsEditing(false)
    setEditFormData({})
    setImagePreview("")
  }

  const handleImageUpload = (e) => {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        const imageUrl = e.target.result
        setImagePreview(imageUrl)
        setEditFormData({ ...editFormData, image: imageUrl })
      }
      reader.readAsDataURL(file)
    }
  }

  return (
    <div className="library-page-container">
      <header className="library-header-nav">
        <div className="library-logo">
          <div className="logo-icon">🌸</div>
          <div className="logo-text">
            <h1>Cherub Library</h1>
            <p>Save books you love ♡</p>
          </div>
        </div>
        <nav className="library-nav">
          <a href="/" className="nav-link">
            🏠 Home
          </a>
          <a href="/books" className="nav-link">
            📚 Books
          </a>
          <a href="/account" className="nav-link">
            👤 Account
          </a>
          <a href="#login" className="nav-link">
            🔑 Login
          </a>
          <a href="#signup" className="nav-link">
            ✨ Sign Up
          </a>
        </nav>
      </header>

      <div className="library-hero">
        <div className="floating-decorations">
          <span className="float-icon">🎀</span>
          <span className="float-icon">💖</span>
          <span className="float-icon">🌟</span>
          <span className="float-icon">🦋</span>
          <span className="float-icon">🌸</span>
        </div>
        <h1 className="library-main-title">Your Magical Library ✨</h1>
        <p className="library-subtitle">Discover wonderful stories in your kawaii collection</p>
      </div>

      <div className="library-controls">
        <div className="search-section">
          <div className="search-wrapper">
            <span className="search-icon">🔍</span>
            <input
              type="text"
              placeholder="Search by title or author..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="library-search-input"
            />
          </div>
        </div>

        <div className="filter-section">
          <div className="filter-group">
            <label className="filter-label">Genre</label>
            <select
              value={selectedGenre}
              onChange={(e) => setSelectedGenre(e.target.value)}
              className="library-filter-select"
            >
              {genres.map((genre) => (
                <option key={genre} value={genre}>
                  {genre === "All" ? "All Genres" : genre}
                </option>
              ))}
            </select>
          </div>

          <div className="filter-group">
            <label className="filter-label">Year</label>
            <select
              value={selectedYear}
              onChange={(e) => setSelectedYear(e.target.value)}
              className="library-filter-select"
            >
              {years.map((year) => (
                <option key={year} value={year}>
                  {year === "All" ? "All Years" : year}
                </option>
              ))}
            </select>
          </div>
        </div>
      </div>

      <div className="library-books-container">
        <div className="library-books-grid">
          {filteredBooks.map((book) => (
            <div key={book.id} className="library-book-card" onClick={() => setSelectedBook(book)}>
              <div className="library-book-cover">
                <img src={book.image || "/placeholder.svg"} alt={book.title} />
                <div className="library-book-overlay">
                  <button className="library-view-btn">View Details</button>
                </div>
              </div>
              <div className="library-book-info">
                <h3 className="library-book-title">{book.title}</h3>
                <p className="library-book-author">by {book.author}</p>
                <div className="library-book-tags">
                  <span className="genre-tag">{book.genre}</span>
                  <span className="year-tag">{book.year}</span>
                </div>
                <div className="library-book-rating">
                  <span className="stars">⭐</span>
                  <span className="rating-value">{book.rating}</span>
                </div>
              </div>
            </div>
          ))}
        </div>

        {filteredBooks.length === 0 && (
          <div className="library-no-results">
            <div className="no-results-icon">📚</div>
            <h3>No books found</h3>
            <p>Try adjusting your search or filters</p>
          </div>
        )}
      </div>

      {selectedBook && (
        <div className="library-modal-overlay" onClick={() => setSelectedBook(null)}>
          <div className="library-modal compact-modal" onClick={(e) => e.stopPropagation()}>
            <button className="library-modal-close" onClick={() => setSelectedBook(null)}>
              ✕
            </button>
            <div className="library-modal-content">
              <div className="library-modal-image">
                <img src={selectedBook.image || "/placeholder.svg"} alt={selectedBook.title} />
              </div>
              <div className="library-modal-details">
                {isEditing ? (
                  <div className="edit-form">
                    <div className="edit-image-section">
                      <label className="edit-image-label">Book Cover</label>
                      <div className="edit-image-upload">
                        <input
                          type="file"
                          accept="image/*"
                          onChange={handleImageUpload}
                          className="edit-file-input"
                          id="book-cover-upload"
                        />
                        <label htmlFor="book-cover-upload" className="edit-upload-btn">
                          📷 Upload Cover
                        </label>
                        {imagePreview && (
                          <div className="edit-image-preview">
                            <img src={imagePreview || "/placeholder.svg"} alt="Preview" />
                          </div>
                        )}
                      </div>
                    </div>

                    <input
                      type="text"
                      value={editFormData.title}
                      onChange={(e) => setEditFormData({ ...editFormData, title: e.target.value })}
                      className="edit-input edit-title"
                      placeholder="Book title"
                    />
                    <input
                      type="text"
                      value={editFormData.author}
                      onChange={(e) => setEditFormData({ ...editFormData, author: e.target.value })}
                      className="edit-input edit-author"
                      placeholder="Author name"
                    />
                    <div className="edit-row">
                      <select
                        value={editFormData.genre}
                        onChange={(e) => setEditFormData({ ...editFormData, genre: e.target.value })}
                        className="edit-select"
                      >
                        <option value="Romance">Romance</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Slice of Life">Slice of Life</option>
                      </select>
                      <input
                        type="number"
                        value={editFormData.year}
                        onChange={(e) => setEditFormData({ ...editFormData, year: Number.parseInt(e.target.value) })}
                        className="edit-input edit-year"
                        min="1900"
                        max="2024"
                      />
                    </div>
                    <input
                      type="url"
                      value={editFormData.link}
                      onChange={(e) => setEditFormData({ ...editFormData, link: e.target.value })}
                      className="edit-input"
                      placeholder="Book link"
                    />
                    <textarea
                      value={editFormData.description}
                      onChange={(e) => setEditFormData({ ...editFormData, description: e.target.value })}
                      className="edit-textarea"
                      placeholder="Book description"
                      rows="3"
                    />
                    <div className="edit-actions">
                      <button onClick={handleSaveEdit} className="save-btn">
                        Save Changes ✨
                      </button>
                      <button onClick={handleCancelEdit} className="cancel-btn">
                        Cancel
                      </button>
                    </div>
                  </div>
                ) : (
                  <>
                    <h2 className="library-modal-title">{selectedBook.title}</h2>
                    <p className="library-modal-author">by {selectedBook.author}</p>
                    <div className="library-modal-meta">
                      <span className="modal-genre-tag">{selectedBook.genre}</span>
                      <span className="modal-year-tag">{selectedBook.year}</span>
                      <div className="modal-rating">
                        <span className="stars">⭐</span>
                        <span>{selectedBook.rating}</span>
                      </div>
                    </div>
                    <p className="library-modal-description">{selectedBook.description}</p>
                    <div className="modal-actions">
                      <a
                        href={selectedBook.link}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="library-read-btn"
                      >
                        Read Now ✨
                      </a>
                      <button onClick={() => handleEditBook(selectedBook)} className="library-edit-btn">
                        Edit Details ✏️
                      </button>
                    </div>
                  </>
                )}
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}

export default LibraryPage
