<?php
session_start();
// Only allow access if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Serenity Library</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Character Mascot -->
        <div class="mascot-container">
            <div class="mascot">
                <div class="mascot-body admin-mascot">
                    <div class="mascot-face">
                        <div class="mascot-eyes">
                            <div class="eye left-eye">
                                <div class="pupil"></div>
                            </div>
                            <div class="eye right-eye">
                                <div class="pupil"></div>
                            </div>
                        </div>
                        <div class="mascot-blush left-blush"></div>
                        <div class="mascot-blush right-blush"></div>
                        <div class="mascot-mouth"></div>
                    </div>
                    <div class="mascot-ears">
                        <div class="ear left-ear"></div>
                        <div class="ear right-ear"></div>
                    </div>
                    <div class="admin-crown">👑</div>
                </div>
                <div class="mascot-arms">
                    <div class="arm left-arm"></div>
                    <div class="arm right-arm"></div>
                </div>
                <div class="mascot-book">📊</div>
                <div class="mascot-speech-bubble">
                    <span>Managing! ♡</span>
                </div>
            </div>
        </div>

        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link active">🏠 Home</a>
                <a href="#books" class="nav-link">📚 Books</a>
                <a href="login.php" class="nav-link">🔑 Login</a>
                <a href="signup.php" class="nav-link">✨ Sign Up</a>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Section -->
            <section class="hero">
                <div class="hero-content">
                    <h2 class="hero-title">
                        Library
                        <span class="highlight">Management</span> 👑
                    </h2>
                    <div class="admin-stats">
                        <div class="admin-stat-item">
                            <span class="admin-stat-icon">👥</span>
                            <div>
                                <strong>1,234</strong>
                                <p>Active Users</p>
                            </div>
                        </div>
                        <div class="admin-stat-item">
                            <span class="admin-stat-icon">📚</span>
                            <div>
                                <strong>50,678</strong>
                                <p>Total Books</p>
                            </div>
                        </div>
                        <div class="admin-stat-item">
                            <span class="admin-stat-icon">📈</span>
                            <div>
                                <strong>89%</strong>
                                <p>Satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Admin Dashboard Grid -->
            <section class="content-grid">
                <!-- Recent Activity -->
                <div class="card">
                    <h3>📋 Recent Activity</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <span class="activity-icon">📚</span>
                            <div class="activity-info">
                                <strong>New book added</strong>
                                <p>"Cherry Blossom Dreams" by Yuki Sato</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <span class="activity-icon">👤</span>
                            <div class="activity-info">
                                <strong>New user registered</strong>
                                <p>Sakura Tanaka joined the library</p>
                                <span class="activity-time">4 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <span class="activity-icon">⭐</span>
                            <div class="activity-info">
                                <strong>High rating received</strong>
                                <p>"Ocean Tales" got 5 stars</p>
                                <span class="activity-time">6 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <h3>⚡ Quick Actions</h3>
                    <div class="quick-actions">
                        <button class="action-btn add-book" onclick="document.getElementById('addBookModal').style.display='flex'">
                            <span class="action-icon">📚</span>
                            <span>Add New Book</span>
                        </button>
                        <button class="action-btn manage-users">
                            <span class="action-icon">👥</span>
                            <span>Manage Users</span>
                        </button>
                        <button class="action-btn view-reports">
                            <span class="action-icon">📊</span>
                            <span>View Reports</span>
                        </button>
                        <button class="action-btn send-notice">
                            <span class="action-icon">📢</span>
                            <span>Send Notice</span>
                        </button>
                    </div>
                </div>

                <!-- Popular Books -->
                <div class="card">
                    <h3>🔥 Most Popular Books</h3>
                    <div class="popular-books">
                        <div class="popular-book">
                            <div class="popular-rank">1</div>
                            <div class="popular-cover pink">💕</div>
                            <div class="popular-info">
                                <h4>Sweet Dreams</h4>
                                <p>1,234 reads this month</p>
                                <div class="popularity-bar">
                                    <div class="popularity-fill" style="width: 95%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="popular-book">
                            <div class="popular-rank">2</div>
                            <div class="popular-cover blue">💙</div>
                            <div class="popular-info">
                                <h4>Ocean Tales</h4>
                                <p>987 reads this month</p>
                                <div class="popularity-bar">
                                    <div class="popularity-fill" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="popular-book">
                            <div class="popular-rank">3</div>
                            <div class="popular-cover yellow">💛</div>
                            <div class="popular-info">
                                <h4>Sunny Days</h4>
                                <p>756 reads this month</p>
                                <div class="popularity-bar">
                                    <div class="popularity-fill" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="card">
                    <h3>⚙️ System Status</h3>
                    <div class="system-status">
                        <div class="status-item">
                            <span class="status-indicator online"></span>
                            <div class="status-info">
                                <strong>Database</strong>
                                <p>Online and healthy</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <span class="status-indicator online"></span>
                            <div class="status-info">
                                <strong>User Authentication</strong>
                                <p>All systems operational</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <span class="status-indicator warning"></span>
                            <div class="status-info">
                                <strong>Backup System</strong>
                                <p>Scheduled maintenance in 2 hours</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <span class="status-indicator online"></span>
                            <div class="status-info">
                                <strong>Search Engine</strong>
                                <p>Running smoothly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Add Book Modal -->
        <div id="addBookModal" class="book-form-overlay" style="display:none;">
            <div class="book-form-container">
                <div class="form-header">
                    <h3>Add New Book ✨</h3>
                    <button class="close-btn" onclick="document.getElementById('addBookModal').style.display='none'">✕</button>
                </div>
                <form class="book-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>📖 Book Title</label>
                            <input type="text" placeholder="Enter book title..." required />
                        </div>
                        <div class="form-group">
                            <label>✍️ Author</label>
                            <input type="text" placeholder="Enter author name..." required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📚 Genre</label>
                            <select>
                                <option>Romance</option>
                                <option>Fantasy</option>
                                <option>Adventure</option>
                                <option>Slice of Life</option>
                                <option>Mystery</option>
                                <option>Sci-Fi</option>
                                <option>Horror</option>
                                <option>Comedy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>📅 Year Published</label>
                            <input type="number" min="1000" max="2035" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>🖼️ Book Cover Image URL</label>
                        <input type="url" placeholder="https://example.com/book-cover.jpg" />
                    </div>
                    <div class="form-group">
                        <label>🔗 Book Link</label>
                        <input type="url" placeholder="https://example.com/read-book" required />
                    </div>
                    <div class="form-group">
                        <label>⭐ Rating (1-5)</label>
                        <input type="number" min="1" max="5" step="0.1" />
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="document.getElementById('addBookModal').style.display='none'">Cancel</button>
                        <button type="submit" class="submit-btn">Add Book ✨</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <span class="footer-text">© 2024 Serenity Library • Admin Panel 👑</span>
                <div class="footer-icons">
                    <span>👑</span>
                    <span>📊</span>
                    <span>💎</span>
                    <span>✨</span>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
