// Books storage
let books = JSON.parse(localStorage.getItem("cherubLibraryBooks")) || []
let editingBookId = null

// Initialize the page
document.addEventListener("DOMContentLoaded", () => {
  setupEventListeners()
  renderBooks()
})

function setupEventListeners() {
  // Form submission
  document.getElementById("bookForm").addEventListener("submit", handleFormSubmit)

  // Image upload
  document.getElementById("imageUpload").addEventListener("change", handleImageUpload)

  // Delete modal close on outside click
  document.getElementById("deleteModal").addEventListener("click", (e) => {
    if (e.target.id === "deleteModal") {
      closeDeleteModal()
    }
  })
}

function handleFormSubmit(e) {
  e.preventDefault()

  const formData = {
    title: document.getElementById("bookTitle").value,
    author: document.getElementById("bookAuthor").value,
    genre: document.getElementById("bookGenre").value,
    year: Number.parseInt(document.getElementById("bookYear").value),
    link: document.getElementById("bookLink").value,
    image: document.getElementById("imagePreview").src || "/placeholder.svg",
  }

  if (editingBookId) {
    // Update existing book
    const bookIndex = books.findIndex((book) => book.id === editingBookId)
    if (bookIndex !== -1) {
      books[bookIndex] = { ...books[bookIndex], ...formData }
    }
    editingBookId = null
    document.getElementById("formTitle").textContent = "Add a New Book"
    document.getElementById("submitBtn").textContent = "Add Book"
    document.getElementById("cancelBtn").style.display = "none"
  } else {
    // Add new book
    const newBook = {
      ...formData,
      id: Date.now(),
      rating: (Math.random() * 2 + 3).toFixed(1),
      description: `A wonderful ${formData.genre.toLowerCase()} story by ${formData.author}.`,
    }
    books.push(newBook)
  }

  // Save to localStorage
  localStorage.setItem("cherubLibraryBooks", JSON.stringify(books))

  // Reset form
  resetForm()
  renderBooks()

  // Show success message
  showNotification(editingBookId ? "Book updated successfully!" : "Book added successfully!")
}

function handleImageUpload(e) {
  const file = e.target.files[0]
  if (!file) return

  const reader = new FileReader()
  reader.onload = (e) => {
    const preview = document.getElementById("imagePreview")
    const container = document.getElementById("imagePreviewContainer")

    preview.src = e.target.result
    container.style.display = "block"
  }
  reader.readAsDataURL(file)
}

function renderBooks() {
  const managementSection = document.getElementById("booksManagementSection")
  const managementGrid = document.getElementById("booksManagementGrid")

  if (books.length === 0) {
    managementSection.style.display = "none"
    return
  }

  managementSection.style.display = "block"

  managementGrid.innerHTML = books
    .map(
      (book) => `
    <div class="management-book-card">
      <div class="management-book-cover">
        <img src="${book.image}" alt="${book.title}" onerror="this.src='/placeholder.svg'">
      </div>
      <div class="management-book-info">
        <h3 class="management-book-title">${book.title}</h3>
        <p class="management-book-author">by ${book.author}</p>
        <div class="management-book-meta">
          <span class="meta-genre">${book.genre}</span>
          <span class="meta-year">${book.year}</span>
        </div>
      </div>
      <div class="management-book-actions">
        <button onclick="editBook(${book.id})" class="action-btn edit-btn">Edit</button>
        <button onclick="confirmDeleteBook(${book.id})" class="action-btn delete-btn">Delete</button>
      </div>
    </div>
  `,
    )
    .join("")
}

function editBook(bookId) {
  const book = books.find((b) => b.id === bookId)
  if (!book) return

  editingBookId = bookId

  // Populate form
  document.getElementById("bookTitle").value = book.title
  document.getElementById("bookAuthor").value = book.author
  document.getElementById("bookGenre").value = book.genre
  document.getElementById("bookYear").value = book.year
  document.getElementById("bookLink").value = book.link

  // Show image preview if exists
  if (book.image && book.image !== "/placeholder.svg") {
    document.getElementById("imagePreview").src = book.image
    document.getElementById("imagePreviewContainer").style.display = "block"
  }

  // Update form UI
  document.getElementById("formTitle").textContent = "Edit Your Book"
  document.getElementById("submitBtn").textContent = "Update Book"
  document.getElementById("cancelBtn").style.display = "inline-block"

  // Scroll to form
  document.querySelector(".add-book-form-container").scrollIntoView({
    behavior: "smooth",
  })
}

function cancelEdit() {
  editingBookId = null
  resetForm()
  document.getElementById("formTitle").textContent = "Add a New Book"
  document.getElementById("submitBtn").textContent = "Add Book"
  document.getElementById("cancelBtn").style.display = "none"
}

function confirmDeleteBook(bookId) {
  const book = books.find((b) => b.id === bookId)
  if (!book) return

  // Show delete confirmation modal
  document.getElementById("deleteModal").style.display = "flex"

  // Set up confirm button
  document.getElementById("confirmDeleteBtn").onclick = () => {
    deleteBook(bookId)
    closeDeleteModal()
  }
}

function deleteBook(bookId) {
  books = books.filter((book) => book.id !== bookId)
  localStorage.setItem("cherubLibraryBooks", JSON.stringify(books))
  renderBooks()
  showNotification("Book deleted successfully!")
}

function closeDeleteModal() {
  document.getElementById("deleteModal").style.display = "none"
}

function resetForm() {
  document.getElementById("bookForm").reset()
  document.getElementById("imagePreviewContainer").style.display = "none"
  document.getElementById("imagePreview").src = "/placeholder.svg"
}

function showNotification(message) {
  // Create notification element
  const notification = document.createElement("div")
  notification.className = "notification"
  notification.textContent = message
  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    z-index: 1000;
    font-weight: 600;
    transform: translateX(100%);
    transition: transform 0.3s ease;
  `

  document.body.appendChild(notification)

  // Animate in
  setTimeout(() => {
    notification.style.transform = "translateX(0)"
  }, 100)

  // Remove after 3 seconds
  setTimeout(() => {
    notification.style.transform = "translateX(100%)"
    setTimeout(() => {
      document.body.removeChild(notification)
    }, 300)
  }, 3000)
}

// Add floating animation enhancement
document.addEventListener("DOMContentLoaded", () => {
  const floatingIcons = document.querySelectorAll(".float-icon")

  floatingIcons.forEach((icon, index) => {
    setInterval(
      () => {
        const randomX = Math.random() * 15 - 7.5
        const randomY = Math.random() * 15 - 7.5
        icon.style.transform = `translate(${randomX}px, ${randomY}px)`
      },
      3500 + index * 700,
    )
  })
})
