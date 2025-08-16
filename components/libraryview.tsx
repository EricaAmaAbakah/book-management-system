"use client"

import { useState, useMemo } from "react"

const genres = ["All", "Romance", "Fantasy", "Mystery", "Sci-Fi", "Adventure", "Drama", "Comedy"]
const years = ["All", "2024", "2023", "2022", "2021", "2020", "2019", "2018"]

export default function LibraryView({
  books,
  setSelectedBook,
}: { books: any[]; setSelectedBook: (book: any) => void }) {
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
