"use client"
import React, { useState } from "react"
import Link from "next/link"
import { useRouter } from "next/navigation"

export default function LoginPage() {
  const [showStudentForm, setShowStudentForm] = useState(false)
  const [showAdminForm, setShowAdminForm] = useState(false)
  const router = useRouter()

  const handleStudentLogin = (e) => {
    e.preventDefault()
    router.push("/student-dashboard")
  }

  const handleAdminLogin = (e) => {
    e.preventDefault()
    router.push("/admin-dashboard")
  }

  return (
    <div className="login-page-background">
      <header className="login-header">
        <div className="login-logo-container">
          <Link href="/" className="login-logo-link">
            <span className="login-logo-text">📚 Kawaii Library</span>
            <div className="login-sparkle">✨</div>
          </Link>
        </div>
        <nav className="login-nav">
          <Link href="/" className="login-nav-link">
            🏠 Home
          </Link>
          <Link href="#" className="login-nav-link">
            📖 Books
          </Link>
          <Link href="/login" className="login-nav-link login-nav-active">
            🔐 Login
          </Link>
          <Link href="/signup" className="login-nav-link">
            💫 Sign Up
          </Link>
        </nav>
      </header>

      <main className="login-main-container">
        <div className="login-card">
          <div className="login-card-header">
            <div className="login-title-icon">🔐</div>
            <h1 className="login-title">Welcome Back</h1>
            <p className="login-subtitle">Sign in to your magical library</p>
            <div className="login-decorative-line"></div>
          </div>

          {!showStudentForm && !showAdminForm && (
            <div className="login-options">
              <button className="login-option-card login-student-option" onClick={() => setShowStudentForm(true)}>
                <div className="login-option-icon">🎓</div>
                <h3 className="login-option-title">Student Portal</h3>
                <p className="login-option-desc">Access your reading collection</p>
                <div className="login-option-arrow">→</div>
              </button>

              <button className="login-option-card login-admin-option" onClick={() => setShowAdminForm(true)}>
                <div className="login-option-icon">👑</div>
                <h3 className="login-option-title">Admin Portal</h3>
                <p className="login-option-desc">Manage library system</p>
                <div className="login-option-arrow">→</div>
              </button>
            </div>
          )}

          {showStudentForm && (
            <div className="login-form-container">
              <div className="login-form-header">
                <button className="login-back-btn" onClick={() => setShowStudentForm(false)}>
                  ← Back
                </button>
                <h2 className="login-form-title">🎓 Student Login</h2>
              </div>

              <form onSubmit={handleStudentLogin} className="login-form">
                <div className="login-input-group">
                  <div className="login-input-icon">📧</div>
                  <div className="login-input-wrapper">
                    <input type="email" required className="login-input" placeholder="Enter your email" />
                    <label className="login-label">Email Address</label>
                  </div>
                </div>

                <div className="login-input-group">
                  <div className="login-input-icon">🔒</div>
                  <div className="login-input-wrapper">
                    <input type="password" required className="login-input" placeholder="Enter your password" />
                    <label className="login-label">Password</label>
                  </div>
                </div>

                <button type="submit" className="login-submit-btn login-student-btn">
                  <span className="login-btn-text">Sign In as Student</span>
                  <div className="login-btn-icon">🌸</div>
                </button>
              </form>
            </div>
          )}

          {showAdminForm && (
            <div className="login-form-container">
              <div className="login-form-header">
                <button className="login-back-btn" onClick={() => setShowAdminForm(false)}>
                  ← Back
                </button>
                <h2 className="login-form-title">👑 Admin Login</h2>
              </div>

              <form onSubmit={handleAdminLogin} className="login-form">
                <div className="login-input-group">
                  <div className="login-input-icon">📧</div>
                  <div className="login-input-wrapper">
                    <input type="email" required className="login-input" placeholder="Enter admin email" />
                    <label className="login-label">Admin Email</label>
                  </div>
                </div>

                <div className="login-input-group">
                  <div className="login-input-icon">🔒</div>
                  <div className="login-input-wrapper">
                    <input type="password" required className="login-input" placeholder="Enter admin password" />
                    <label className="login-label">Admin Password</label>
                  </div>
                </div>

                <button type="submit" className="login-submit-btn login-admin-btn">
                  <span className="login-btn-text">Sign In as Admin</span>
                  <div className="login-btn-icon">✨</div>
                </button>
              </form>
            </div>
          )}

          <div className="login-card-footer">
            <div className="login-divider">
              <span className="login-divider-text">New to our library?</span>
            </div>
            <Link href="/signup" className="login-link">
              Create an account 💫
            </Link>
          </div>
        </div>
      </main>

      <div className="login-floating-elements">
        <div className="login-float-1">✨</div>
        <div className="login-float-2">🌸</div>
        <div className="login-float-3">💫</div>
      </div>
    </div>
  )
}
