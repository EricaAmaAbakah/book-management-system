"use client"
import Link from "next/link"
import "./books.css"

export default function BooksPage() {
  return (
    <div className="books-page">
      <div className="books-modal-overlay">
        <div className="books-modal-content">
          <div className="books-modal-header">
            <h2>🌸 Choose Your Action ♡</h2>
            <Link href="/" className="close-btn">
              &times;
            </Link>
          </div>
          <div className="books-options">
            <Link href="/library" className="books-option library-option">
              <div className="books-icon">📚</div>
              <h3>Access Your Library</h3>
              <p>Browse and search your saved books collection</p>
              <div className="kawaii-decoration">
                <span>📖</span>
                <span>💕</span>
                <span>✨</span>
              </div>
            </Link>
            <Link href="/add-books" className="books-option add-books-option">
              <div className="books-icon">➕</div>
              <h3>Add New Book</h3>
              <p>Add, edit, and manage your book collection</p>
              <div className="kawaii-decoration">
                <span>📝</span>
                <span>🌟</span>
                <span>💎</span>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  )
}
