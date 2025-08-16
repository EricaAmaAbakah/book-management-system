<?php 
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT COUNT(*) as book_count FROM books WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$bookStats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $stmt = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->execute([$name, $_SESSION['user_id']]);
        $_SESSION['user_name'] = $name;
        $user['name'] = $name;
        $success_message = "Profile updated successfully! ✨";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Cherub Library</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/account.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link">📚 Books</a>
                <a href="account.php" class="nav-link active">👤 Account</a>
                <a href="logout.php" class="nav-link">🚪 Logout</a>
            </nav>
        </header>

        <main class="main-content">
            <div class="account-container">
                <div class="account-header">
                    <h2>My Account 👤</h2>
                    <p>Manage your kawaii profile ♡</p>
                </div>

                <?php if (isset($success_message)): ?>
                    <div class="success-message"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <div class="profile-section">
                    <!-- Profile Picture -->
                    <div class="profile-picture-section">
                        <div class="profile-picture-container">
                            <img id="profileImage" src="<?php echo $user['profile_image'] ?? 'images/cute-anime-girl-avatar.png'; ?>" alt="Profile Picture" class="profile-picture">
                            <div class="profile-picture-overlay">
                                <label for="profile-upload" class="upload-button">
                                    📷<span class="upload-text">Change</span>
                                </label>
                                <input id="profile-upload" type="file" accept="image/*" class="file-input">
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

                        <div id="username-display" class="username-display">
                            <span id="username-text" class="username-text"><?php echo htmlspecialchars($user['name']); ?></span>
                            <button id="edit-button" class="edit-button">✏️ Edit</button>
                        </div>

                        <form id="username-edit" class="username-edit" style="display: none;" method="POST">
                            <input id="username-input" type="text" name="name" class="username-input" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter your kawaii username...">
                            <div class="edit-buttons">
                                <button type="submit" name="update_profile" class="save-button">💾 Save</button>
                                <button type="button" id="cancel-button" class="cancel-button">❌ Cancel</button>
                            </div>
                        </form>
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
                                <div class="stat-number"><?php echo $bookStats['book_count']; ?></div>
                                <div class="stat-label">Books Saved</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">⭐</div>
                                <div class="stat-number">0</div>
                                <div class="stat-label">Reviews</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">🎯</div>
                                <div class="stat-number">0</div>
                                <div class="stat-label">Favorites</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">🏆</div>
                                <div class="stat-number">1</div>
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
                            <a href="book-management.php" class="action-button">
                                <span class="action-icon">➕</span>
                                <span class="action-text">Add Books</span>
                            </a>
                            <button class="action-button" onclick="showNotification('Export feature coming soon! 📱')">
                                <span class="action-icon">📱</span>
                                <span class="action-text">Export Library</span>
                            </button>
                            <a href="logout.php" class="action-button logout-action">
                                <span class="action-icon">🚪</span>
                                <span class="action-text">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Notification Toast -->
    <div id="notification" class="notification"></div>

    <script>
    // Username editing functionality
    document.getElementById('edit-button').addEventListener('click', function() {
        document.getElementById('username-display').style.display = 'none';
        document.getElementById('username-edit').style.display = 'block';
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('username-display').style.display = 'block';
        document.getElementById('username-edit').style.display = 'none';
    });

    // Profile picture upload
    document.getElementById('profile-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
                showNotification('Profile picture updated! ✨');
            };
            reader.readAsDataURL(file);
        }
    });

    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
    </script>
</body>
</html>
