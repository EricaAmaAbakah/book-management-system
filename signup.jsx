"use client"
import React from "react"
import Link from "next/link"
import { useRouter } from "next/navigation"

export default function SignupPage() {
  const router = useRouter()

  const handleSignup = (e) => {
    e.preventDefault()
    const form = e.target
    const formData = new FormData(form)
    const password = formData.get("password")
    const confirmPassword = formData.get("confirm-password")

    if (password !== confirmPassword) {
      alert("Passwords do not match! Please try again. 💔")
      return
    }

    alert("Account created successfully! Welcome to Kawaii Library! 🎉")
    router.push("/login")
  }

  return (
    <div className="elegant-page-background">
      {/* Elegant Header */}
      <header className="elegant-header">
        <div className="elegant-logo-container">
          <Link href="/" className="elegant-logo-link">
            <span className="elegant-logo-text">📚 Kawaii Library</span>
            <div className="elegant-sparkle">✨</div>
          </Link>
        </div>
        <nav className="elegant-nav">
          <Link href="/" className="elegant-nav-link">
            🏠 Home
          </Link>
          <Link href="#" className="elegant-nav-link">
            📖 Books
          </Link>
          <Link href="/login" className="elegant-nav-link">
            🔐 Login
          </Link>
          <Link href="/signup" className="elegant-nav-link elegant-nav-active">
            💫 Sign Up
          </Link>
        </nav>
      </header>

      {/* Elegant Main Content */}
      <main className="elegant-main-container">
        <div className="elegant-signup-card">
          {/* Elegant Header Section */}
          <div className="elegant-card-header">
            <div className="elegant-title-icon">🌸</div>
            <h1 className="elegant-title">Create Your Account</h1>
            <p className="elegant-subtitle">Join our magical reading community</p>
            <div className="elegant-decorative-line"></div>
          </div>

          {/* Elegant Form */}
          <form onSubmit={handleSignup} className="elegant-form">
            <div className="elegant-input-group">
              <div className="elegant-input-icon">✨</div>
              <div className="elegant-input-wrapper">
                <input type="text" name="name" required className="elegant-input" placeholder="Enter your full name" />
                <label className="elegant-label">Full Name</label>
              </div>
            </div>

            <div className="elegant-input-group">
              <div className="elegant-input-icon">📧</div>
              <div className="elegant-input-wrapper">
                <input
                  type="email"
                  name="email"
                  required
                  className="elegant-input"
                  placeholder="Enter your email address"
                />
                <label className="elegant-label">Email Address</label>
              </div>
            </div>

            <div className="elegant-input-group">
              <div className="elegant-input-icon">🔒</div>
              <div className="elegant-input-wrapper">
                <input
                  type="password"
                  name="password"
                  required
                  className="elegant-input"
                  placeholder="Create a secure password"
                />
                <label className="elegant-label">Password</label>
              </div>
            </div>

            <div className="elegant-input-group">
              <div className="elegant-input-icon">🔐</div>
              <div className="elegant-input-wrapper">
                <input
                  type="password"
                  name="confirm-password"
                  required
                  className="elegant-input"
                  placeholder="Confirm your password"
                />
                <label className="elegant-label">Confirm Password</label>
              </div>
            </div>

            <button type="submit" className="elegant-submit-btn">
              <span className="elegant-btn-text">Create Account</span>
              <div className="elegant-btn-icon">🌟</div>
            </button>
          </form>

          {/* Elegant Footer */}
          <div className="elegant-card-footer">
            <div className="elegant-divider">
              <span className="elegant-divider-text">Already have an account?</span>
            </div>
            <Link href="/login" className="elegant-link">
              Sign in here 💖
            </Link>
          </div>
        </div>
      </main>

      {/* Elegant Floating Elements */}
      <div className="elegant-floating-elements">
        <div className="elegant-float-1">✨</div>
        <div className="elegant-float-2">🌸</div>
        <div className="elegant-float-3">💫</div>
      </div>
    </div>
  )
}
