// Account page functionality
document.addEventListener("DOMContentLoaded", () => {
  // Load saved data
  loadUserData()

  // Profile image upload
  const profileUpload = document.getElementById("profile-upload")
  const profileImage = document.getElementById("profileImage")

  profileUpload.addEventListener("change", (event) => {
    const file = event.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        profileImage.src = e.target.result
        saveUserData()
      }
      reader.readAsDataURL(file)
    }
  })

  // Username editing
  const editButton = document.getElementById("edit-button")
  const saveButton = document.getElementById("save-button")
  const cancelButton = document.getElementById("cancel-button")
  const usernameDisplay = document.getElementById("username-display")
  const usernameEdit = document.getElementById("username-edit")
  const usernameText = document.getElementById("username-text")
  const usernameInput = document.getElementById("username-input")

  editButton.addEventListener("click", () => {
    usernameInput.value = usernameText.textContent
    usernameDisplay.style.display = "none"
    usernameEdit.style.display = "flex"
    usernameInput.focus()
  })

  saveButton.addEventListener("click", () => {
    const newUsername = usernameInput.value.trim()
    if (newUsername) {
      usernameText.textContent = newUsername
      usernameDisplay.style.display = "flex"
      usernameEdit.style.display = "none"
      saveUserData()
      showNotification("Username updated successfully! ✨")
    }
  })

  cancelButton.addEventListener("click", () => {
    usernameDisplay.style.display = "flex"
    usernameEdit.style.display = "none"
  })

  // Update book count from library
  updateBookCount()
})

function loadUserData() {
  const userData = JSON.parse(localStorage.getItem("cherubLibraryUser") || "{}")

  if (userData.username) {
    document.getElementById("username-text").textContent = userData.username
  }

  if (userData.profileImage) {
    document.getElementById("profileImage").src = userData.profileImage
  }
}

function saveUserData() {
  const userData = {
    username: document.getElementById("username-text").textContent,
    profileImage: document.getElementById("profileImage").src,
  }

  localStorage.setItem("cherubLibraryUser", JSON.stringify(userData))
}

function updateBookCount() {
  const books = JSON.parse(localStorage.getItem("cherubLibraryBooks") || "[]")
  document.getElementById("books-count").textContent = books.length
}

function exportLibrary() {
  const books = JSON.parse(localStorage.getItem("cherubLibraryBooks") || "[]")
  const userData = JSON.parse(localStorage.getItem("cherubLibraryUser") || "{}")

  const exportData = {
    user: userData,
    books: books,
    exportDate: new Date().toISOString(),
  }

  const dataStr = JSON.stringify(exportData, null, 2)
  const dataBlob = new Blob([dataStr], { type: "application/json" })

  const link = document.createElement("a")
  link.href = URL.createObjectURL(dataBlob)
  link.download = "cherub-library-export.json"
  link.click()

  showNotification("Library exported successfully! 📱")
}

function showNotification(message) {
  const notification = document.getElementById("notification")
  notification.textContent = message
  notification.classList.add("show")

  setTimeout(() => {
    notification.classList.remove("show")
  }, 3000)
}
