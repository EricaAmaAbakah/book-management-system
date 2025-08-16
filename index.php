<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Magical Library - Cherub Library</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/library.css">
    <link rel="stylesheet" href="books/books.css">
</head>
<body>
    <div class="library-page-container">
        <header class="library-header-nav">
            <div class="library-logo">
                <div class="logo-icon">🌸</div>
                <div class="logo-text">
                    <h1>Cherub Library</h1>
                    <p>Save books you love ♡</p>
                </div>
            </div>
            <nav class="library-nav">
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link">📚 Books</a>
                <?php if ($isLoggedIn): ?>
                    <a href="account.php" class="nav-link">👤 Account<?php if ($userName) echo " (" . htmlspecialchars($userName) . ")"; ?></a>
                    <a href="logout.php" class="nav-link">🚪 Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">🔑 Login</a>
                    <a href="signup.php" class="nav-link">✨ Sign Up</a>
                <?php endif; ?>
            </nav>
        </header>

        <div class="library-hero">
            <div class="floating-decorations">
                <span class="float-icon">🎀</span>
                <span class="float-icon">💖</span>
                <span class="float-icon">🌟</span>
                <span class="float-icon">🦋</span>
                <span class="float-icon">🌸</span>
            </div>
            <h1 class="library-main-title">Your Magical Library ✨</h1>
            <p class="library-subtitle">Discover wonderful stories in your kawaii collection</p>
            <?php if ($isLoggedIn): ?>
            <div id="floatToBooks" class="float-to-books-cute" onclick="window.location.href='books.php'">
                <span class="float-to-books-text">🌸 Tap here to access your books! 📚</span>
            </div>
            <?php endif; ?>
        </div>
        <!-- ...existing content... -->
    </div>
    <style>
    .float-to-books-cute {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2.5rem auto 0 auto;
        background: linear-gradient(135deg, #fce7f3 0%, #fbc2eb 100%);
        color: #a21caf;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 2rem;
        box-shadow: 0 8px 32px rgba(255, 107, 157, 0.18);
        padding: 1.2rem 2.5rem;
        cursor: pointer;
        z-index: 100;
        animation: floatyPop 1s cubic-bezier(.68,-0.55,.27,1.55);
        border: 2px solid #f9a8d4;
        transition: transform 0.2s, box-shadow 0.2s;
        max-width: 400px;
    }
    .float-to-books-cute:hover {
        transform: scale(1.05);
        box-shadow: 0 16px 48px rgba(255, 107, 157, 0.25);
        background: linear-gradient(135deg, #fbc2eb 0%, #fce7f3 100%);
    }
    @keyframes floatyPop {
        0% { transform: translateY(40px) scale(0.95); opacity: 0; }
        60% { transform: translateY(-10px) scale(1.03); opacity: 1; }
        100% { transform: translateY(0) scale(1); opacity: 1; }
    }
    </style>
</body>
</html>
