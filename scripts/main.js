// Modal functionality
function openLoginModal() {
  document.getElementById("loginModal").style.display = "flex"
}

function closeLoginModal() {
  document.getElementById("loginModal").style.display = "none"
}

function openSignupModal() {
  document.getElementById("signupModal").style.display = "flex"
}

function closeSignupModal() {
  document.getElementById("signupModal").style.display = "none"
}

// Close modals when clicking outside
document.addEventListener("click", (event) => {
  const loginModal = document.getElementById("loginModal")
  const signupModal = document.getElementById("signupModal")

  if (event.target === loginModal) {
    closeLoginModal()
  }

  if (event.target === signupModal) {
    closeSignupModal()
  }
})

// Form handling
document.getElementById("loginForm").addEventListener("submit", (e) => {
  e.preventDefault()
  const email = document.getElementById("loginEmail").value
  const password = document.getElementById("loginPassword").value

  // Add login logic here
  console.log("Login attempt:", { email, password })
  alert("Login functionality would be implemented here!")
  closeLoginModal()
})

document.getElementById("signupForm").addEventListener("submit", (e) => {
  e.preventDefault()
  const name = document.getElementById("signupName").value
  const email = document.getElementById("signupEmail").value
  const password = document.getElementById("signupPassword").value

  // Add signup logic here
  console.log("Signup attempt:", { name, email, password })
  alert("Signup functionality would be implemented here!")
  closeSignupModal()
})

// Add floating animation enhancement
document.addEventListener("DOMContentLoaded", () => {
  const floatingIcons = document.querySelectorAll(".floating-icon")

  floatingIcons.forEach((icon, index) => {
    // Add random movement
    setInterval(
      () => {
        const randomX = Math.random() * 20 - 10
        const randomY = Math.random() * 20 - 10
        icon.style.transform = `translate(${randomX}px, ${randomY}px)`
      },
      3000 + index * 1000,
    )
  })
})
