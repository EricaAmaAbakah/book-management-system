<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serenity Library - Account</title>
  <link rel="stylesheet" href="./account.css">
</head>
<body>
  <div class="account-container">
    <!-- Header -->
    <header class="account-header">
      <div class="logo">
        <div class="logo-icon">🌸</div>
        <div class="logo-text">
          <h1>Serenity Library</h1>
          <p>Save books you love ♡</p>
        </div>
      </div>
      <nav class="nav">
        <a href="index.php" class="nav-link">🏠 Home</a>
        <a href="books.php" class="nav-link">📚 Books</a>
        <a href="account.php" class="nav-link active">👤 Account</a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="account-main">
      <div class="account-card">
        <div class="account-header-section">
          <h2 class="account-title">
            <span class="title-icon">👤</span>
            My Account
            <span class="sparkle">✨</span>
          </h2>
          <p class="account-subtitle">Manage your kawaii profile ♡</p>
        </div>

        <div class="profile-section">
          <!-- Profile Picture -->
          <div class="profile-picture-section">
            <div class="profile-picture-container">
              <img id="profileImage" src="/cute-anime-girl-avatar.png" alt="Profile Picture" class="profile-picture" />
              <div class="profile-picture-overlay">
                <label for="profile-upload" class="upload-button">
                  📷<span class="upload-text">Change</span>
                </label>
                <input id="profile-upload" type="file" accept="image/*" class="file-input" />
              </div>
            </div>
            <p class="profile-picture-hint">Click to upload a new kawaii picture! 🎀</p>
          </div>

          <!-- Username Section -->
          <div class="username-section">
            <label class="username-label">
              <span class="label-icon">🏷️</span>
              Username
            </label>
            <div id="usernameDisplay" class="username-display">
              <span id="usernameText" class="username-text">Kawaii Reader</span>
              <button id="editUsernameBtn" class="edit-button">✏️ Edit</button>
            </div>
            <div id="usernameEdit" class="username-edit" style="display:none;">
              <input type="text" id="usernameInput" class="username-input" placeholder="Enter your kawaii username..." />
              <div class="edit-buttons">
                <button id="saveUsernameBtn" class="save-button">💾 Save</button>
                <button id="cancelUsernameBtn" class="cancel-button">❌ Cancel</button>
              </div>
            </div>
          </div>

          <!-- Account Stats -->
          <div class="account-stats">
            <h3 class="stats-title">
              <span class="stats-icon">📊</span>
              Your Reading Stats
            </h3>
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-number">42</div>
                <div class="stat-label">Books Saved</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-number">38</div>
                <div class="stat-label">Reviews</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-number">15</div>
                <div class="stat-label">Favorites</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-number">7</div>
                <div class="stat-label">Achievements</div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="quick-actions">
            <h3 class="actions-title">
              <span class="actions-icon">⚡</span>
              Quick Actions
            </h3>
            <div class="actions-grid">
              <a href="books.php" class="action-button">
                <span class="action-icon">📖</span>
                <span class="action-text">Browse Books</span>
              </a>
              <button class="action-button">
                <span class="action-icon">🎨</span>
                <span class="action-text">Customize Theme</span>
              </button>
              <button class="action-button">
                <span class="action-icon">📱</span>
                <span class="action-text">Export Library</span>
              </button>
              <button class="action-button">
                <span class="action-icon">🔔</span>
                <span class="action-text">Notifications</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="account-footer">
      <div class="footer-content">
        <span class="footer-text">© 2024 Serenity Library • Made with 💖 for book lovers</span>
        <div class="footer-icons">
          <span>🌸</span>
          <span>💕</span>
          <span>📚</span>
          <span>✨</span>
        </div>
      </div>
    </footer>
  </div>
  <script>
    // Profile image upload
    document.getElementById('profile-upload').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
    // Username edit
    const usernameDisplay = document.getElementById('usernameDisplay');
    const usernameEdit = document.getElementById('usernameEdit');
    const usernameText = document.getElementById('usernameText');
    const usernameInput = document.getElementById('usernameInput');
    document.getElementById('editUsernameBtn').onclick = function() {
      usernameEdit.style.display = '';
      usernameDisplay.style.display = 'none';
      usernameInput.value = usernameText.textContent;
    };
    document.getElementById('saveUsernameBtn').onclick = function() {
      usernameText.textContent = usernameInput.value || 'Kawaii Reader';
      usernameEdit.style.display = 'none';
      usernameDisplay.style.display = '';
    };
    document.getElementById('cancelUsernameBtn').onclick = function() {
      usernameEdit.style.display = 'none';
      usernameDisplay.style.display = '';
    };
  </script>
</body>
</html>
