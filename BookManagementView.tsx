"use client"

import type React from "react"
import { useState } from "react"

const genreOptions = ["Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"]
export default function BookManagementView({ books, setBooks }: { books: any[]; setBooks: (books: any[]) => void }) {
  const [showForm, setShowForm] = useState(false)
  const [editingBook, setEditingBook] = useState<any | null>(null)
  const [formData, setFormData] = useState({
    title: "",
    author: "",
  genre: "Romance",
  year: new Date().getFullYear(),
  image: "",
    link: "",
    rating: 4.0,
  })
  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (event) => {
        const result = event.target?.result as string
        setFormData({ ...formData, image: result })
      }
      reader.readAsDataURL(file)
    }
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()

    if (editingBook) {
      setBooks(books.map((book) => (book.id === editingBook.id ? { ...book, ...formData } : book)))
    } else {
      const newBook = {
        id: books.length > 0 ? Math.max(...books.map((b) => b.id)) + 1 : 1,
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

  import { useState, useEffect } from "react"
  import Link from "next/link"
  import "../books/books.css"

  export default function AddBooksPage() {
    const [books, setBooks] = useState([])
    const [editingBook, setEditingBook] = useState(null)
    const [formData, setFormData] = useState({
      title: "",
      author: "",
      genre: "",
      year: "",
      image: "",
      link: "",
    })
    const [imagePreview, setImagePreview] = useState("")

    // Fetch books from database
    useEffect(() => {
      fetch("/api/get-books.php")
        .then((res) => res.json())
        .then((data) => setBooks(data))
        .catch(() => setBooks([]))
    }, [])

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
          const imageUrl = e.target.result
          setImagePreview(imageUrl)
          setFormData((prev) => ({
            ...prev,
            image: imageUrl,
          }))
        }
        reader.readAsDataURL(file)
      }
    }

    const handleSubmit = async (e) => {
      e.preventDefault()
      if (editingBook) {
        // Edit book
        const response = await fetch("/api/edit-book.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ ...formData, id: editingBook.id }),
        })
        const result = await response.json()
        if (result.success) {
          setBooks(books.map((book) => (book.id === editingBook.id ? { ...formData, id: editingBook.id } : book)))
          setEditingBook(null)
        }
      } else {
        // Add book
        const response = await fetch("/api/add-book.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(formData),
        })
        const result = await response.json()
        if (result.success) {
          setBooks([
            {
              ...formData,
              id: result.id,
              year: Number.parseInt(formData.year),
              rating: (Math.random() * 2 + 3).toFixed(1),
            },
            ...books,
          ])
        }
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

    const handleDelete = async (bookId) => {
      if (confirm("Are you sure you want to delete this book? 🥺")) {
        const response = await fetch("/api/delete-book.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: bookId }),
        })
        const result = await response.json()
        if (result.success) {
          setBooks(books.filter((book) => book.id !== bookId))
        }
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
      <div className="books-page book-management-highlighted">
        {/* Header */}
        <header className="header">
          <div className="profile-section">
            <Link href="/account" className="profile-link">
              <div className="profile-avatar">
                <img src="/cute-anime-girl-avatar.png" alt="Profile" className="avatar-img" />
              </div>
              <div className="profile-info">
                <span className="profile-name">Kawaii Reader</span>
                <span className="profile-status">📚 Reading</span>
              </div>
            </Link>
          </div>

          <div className="logo">
            <div className="logo-icon">🌸</div>
            <div className="logo-text">
              <h1>Cherub Library</h1>
              <p>Save books you love ♡</p>
            </div>
          </div>
          <nav className="nav">
            <Link href="/" className="nav-link">
              🏠 Home
            </Link>
            <Link href="/library" className="nav-link">
              📚 Library
            </Link>
            <Link href="/add-books" className="nav-link active">
              ➕ Add Books
            </Link>
            <Link href="/account" className="nav-link">
              👤 Account
            </Link>
          </nav>
        </header>

        <div className="book-management-container">
          <div className="management-header">
            <h1 className="management-title">➕ Add & Manage Books ✨</h1>
            <p className="management-subtitle">Add new books to your kawaii collection</p>
          </div>

          {/* Add/Edit Book Form */}
          <div className="add-book-form">
            <h2>{editingBook ? "✏️ Edit Book" : "📚 Add New Book"}</h2>
            <form onSubmit={handleSubmit}>
              <div className="form-row">
                <div className="form-group">
                  <label>📖 Book Title</label>
                  <input
                    type="text"
                    name="title"
                    value={formData.title}
                    onChange={handleInputChange}
                    placeholder="Enter book title..."
                    required
                  />
                </div>
                <div className="form-group">
                  <label>✍️ Author</label>
                  <input
                    type="text"
                    name="author"
                    value={formData.author}
                    onChange={handleInputChange}
                    placeholder="Enter author name..."
                    required
                  />
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>🎭 Genre</label>
                  <select name="genre" value={formData.genre} onChange={handleInputChange} required>
                    <option value="">Select genre...</option>
                    <option value="Romance">Romance</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Slice of Life">Slice of Life</option>
                  </select>
                </div>
                <div className="form-group">
                  <label>📅 Year Published</label>
                  <input
                    type="number"
                    name="year"
                    value={formData.year}
                    onChange={handleInputChange}
                    placeholder="2024"
                    min="1900"
                    max="2024"
                    required
                  />
                </div>
              </div>

              <div className="form-group">
                <label>🖼️ Book Cover</label>
                <div className="file-upload-container">
                  <input
                    type="file"
                    id="image-upload"
                    accept="image/*"
                    onChange={handleImageChange}
                    className="file-input"
                  />
                  <label htmlFor="image-upload" className="file-upload-btn">
                    � Choose Image
                  </label>
                  {imagePreview && (
                    <div className="image-preview">
                      <img src={imagePreview || "/placeholder.svg"} alt="Preview" />
                    </div>
                  )}
                </div>
              </div>

              <div className="form-group">
                <label>🔗 Book Link</label>
                <input
                  type="url"
                  name="link"
                  value={formData.link}
                  onChange={handleInputChange}
                  placeholder="https://example.com/book-link"
                  required
                />
              </div>

              <div className="form-actions">
                <button type="submit" className="submit-btn">
                  {editingBook ? "💾 Update Book" : "✨ Add Book"}
                </button>
                {editingBook && (
                  <button type="button" onClick={cancelEdit} className="cancel-btn">
                    ❌ Cancel
                  </button>
                )}
              </div>
            </form>
          </div>

          {/* Manage Existing Books */}
          {books.length > 0 && (
            <div className="manage-books">
              <h2>📚 Manage Your Books</h2>
              <div className="books-list">
                {books.map((book) => (
                  <div key={book.id} className="book-item">
                    <div className="book-cover-small">
                      <img src={book.image || "/placeholder.svg"} alt={book.title} />
                    </div>
                    <div className="book-details">
                      <h3>{book.title}</h3>
                      <p>by {book.author}</p>
                      <span className="book-genre">
                        {book.genre} • {book.year}
                      </span>
                    </div>
                    <div className="book-actions">
                      <button onClick={() => handleEdit(book)} className="edit-btn">
                        ✏️ Edit
                      </button>
                      <button onClick={() => handleDelete(book.id)} className="delete-btn">
                        🗑️ Delete
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
    <div
      className="book-management-view"
      style={{ backgroundColor: "#e8f5e8", padding: "20px", borderRadius: "15px", border: "3px solid #4ade80" }}
    >
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
                <label>🖼️ Book Cover Image</label>
                <div className="image-upload-section">
                  <input
                    type="file"
                    accept="image/*"
                    onChange={handleImageUpload}
                    className="file-input"
                    id="image-upload"
                  />
                  <label htmlFor="image-upload" className="file-upload-btn">
                    📁 Select Image from Device
                  </label>
                  {formData.image && (
                    <div className="image-preview">
                      <img src={formData.image || "/placeholder.svg"} alt="Book cover preview" />
                      <span className="preview-text">Preview</span>
                    </div>
                  )}
                </div>
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
