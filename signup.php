<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cherub Library</title>
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
                <a href="login.php" class="nav-link">🔑 Login</a>
                <a href="signup.php" class="nav-link active">✨ Sign Up</a>
            </nav>
        </header>

        <main class="main-content">
            <div class="signup-container">
                <div class="signup-header">
                    <h2>Join Our Library! 🌸</h2>
                    <p>Create your account to start your reading journey</p>
                </div>

                <form class="signup-form" onsubmit="handleSignup(event)">
                    <div class="form-group">
                        <label for="name">👤 Full Name</label>
                        <input type="text" id="name" name="name" required placeholder="Your Name">
                    </div>

                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="password">🔒 Password</label>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">🔒 Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="signup-btn">
                        <span>Create Account ✨</span>
                    </button>
                </form>

                <div class="signup-footer">
                    <p>Already have an account? <a href="login.php" class="login-link">Login here! 🔑</a></p>
                </div>
            </div>
        </main>
    </div>

    <script>
    async function handleSignup(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const name = formData.get('name');
        const email = formData.get('email');
        const password = formData.get('password');
        const confirmPassword = formData.get('confirmPassword');
        
        if (password !== confirmPassword) {
            alert('Passwords do not match! 🚫');
            return;
        }
        
        try {
            const response = await fetch('api/auth.php?action=register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name, email, password })
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Welcome to Cherub Library! 🌸');
                window.location.href = 'books.php';
            } else {
                alert('Signup failed: ' + data.message);
            }
        } catch (error) {
            console.error('Signup error:', error);
            alert('Signup failed. Please try again.');
        }
    }
    </script>
</body>
</html>
