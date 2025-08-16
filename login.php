<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cherub Library</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/main.css">
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
                <a href="login.php" class="nav-link active">🔑 Login</a>
                <a href="signup.php" class="nav-link">✨ Sign Up</a>
            </nav>
        </header>

        <main class="main-content">
            <div class="login-container">
                <div class="login-header">
                    <h2>Welcome Back! 🌸</h2>
                    <p>Login to access your magical library</p>
                </div>

                <form class="login-form" onsubmit="handleLogin(event)">
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="password">🔒 Password</label>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="login-btn">
                        <span>Login ✨</span>
                    </button>
                </form>

                <div class="login-footer">
                    <p>Don't have an account? <a href="signup.php" class="signup-link">Sign up here! 🌸</a></p>
                </div>
            </div>
        </main>
    </div>

    <script>
    async function handleLogin(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const email = formData.get('email');
        const password = formData.get('password');
        
        try {
            const response = await fetch('api/auth.php?action=login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Welcome back! 🌸');
                window.location.href = 'books.php';
            } else {
                alert('Login failed: ' + data.message);
            }
        } catch (error) {
            console.error('Login error:', error);
            alert('Login failed. Please try again.');
        }
    }
    </script>
</body>
</html>
