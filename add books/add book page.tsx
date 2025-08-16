"use client"

import { useState } from "react"
import Link from "next/link"
import "./add-books.css"

type Book = {
  id: number
  title: string
  author: string
  genre: string
  year: number
  image: string
  link: string
  rating?: string
}

export default function AddBooksPage() {
  const [books, setBooks] = useState<Book[]>([])
  const [editingBook, setEditingBook] = useState<Book | null>(null)
  const [formData, setFormData] = useState({
    title: "",
    author: "",
    genre: "",
    year: "",
    image: "",
    link: "",
  })
  const [imagePreview, setImagePreview] = useState("")

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleImageChange = (e) => {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        if (e.target) {
          const imageUrl = e.target.result as string
          setImagePreview(imageUrl)
          setFormData((prev) => ({
            ...prev,
            image: imageUrl,
          }))
        }
      }
      reader.readAsDataURL(file)
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault()

    if (editingBook) {
      setBooks(
        books.map((book) =>
          book.id === editingBook.id
            ? { ...formData, id: editingBook.id, year: Number(formData.year) }
            : book
        )
      )
      setEditingBook(null)
    } else {
      const newBook = {
        ...formData,
        id: Date.now(),
        year: Number.parseInt(formData.year),
        rating: (Math.random() * 2 + 3).toFixed(1),
      }
      setBooks([...books, newBook])
    }

    setFormData({
      title: "",
      author: "",
      genre: "",
      year: "",
      image: "",
      link: "",
    })
    setImagePreview("")
  }

  const handleEdit = (book) => {
    setEditingBook(book)
    setFormData({
      title: book.title,
      author: book.author,
      genre: book.genre,
      year: book.year.toString(),
      image: book.image,
      link: book.link,
    })
    setImagePreview(book.image)
  }

  const handleDelete = (bookId) => {
    if (confirm("Are you sure you want to delete this book?")) {
      setBooks(books.filter((book) => book.id !== bookId))
    }
  }

  const cancelEdit = () => {
    setEditingBook(null)
    setFormData({
      title: "",
      author: "",
      genre: "",
      year: "",
      image: "",
      link: "",
    })
    setImagePreview("")
  }

  return (
    <div className="add-books-page-container">
      <header className="add-books-header-nav">
        <div className="library-logo">
          <div className="logo-icon">🌸</div>
          <div className="logo-text">
            <h1>Cherub Library</h1>
            <p>Save books you love ♡</p>
          </div>
        </div>
        <nav className="library-nav">
          <Link href="/" className="nav-link">
            🏠 Home
          </Link>
          <Link href="/books" className="nav-link">
            📚 Books
          </Link>
          <Link href="/account" className="nav-link">
            👤 Account
          </Link>
          <Link href="/login" className="nav-link">
            🔑 Login
          </Link>
          <Link href="/signup" className="nav-link">
            ✨ Sign Up
          </Link>
        </nav>
      </header>

      <div className="add-books-hero">
        <div className="floating-decorations">
          <span className="float-icon">📚</span>
          <span className="float-icon">✨</span>
          <span className="float-icon">💖</span>
          <span className="float-icon">🌟</span>
          <span className="float-icon">📖</span>
        </div>
        <h1 className="add-books-main-title">Add New Books ✨</h1>
        <p className="add-books-subtitle">Expand your magical collection with wonderful stories</p>
      </div>

      <div className="add-books-content">
        <div className="add-book-form-container">
          <div className="form-header">
            <h2 className="form-title">{editingBook ? "Edit Your Book" : "Add a New Book"}</h2>
            <p className="form-description">Fill in the details to add a book to your collection</p>
          </div>

          <form onSubmit={handleSubmit} className="add-book-form-modern">
            <div className="form-grid">
              <div className="form-field">
                <label className="field-label">Book Title</label>
                <input
                  type="text"
                  name="title"
                  value={formData.title}
                  onChange={handleInputChange}
                  placeholder="Enter the book title"
                  className="field-input"
                  required
                />
              </div>

              <div className="form-field">
                <label className="field-label">Author</label>
                <input
                  type="text"
                  name="author"
                  value={formData.author}
                  onChange={handleInputChange}
                  placeholder="Enter author name"
                  className="field-input"
                  required
                />
              </div>

              <div className="form-field">
                <label className="field-label">Genre</label>
                <select
                  name="genre"
                  value={formData.genre}
                  onChange={handleInputChange}
                  className="field-select"
                  required
                >
                  <option value="">Choose a genre</option>
                  <option value="Romance">Romance</option>
                  <option value="Fantasy">Fantasy</option>
                  <option value="Adventure">Adventure</option>
                  <option value="Mystery">Mystery</option>
                  <option value="Sci-Fi">Sci-Fi</option>
                  <option value="Slice of Life">Slice of Life</option>
                </select>
              </div>

              <div className="form-field">
                <label className="field-label">Year Published</label>
                <input
                  type="number"
                  name="year"
                  value={formData.year}
                  onChange={handleInputChange}
                  placeholder="2024"
                  className="field-input"
                  min="1900"
                  max="2024"
                  required
                />
              </div>

              <div className="form-field full-width">
                <label className="field-label">Book Cover</label>
                <div className="image-upload-section">
                  <input
                    type="file"
                    id="image-upload"
                    accept="image/*"
                    onChange={handleImageChange}
                    className="hidden-file-input"
                  />
                  <label htmlFor="image-upload" className="image-upload-btn">
                    <span className="upload-icon">📷</span>
                    <span>Choose Cover Image</span>
                  </label>
                  {imagePreview && (
                    <div className="image-preview-container">
                      <img
                        src={imagePreview || "/placeholder.svg"}
                        alt="Book cover preview"
                        className="image-preview"
                      />
                    </div>
                  )}
                </div>
              </div>

              <div className="form-field full-width">
                <label className="field-label">Book Link</label>
                <input
                  type="url"
                  name="link"
                  value={formData.link}
                  onChange={handleInputChange}
                  placeholder="https://example.com/book-link"
                  className="field-input"
                  required
                />
              </div>
            </div>

            <div className="form-actions">
              <button type="submit" className="primary-btn">
                {editingBook ? "Update Book" : "Add Book"}
              </button>
              {editingBook && (
                <button type="button" onClick={cancelEdit} className="secondary-btn">
                  Cancel
                </button>
              )}
            </div>
          </form>
        </div>

        {books.length > 0 && (
          <div className="books-management-section">
            <div className="management-header">
              <h2 className="management-title">Your Books</h2>
              <p className="management-description">Manage your book collection</p>
            </div>

            <div className="books-management-grid">
              {books.map((book) => (
                <div key={book.id} className="management-book-card">
                  <div className="management-book-cover">
                    <img src={book.image || "/placeholder.svg"} alt={book.title} />
                  </div>
                  <div className="management-book-info">
                    <h3 className="management-book-title">{book.title}</h3>
                    <p className="management-book-author">by {book.author}</p>
                    <div className="management-book-meta">
                      <span className="meta-genre">{book.genre}</span>
                      <span className="meta-year">{book.year}</span>
                    </div>
                  </div>
                  <div className="management-book-actions">
                    <button onClick={() => handleEdit(book)} className="action-btn edit-btn">
                      Edit
                    </button>
                    <button onClick={() => handleDelete(book.id)} className="action-btn delete-btn">
                      Delete
                    </button>
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  )
}
