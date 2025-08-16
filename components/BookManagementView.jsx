"use client"

import { useState } from "react"
import "./BookManagementView.css"

const BookManagementView = ({ books, setBooks }) => {
  const [showForm, setShowForm] = useState(false)
  const [editingBook, setEditingBook] = useState(null)
  const [formData, setFormData] = useState({
    title: "",
    author: "",
    genre: "",
    year: "",
    image: "",
    link: "",
    description: "",
  })
  const [selectedImage, setSelectedImage] = useState(null)

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
        setSelectedImage(imageUrl)
        setFormData((prev) => ({
          ...prev,
          image: imageUrl,
        }))
      }
      reader.readAsDataURL(file)
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault()

    if (editingBook) {
      // Update existing book
      setBooks(books.map((book) => (book.id === editingBook.id ? { ...book, ...formData } : book)))
    } else {
      // Add new book
      const newBook = {
        id: Date.now(),
        ...formData,
        rating: 4.5,
        description:
          formData.description ||
          "A wonderful book that will captivate readers with its engaging story and memorable characters.",
      }
      setBooks([...books, newBook])
    }

    // Reset form
    setFormData({
      title: "",
      author: "",
      genre: "",
      year: "",
      image: "",
      link: "",
      description: "",
    })
    setSelectedImage(null)
    setShowForm(false)
    setEditingBook(null)
  }

  const handleEdit = (book) => {
    setEditingBook(book)
    setFormData({
      title: book.title,
      author: book.author,
      genre: book.genre,
      year: book.year,
      image: book.image,
      link: book.link || "",
      description: book.description || "",
    })
    setSelectedImage(book.image)
    setShowForm(true)
  }

  const handleDelete = (bookId) => {
    if (window.confirm("Are you sure you want to delete this book?")) {
      setBooks(books.filter((book) => book.id !== bookId))
    }
  }

  const closeForm = () => {
    setShowForm(false)
    setEditingBook(null)
    setFormData({
      title: "",
      author: "",
      genre: "",
      year: "",
      image: "",
      link: "",
      description: "",
    })
    setSelectedImage(null)
  }

  return (
    <div className="book-management-view">
      <div className="management-header">
        <div className="header-info">
          <h2>📚 Book Management</h2>
          <p>Add, edit, and organize your book collection</p>
        </div>
        <button className="add-book-btn" onClick={() => setShowForm(true)}>
          <span className="btn-icon">➕</span>
          Add New Book
        </button>
      </div>

      {/* Book Form Modal */}
      {showForm && (
        <div className="book-form-overlay">
          <div className="book-form-container">
            <div className="form-header">
              <h3>{editingBook ? "✏️ Edit Book" : "➕ Add New Book"}</h3>
              <button className="close-btn" onClick={closeForm}>
                ✕
              </button>
            </div>

            <form className="book-form" onSubmit={handleSubmit}>
              <div className="form-row">
                <div className="form-group">
                  <label htmlFor="title">Book Title *</label>
                  <input
                    type="text"
                    id="title"
                    name="title"
                    value={formData.title}
                    onChange={handleInputChange}
                    required
                    placeholder="Enter book title"
                  />
                </div>
                <div className="form-group">
                  <label htmlFor="author">Author *</label>
                  <input
                    type="text"
                    id="author"
                    name="author"
                    value={formData.author}
                    onChange={handleInputChange}
                    required
                    placeholder="Enter author name"
                  />
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label htmlFor="genre">Genre</label>
                  <select id="genre" name="genre" value={formData.genre} onChange={handleInputChange}>
                    <option value="">Select Genre</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Non-Fiction">Non-Fiction</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                    <option value="Sci-Fi">Science Fiction</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Biography">Biography</option>
                    <option value="History">History</option>
                    <option value="Self-Help">Self-Help</option>
                    <option value="Poetry">Poetry</option>
                  </select>
                </div>
                <div className="form-group">
                  <label htmlFor="year">Publication Year</label>
                  <input
                    type="number"
                    id="year"
                    name="year"
                    value={formData.year}
                    onChange={handleInputChange}
                    min="1000"
                    max="2024"
                    placeholder="2024"
                  />
                </div>
              </div>

              <div className="form-group">
                <label>Book Cover Image</label>
                <div className="image-upload-section">
                  <input
                    type="file"
                    id="image-upload"
                    className="file-input"
                    accept="image/*"
                    onChange={handleImageChange}
                  />
                  <label htmlFor="image-upload" className="file-upload-btn">
                    📷 Select Image from Device
                  </label>
                  {selectedImage && (
                    <div className="image-preview">
                      <img src={selectedImage || "/placeholder.svg"} alt="Book cover preview" />
                      <span className="preview-text">✨ Cover Preview</span>
                    </div>
                  )}
                </div>
              </div>

              <div className="form-group">
                <label htmlFor="link">Book Link (Optional)</label>
                <input
                  type="url"
                  id="link"
                  name="link"
                  value={formData.link}
                  onChange={handleInputChange}
                  placeholder="https://example.com/book-link"
                />
              </div>

              <div className="form-group">
                <label htmlFor="description">Description (Optional)</label>
                <textarea
                  id="description"
                  name="description"
                  value={formData.description}
                  onChange={handleInputChange}
                  rows="3"
                  placeholder="Brief description of the book..."
                  style={{
                    width: "100%",
                    padding: "1rem",
                    border: "2px solid #d1fae5",
                    borderRadius: "12px",
                    fontSize: "1rem",
                    background: "#f9fafb",
                    resize: "vertical",
                    fontFamily: "inherit",
                  }}
                />
              </div>

              <div className="form-actions">
                <button type="button" className="cancel-btn" onClick={closeForm}>
                  Cancel
                </button>
                <button type="submit" className="submit-btn">
                  {editingBook ? "💾 Update Book" : "✨ Add Book"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Books Management Section */}
      <div className="books-management-section">
        <div className="section-header">
          <h3>📖 Your Book Collection</h3>
          <div className="collection-count">
            <span className="count-number">{books.length}</span>
            <span className="count-text">books</span>
          </div>
        </div>

        {books.length === 0 ? (
          <div
            style={{
              textAlign: "center",
              padding: "3rem",
              color: "#6b7280",
              background: "white",
              borderRadius: "15px",
              border: "2px dashed #d1fae5",
            }}
          >
            <div style={{ fontSize: "3rem", marginBottom: "1rem" }}>📚</div>
            <h3 style={{ color: "#16a34a", marginBottom: "0.5rem" }}>No books yet!</h3>
            <p>Start building your collection by adding your first book.</p>
          </div>
        ) : (
          <div className="management-books-grid">
            {books.map((book) => (
              <div key={book.id} className="management-book-card">
                <div className="book-cover-small">
                  <img src={book.image || "/placeholder.svg?height=70&width=50&query=book cover"} alt={book.title} />
                </div>
                <div className="book-details">
                  <h4>{book.title}</h4>
                  <p>by {book.author}</p>
                  <div className="book-meta-small">
                    {book.genre && <span>{book.genre}</span>}
                    {book.year && <span>{book.year}</span>}
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
        )}
      </div>
    </div>
  )
}

export default BookManagementView
