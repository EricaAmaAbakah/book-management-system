"use client"

import type React from "react"
import { useState, useMemo } from "react"
import "./books.css"

const initialBooks = [
  {
    id: 1,
    title: "Sweet Dreams",
    author: "Luna Chan",
    genre: "Romance",
    year: 2023,
    rating: 4.8,
    image: "/cute-pink-book-cover.png",
    link: "https://example.com/sweet-dreams",
  },
  {
    id: 2,
    title: "Ocean Tales",
    author: "Miku Blue",
    genre: "Fantasy",
    year: 2022,
    rating: 4.9,
    image: "/blue-ocean-fantasy-book.png",
    link: "https://example.com/ocean-tales",
  },
  {
    id: 3,
    title: "Sunny Days",
    author: "Pom Pom",
    genre: "Adventure",
    year: 2024,
    rating: 4.7,
    image: "/yellow-sunny-adventure-book.png",
    link: "https://example.com/sunny-days",
  },
  {
    id: 4,
    title: "Magical Forest",
    author: "Sakura Hana",
    genre: "Fantasy",
    year: 2023,
    rating: 4.6,
    image: "/green-magical-forest-book.png",
    link: "https://example.com/magical-forest",
  },
  {
    id: 5,
    title: "City Lights",
    author: "Neon Star",
    genre: "Romance",
    year: 2021,
    rating: 4.5,
    image: "/purple-city-lights-book.png",
    link: "https://example.com/city-lights",
  },
  {
    id: 6,
    title: "Cozy Café",
    author: "Mocha Bean",
    genre: "Slice of Life",
    year: 2024,
    rating: 4.8,
    image: "/cozy-brown-cafe-book.png",
    link: "https://example.com/cozy-cafe",
  },
]

const genres = ["All", "Romance", "Fantasy", "Adventure", "Slice of Life"]
const years = ["All", "2024", "2023", "2022", "2021"]
const genreOptions = ["Romance", "Fantasy", "Adventure", "Slice of Life", "Mystery", "Sci-Fi", "Horror", "Comedy"]

export default function BooksPage() {
  const [activeTab, setActiveTab] = useState<"library" | "manage">("library")
  const [books, setBooks] = useState(initialBooks)
  const [selectedBook, setSelectedBook] = useState<(typeof initialBooks)[0] | null>(null)

  return (
    <div className="books-page">
      <header className="books-header">
        <div className="header-content">
          <div className="logo">
            <div className="logo-icon">🌸</div>
            <div className="logo-text">
              <h1>Serenity Library</h1>
              <p>Your magical book collection ♡</p>
            </div>
          </div>
          <nav className="nav">
            <a href="/" className="nav-link">
              🏠 Home
            </a>
            <a href="/books" className="nav-link active">
              📚 Books
            </a>
            <a href="#login" className="nav-link">
              🔑 Login
            </a>
            <a href="#signup" className="nav-link">
              ✨ Sign Up
            </a>
          </nav>
        </div>
      </header>

      <div className="floating-tabs-container">
        <div className="floating-tabs">
          <button
            className={`tab-button ${activeTab === "library" ? "active" : ""}`}
            onClick={() => setActiveTab("library")}
          >
            <span className="tab-icon">📖</span>
            <span className="tab-text">Access Your Library</span>
          </button>
          <button
            className={`tab-button ${activeTab === "manage" ? "active" : ""}`}
            onClick={() => setActiveTab("manage")}
          >
            <span className="tab-icon">✨</span>
            <span className="tab-text">Add New Book</span>
          </button>
        </div>
      </div>

      <main className="books-main-content">
        <div className="content-wrapper">
          {activeTab === "library" ? (
            <LibraryView books={books} setSelectedBook={setSelectedBook} />
          ) : (
            <BookManagementView books={books} setBooks={setBooks} />
          )}
        </div>
      </main>

      {selectedBook && <BookDetailsModal book={selectedBook} onClose={() => setSelectedBook(null)} />}

      <footer className="books-footer">
        <div className="footer-content">
          <span className="footer-text">© 2024 Serenity Library • Made with 💖 for book lovers</span>
          <div className="footer-icons">
            <span>🌸</span>
            <span>💕</span>
            <span>📚</span>
            <span>✨</span>
          </div>
        </div>
      </footer>
    </div>
  )
}

function LibraryView({
  books,
  setSelectedBook,
}: { books: typeof initialBooks; setSelectedBook: (book: (typeof initialBooks)[0]) => void }) {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedGenre, setSelectedGenre] = useState("All")
  const [selectedYear, setSelectedYear] = useState("All")

  const filteredBooks = useMemo(() => {
    return books.filter((book) => {
      const matchesSearch =
        book.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
        book.author.toLowerCase().includes(searchQuery.toLowerCase())
      const matchesGenre = selectedGenre === "All" || book.genre === selectedGenre
      const matchesYear = selectedYear === "All" || book.year.toString() === selectedYear

      return matchesSearch && matchesGenre && matchesYear
    })
  }, [books, searchQuery, selectedGenre, selectedYear])

  return (
    <div className="library-view">
      <div className="library-controls">
        <div className="search-section">
          <div className="search-container">
            <div className="search-icon">🔍</div>
            <input
              type="text"
              placeholder="Search by title or author..."
              className="search-input"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
          </div>
        </div>

        <div className="filters-section">
          <div className="filter-group">
            <label className="filter-label">📚 Genre</label>
            <select className="filter-select" value={selectedGenre} onChange={(e) => setSelectedGenre(e.target.value)}>
              {genres.map((genre) => (
                <option key={genre} value={genre}>
                  {genre}
                </option>
              ))}
            </select>
          </div>

          <div className="filter-group">
            <label className="filter-label">📅 Year</label>
            <select className="filter-select" value={selectedYear} onChange={(e) => setSelectedYear(e.target.value)}>
              {years.map((year) => (
                <option key={year} value={year}>
                  {year}
                </option>
              ))}
            </select>
          </div>
        </div>
      </div>

      <div className="books-display">
        <div className="section-header">
          <h2>Your Kawaii Collection ♡</h2>
          <div className="book-count">
            <span className="count-number">{filteredBooks.length}</span>
            <span className="count-text">books found</span>
          </div>
        </div>

        {filteredBooks.length > 0 ? (
          <div className="books-grid">
            {filteredBooks.map((book) => (
              <div key={book.id} className="book-card book-card-tiny" onClick={() => setSelectedBook(book)}>
                <div className="book-cover-container">
                  <img src={book.image || "/placeholder.svg"} alt={book.title} className="book-cover" />
                  <div className="book-overlay">
                    <button className="view-details-button">View Details</button>
                  </div>
                </div>
                <div className="book-info">
                  <h3 className="book-title">{book.title}</h3>
                  <p className="book-author">by {book.author}</p>
                  <span className="book-genre">{book.genre}</span>
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className="no-books-found">
            <div className="no-books-icon">📚</div>
            <h3>No books found</h3>
            <p>Try adjusting your search or filters to find more books~</p>
          </div>
        )}
      </div>
    </div>
  )
}

function BookDetailsModal({ book, onClose }: { book: (typeof initialBooks)[0]; onClose: () => void }) {
  return (
    <div className="book-details-overlay" onClick={onClose}>
      <div className="book-details-modal" onClick={(e) => e.stopPropagation()}>
        <button className="modal-close-btn" onClick={onClose}>
          ✕
        </button>

        <div className="modal-content">
          <div className="modal-book-cover">
            <img src={book.image || "/placeholder.svg"} alt={book.title} />
          </div>

          <div className="modal-book-info">
            <div className="modal-header">
              <h2 className="modal-title">{book.title}</h2>
            </div>

            <div className="modal-author">
              <span className="author-label">✍️ Author:</span>
              <span className="author-name">{book.author}</span>
            </div>

            <div className="modal-details">
              <div className="detail-item">
                <span className="detail-label">📚 Genre:</span>
                <span className="detail-value">{book.genre}</span>
              </div>
              <div className="detail-item">
                <span className="detail-label">📅 Published:</span>
                <span className="detail-value">{book.year}</span>
              </div>
            </div>

            <div className="modal-actions">
              {book.link && (
                <a href={book.link} target="_blank" rel="noopener noreferrer" className="read-now-btn">
                  📖 Read Now
                </a>
              )}
              <button className="close-modal-btn" onClick={onClose}>
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

function BookManagementView({
  books,
  setBooks,
}: { books: typeof initialBooks; setBooks: (books: typeof initialBooks) => void }) {
  const [showForm, setShowForm] = useState(false)
  const [editingBook, setEditingBook] = useState<(typeof initialBooks)[0] | null>(null)
  const [formData, setFormData] = useState({
    title: "",
    author: "",
    genre: "Romance",
    year: new Date().getFullYear(),
    image: "",
    link: "",
    rating: 4.0,
  })

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()

    if (editingBook) {
      setBooks(books.map((book) => (book.id === editingBook.id ? { ...book, ...formData } : book)))
    } else {
      const newBook = {
        id: Math.max(...books.map((b) => b.id)) + 1,
        ...formData,
      }
      setBooks([...books, newBook])
    }

    setFormData({
      title: "",
      author: "",
      genre: "Romance",
      year: new Date().getFullYear(),
      image: "",
      link: "",
      rating: 4.0,
    })
    setEditingBook(null)
    setShowForm(false)
  }

  const handleEdit = (book: (typeof initialBooks)[0]) => {
    setEditingBook(book)
    setFormData({
      title: book.title,
      author: book.author,
      genre: book.genre,
      year: book.year,
      image: book.image,
      link: book.link,
      rating: book.rating,
    })
    setShowForm(true)
  }

  const handleDelete = (bookId: number) => {
    if (confirm("Are you sure you want to delete this book? 🥺")) {
      setBooks(books.filter((book) => book.id !== bookId))
    }
  }

  const handleCancel = () => {
    setShowForm(false)
    setEditingBook(null)
    setFormData({
      title: "",
      author: "",
      genre: "Romance",
      year: new Date().getFullYear(),
      image: "",
      link: "",
      rating: 4.0,
    })
  }

  return (
    <div className="book-management-view">
      <div className="management-header">
        <div className="header-info">
          <h2>Manage Your Books ✨</h2>
          <p>Add, edit, or remove books from your collection</p>
        </div>
        <button className="add-book-btn" onClick={() => setShowForm(true)}>
          <span className="btn-icon">➕</span>
          <span className="btn-text">Add New Book</span>
        </button>
      </div>

      {showForm && (
        <div className="book-form-overlay">
          <div className="book-form-container">
            <div className="form-header">
              <h3>{editingBook ? "Edit Book 📝" : "Add New Book ✨"}</h3>
              <button className="close-btn" onClick={handleCancel}>
                ✕
              </button>
            </div>

            <form onSubmit={handleSubmit} className="book-form">
              <div className="form-row">
                <div className="form-group">
                  <label>📖 Book Title</label>
                  <input
                    type="text"
                    value={formData.title}
                    onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                    placeholder="Enter book title..."
                    required
                  />
                </div>

                <div className="form-group">
                  <label>✍️ Author</label>
                  <input
                    type="text"
                    value={formData.author}
                    onChange={(e) => setFormData({ ...formData, author: e.target.value })}
                    placeholder="Enter author name..."
                    required
                  />
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>📚 Genre</label>
                  <select value={formData.genre} onChange={(e) => setFormData({ ...formData, genre: e.target.value })}>
                    {genreOptions.map((genre) => (
                      <option key={genre} value={genre}>
                        {genre}
                      </option>
                    ))}
                  </select>
                </div>

                <div className="form-group">
                  <label>📅 Year Published</label>
                  <input
                    type="number"
                    value={formData.year}
                    onChange={(e) => setFormData({ ...formData, year: Number.parseInt(e.target.value) })}
                    min="1000"
                    max={new Date().getFullYear() + 10}
                    required
                  />
                </div>
              </div>

              <div className="form-group">
                <label>🖼️ Book Cover Image URL</label>
                <input
                  type="url"
                  value={formData.image}
                  onChange={(e) => setFormData({ ...formData, image: e.target.value })}
                  placeholder="https://example.com/book-cover.jpg"
                />
              </div>

              <div className="form-group">
                <label>🔗 Book Link</label>
                <input
                  type="url"
                  value={formData.link}
                  onChange={(e) => setFormData({ ...formData, link: e.target.value })}
                  placeholder="https://example.com/read-book"
                  required
                />
              </div>

              <div className="form-group">
                <label>⭐ Rating (1-5)</label>
                <input
                  type="number"
                  value={formData.rating}
                  onChange={(e) => setFormData({ ...formData, rating: Number.parseFloat(e.target.value) })}
                  min="1"
                  max="5"
                  step="0.1"
                />
              </div>

              <div className="form-actions">
                <button type="button" className="cancel-btn" onClick={handleCancel}>
                  Cancel
                </button>
                <button type="submit" className="submit-btn">
                  {editingBook ? "Update Book 💖" : "Add Book ✨"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      <div className="books-management-section">
        <div className="section-header">
          <h3>Your Book Collection</h3>
          <div className="collection-count">
            <span className="count-number">{books.length}</span>
            <span className="count-text">books total</span>
          </div>
        </div>

        <div className="management-books-grid">
          {books.map((book) => (
            <div key={book.id} className="management-book-card">
              <div className="book-cover-small">
                <img src={book.image || "/placeholder.svg"} alt={book.title} />
              </div>
              <div className="book-details">
                <h4>{book.title}</h4>
                <p>by {book.author}</p>
                <div className="book-meta-small">
                  <span>{book.genre}</span>
                  <span>{book.year}</span>
                  <span>⭐ {book.rating}</span>
                </div>
              </div>
              <div className="book-actions">
                <button className="edit-btn" onClick={() => handleEdit(book)}>
                  ✏️ Edit
                </button>
                <button className="delete-btn" onClick={() => handleDelete(book.id)}>
                  🗑️ Delete
                </button>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
