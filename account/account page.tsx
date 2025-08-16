"use client"

import type React from "react"

import { useState } from "react"
import "./account.css"

export default function AccountPage() {
  const [username, setUsername] = useState("Kawaii Reader")
  const [profileImage, setProfileImage] = useState("/cute-anime-girl-avatar.png")
  const [isEditing, setIsEditing] = useState(false)
  const [tempUsername, setTempUsername] = useState(username)

  const handleImageUpload = (event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        setProfileImage(e.target?.result as string)
      }
      reader.readAsDataURL(file)
    }
  }

  const handleSaveChanges = () => {
    setUsername(tempUsername)
    setIsEditing(false)
  }

  const handleCancel = () => {
    setTempUsername(username)
    setIsEditing(false)
  }

  return (
    <div className="account-container">
      {/* Header */}
      <header className="account-header">
        <div className="logo">
          <div className="logo-icon">🌸</div>
          <div className="logo-text">
            <h1>Serenity Library</h1>
            <p>Save books you love ♡</p>
          </div>
        </div>
        <nav className="nav">
          <a href="/" className="nav-link">
            🏠 Home
          </a>
          <a href="/books" className="nav-link">
            📚 Books
          </a>
          <a href="/account" className="nav-link active">
            👤 Account
          </a>
        </nav>
      </header>

      {/* Main Content */}
      <main className="account-main">
        <div className="account-card">
          <div className="account-header-section">
            <h2 className="account-title">
              <span className="title-icon">👤</span>
              My Account
              <span className="sparkle">✨</span>
            </h2>
            <p className="account-subtitle">Manage your kawaii profile ♡</p>
          </div>

          <div className="profile-section">
            {/* Profile Picture */}
            <div className="profile-picture-section">
              <div className="profile-picture-container">
                <img src={profileImage || "/placeholder.svg"} alt="Profile Picture" className="profile-picture" />
                <div className="profile-picture-overlay">
                  <label htmlFor="profile-upload" className="upload-button">
                    📷<span className="upload-text">Change</span>
                  </label>
                  <input
                    id="profile-upload"
                    type="file"
                    accept="image/*"
                    onChange={handleImageUpload}
                    className="file-input"
                  />
                </div>
              </div>
              <p className="profile-picture-hint">Click to upload a new kawaii picture! 🎀</p>
            </div>

            {/* Username Section */}
            <div className="username-section">
              <label className="username-label">
                <span className="label-icon">🏷️</span>
                Username
              </label>

              {!isEditing ? (
                <div className="username-display">
                  <span className="username-text">{username}</span>
                  <button onClick={() => setIsEditing(true)} className="edit-button">
                    ✏️ Edit
                  </button>
                </div>
              ) : (
                <div className="username-edit">
                  <input
                    type="text"
                    value={tempUsername}
                    onChange={(e) => setTempUsername(e.target.value)}
                    className="username-input"
                    placeholder="Enter your kawaii username..."
                  />
                  <div className="edit-buttons">
                    <button onClick={handleSaveChanges} className="save-button">
                      💾 Save
                    </button>
                    <button onClick={handleCancel} className="cancel-button">
                      ❌ Cancel
                    </button>
                  </div>
                </div>
              )}
            </div>

            {/* Account Stats */}
            <div className="account-stats">
              <h3 className="stats-title">
                <span className="stats-icon">📊</span>
                Your Reading Stats
              </h3>
              <div className="stats-grid">
                <div className="stat-card">
                  <div className="stat-icon">📚</div>
                  <div className="stat-number">42</div>
                  <div className="stat-label">Books Saved</div>
                </div>
                <div className="stat-card">
                  <div className="stat-icon">⭐</div>
                  <div className="stat-number">38</div>
                  <div className="stat-label">Reviews</div>
                </div>
                <div className="stat-card">
                  <div className="stat-icon">🎯</div>
                  <div className="stat-number">15</div>
                  <div className="stat-label">Favorites</div>
                </div>
                <div className="stat-card">
                  <div className="stat-icon">🏆</div>
                  <div className="stat-number">7</div>
                  <div className="stat-label">Achievements</div>
                </div>
              </div>
            </div>

            {/* Quick Actions */}
            <div className="quick-actions">
              <h3 className="actions-title">
                <span className="actions-icon">⚡</span>
                Quick Actions
              </h3>
              <div className="actions-grid">
                <a href="/books" className="action-button">
                  <span className="action-icon">📖</span>
                  <span className="action-text">Browse Books</span>
                </a>
                <button className="action-button">
                  <span className="action-icon">🎨</span>
                  <span className="action-text">Customize Theme</span>
                </button>
                <button className="action-button">
                  <span className="action-icon">📱</span>
                  <span className="action-text">Export Library</span>
                </button>
                <button className="action-button">
                  <span className="action-icon">🔔</span>
                  <span className="action-text">Notifications</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>

      {/* Footer */}
      <footer className="account-footer">
        <div className="footer-content">
          <span className="footer-text">© 2024 Serenity Library • Made with 💖 for book lovers</span>
          <div className="footer-icons">
            <span>🌸</span>
            <span>💕</span>
            <span>📚</span>
            <span>✨</span>
          </div>
        </div>
      </footer>
    </div>
  )
}
