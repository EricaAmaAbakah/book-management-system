let books = []
let currentBook = null
let filteredBooks = []

// Initialize the library page
document.addEventListener("DOMContentLoaded", () => {
  loadBooksFromDatabase()
  setupEventListeners()
})

function loadBooksFromDatabase() {
  fetch("api/get_books.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        books = data.books
        filteredBooks = [...books]
        renderBooks()
      } else {
        console.error("Error loading books:", data.message)
        showError("Failed to load books: " + data.message)
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      showError("Failed to connect to database")
    })
}

function setupEventListeners() {
  // Search functionality
  document.getElementById("searchInput").addEventListener("input", filterBooks)

  // Filter functionality
  document.getElementById("genreFilter").addEventListener("change", filterBooks)
  document.getElementById("yearFilter").addEventListener("change", filterBooks)

  // File upload for edit mode
  document.getElementById("bookCoverUpload").addEventListener("change", handleImageUpload)

  // Close modal when clicking outside
  document.getElementById("bookModal").addEventListener("click", function (e) {
    if (e.target === this) {
      closeBookModal()
    }
  })
}

function filterBooks() {
  const searchTerm = document.getElementById("searchInput").value.toLowerCase()
  const selectedGenre = document.getElementById("genreFilter").value
  const selectedYear = document.getElementById("yearFilter").value

  filteredBooks = books.filter((book) => {
    const matchesSearch =
      book.title.toLowerCase().includes(searchTerm) || book.author.toLowerCase().includes(searchTerm)
    const matchesGenre = selectedGenre === "All" || book.genre === selectedGenre
    const matchesYear = selectedYear === "All" || book.year.toString() === selectedYear

    return matchesSearch && matchesGenre && matchesYear
  })

  renderBooks()
}

function renderBooks() {
  const booksGrid = document.getElementById("booksGrid")
  const noResults = document.getElementById("noResults")

  if (filteredBooks.length === 0) {
    booksGrid.style.display = "none"
    noResults.style.display = "block"
    return
  }

  booksGrid.style.display = "grid"
  noResults.style.display = "none"

  booksGrid.innerHTML = filteredBooks
    .map(
      (book) => `
  <div class="library-book-card" onclick="openBookDetails(${book.id})">
      <div class="library-book-cover">
        <img src="${book.image || "/placeholder.svg"}" alt="${book.title}" onerror="this.src='/placeholder.svg'">
        <div class="library-book-overlay">
          <button class="library-view-btn">View Details</button>
        </div>
      </div>
      <div class="library-book-info">
        <h3 class="library-book-title">${book.title}</h3>
        <p class="library-book-author">by ${book.author}</p>
        <div class="library-book-tags">
          <span class="genre-tag">${book.genre}</span>
          <span class="year-tag">${book.year}</span>
        </div>
        <div class="library-book-rating">
          <span class="stars">⭐</span>
          <span class="rating-value">${book.rating || "0.0"}</span>
        </div>
      </div>
    </div>
  `,
    )
    .join("")
}

function openBookModal(bookId) {
  fetch(`api/get_book.php?id=${bookId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        currentBook = data.book

        // Populate modal with book data
  document.getElementById("modalImage").src = currentBook.image || currentBook.cover_image || "/placeholder.svg"
        document.getElementById("modalImage").alt = currentBook.title
        document.getElementById("modalTitle").textContent = currentBook.title
        document.getElementById("modalAuthor").textContent = `by ${currentBook.author}`
        document.getElementById("modalGenre").textContent = currentBook.genre
        document.getElementById("modalYear").textContent = currentBook.year
        document.getElementById("modalRating").textContent = currentBook.rating || "0.0"
        document.getElementById("modalDescription").textContent = currentBook.description || "No description available"
        document.getElementById("modalReadLink").href = currentBook.link || "#"

        // Show modal
        document.getElementById("bookModal").style.display = "flex"
        document.body.style.overflow = "hidden"
      } else {
        showError("Failed to load book details: " + data.message)
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      showError("Failed to load book details")
    })
}

function closeBookModal() {
  document.getElementById("bookModal").style.display = "none"
  document.body.style.overflow = "auto"

  // Reset to view mode
  document.getElementById("viewMode").style.display = "block"
  document.getElementById("editMode").style.display = "none"

  currentBook = null
}

function startEditMode() {
  if (!currentBook) return

  // Populate edit form
  document.getElementById("editTitle").value = currentBook.title
  document.getElementById("editAuthor").value = currentBook.author
  document.getElementById("editGenre").value = currentBook.genre
  document.getElementById("editYear").value = currentBook.year
  document.getElementById("editLink").value = currentBook.link || ""
  document.getElementById("editDescription").value = currentBook.description || ""

  // Show current image in preview
  if (currentBook.image) {
    document.getElementById("previewImage").src = currentBook.image
    document.getElementById("editImagePreview").style.display = "block"
  }

  // Show edit mode
  document.getElementById("viewMode").style.display = "none"
  document.getElementById("editMode").style.display = "block"
}

function cancelEdit() {
  document.getElementById("viewMode").style.display = "block"
  document.getElementById("editMode").style.display = "none"

  // Clear image preview
  document.getElementById("editImagePreview").style.display = "none"
}

function saveBookEdit() {
  if (!currentBook) return

  const formData = new FormData()
  formData.append("id", currentBook.id)
  formData.append("title", document.getElementById("editTitle").value)
  formData.append("author", document.getElementById("editAuthor").value)
  formData.append("genre", document.getElementById("editGenre").value)
  formData.append("year", document.getElementById("editYear").value)
  formData.append("link", document.getElementById("editLink").value)
  formData.append("description", document.getElementById("editDescription").value)

  // Handle cover image
  const coverFile = document.getElementById("bookCoverUpload").files[0]
  if (coverFile) {
    const reader = new FileReader()
    reader.onload = (e) => {
      formData.append("cover_image", e.target.result)
      submitBookUpdate(formData)
    }
    reader.readAsDataURL(coverFile)
  } else {
    formData.append("cover_image", currentBook.image || "")
    submitBookUpdate(formData)
  }
}

function submitBookUpdate(formData) {
  fetch("api/update_book.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showSuccess("Book updated successfully!")

        // Reload books from database
        loadBooksFromDatabase()

        // Refresh current book details
        openBookModal(currentBook.id)

        // Switch back to view mode
        cancelEdit()
      } else {
        showError("Failed to update book: " + data.message)
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      showError("Failed to update book")
    })
}

function handleImageUpload(event) {
  const file = event.target.files[0]
  if (!file) return

  const reader = new FileReader()
  reader.onload = (e) => {
    const previewContainer = document.getElementById("editImagePreview")
    const previewImg = document.getElementById("previewImage")

    previewImg.src = e.target.result
    previewContainer.style.display = "block"
  }
  reader.readAsDataURL(file)
}

function showError(message) {
  const notification = document.createElement("div")
  notification.className = "notification error"
  notification.textContent = message
  document.body.appendChild(notification)

  setTimeout(() => {
    notification.remove()
  }, 5000)
}

function showSuccess(message) {
  const notification = document.createElement("div")
  notification.className = "notification success"
  notification.textContent = message
  document.body.appendChild(notification)

  setTimeout(() => {
    notification.remove()
  }, 3000)
}

// Add floating animation enhancement
document.addEventListener("DOMContentLoaded", () => {
  const floatingIcons = document.querySelectorAll(".float-icon")

  floatingIcons.forEach((icon, index) => {
    setInterval(
      () => {
        const randomX = Math.random() * 10 - 5
        const randomY = Math.random() * 10 - 5
        icon.style.transform = `translate(${randomX}px, ${randomY}px)`
      },
      4000 + index * 800,
    )
  })
})
