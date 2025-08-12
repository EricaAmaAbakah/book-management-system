<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["student-login"])) {
    $fullname = $_POST["student-fullname"];
    $confirm_password = $_POST["student-password"];

    if (strlen($confirm_password) < 8) {
        echo "<script type='text/javascript'>alert('Password must be at least 8 characters long.');</script>";
    } else {
        $sql = "SELECT * FROM student WHERE fullname='$fullname' AND `confirm password`='$confirm_password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            echo "<script type='text/javascript'>alert('Login successful!'); window.location.href='books.php';</script>";
            exit;
        } else {
            echo "<script type='text/javascript'>alert('Fullname and password do not match.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cherub Library 🌸</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
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
                <a href="index.php" class="nav-link active">🏠 Home</a>
                <a href="#books" class="nav-link">📚 Books</a>
                <a href="login.php" class="nav-link">🔑 Login</a>
                <a href="signup.php" class="nav-link">✨ Sign Up</a>
            </nav>
        </header>

        <main class="main-content">
            <section class="hero">
                <div class="hero-content">
                    <div class="sanrio-decoration">
                        <span class="floating-icon">🎀</span>
                        <span class="floating-icon">💖</span>
                        <span class="floating-icon">🌟</span>
                    </div>
                    <div class="login-container">
                        <div class="login-header">
                            <h1>Welcome Back! 💖</h1>
                            <p>Sign in to your magical library</p>
                        </div>
                        <div id="login-options" class="login-options">
                            <a href="student-login.php" class="login-card student-card elegant-btn" style="font-size:2em;padding:30px 60px;">
                                <div class="card-icon">🎓</div>
                                <h3>Student Portal</h3>
                                <p>Access your reading collection</p>
                                <div class="card-arrow">→</div>
                            </a>
                        </div>
                        <div class="login-card-footer" style="text-align:center; margin-top:2rem;">
                            <div class="login-divider">
                                <span class="login-divider-text">New to our library?</span>
                            </div>
                            <a href="signup.php" class="login-link" style="color:#ff1493; font-weight:700; text-decoration:none;">Create an account 💫</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-star star-1">⭐</div>
            <div class="floating-star star-2">✨</div>
            <div class="floating-heart heart-1">💕</div>
            <div class="floating-heart heart-2">💖</div>
        </div>
    </div>

    <script>
        function showStudentLogin() {
            document.getElementById('login-options').classList.add('hidden');
            document.getElementById('student-form').classList.remove('hidden');
        }
        function hideLoginForms() {
            document.getElementById('login-options').classList.remove('hidden');
            document.getElementById('student-form').classList.add('hidden');
        }
        function handleStudentLogin(event) {
            event.preventDefault();
            window.location.href = 'student-dashboard.php';
        }

        // Floating elements follow cursor on hover
        document.querySelectorAll('.floating-star, .floating-heart').forEach(function(el) {
            el.addEventListener('mouseenter', function() {
                el.style.transition = 'transform 0.2s';
                el.style.transform = 'scale(1.5) rotate(10deg)';
            });
            el.addEventListener('mouseleave', function() {
                el.style.transform = '';
            });
        });

        document.addEventListener('mousemove', function(e) {
            document.querySelectorAll('.floating-star, .floating-heart').forEach(function(el) {
                var rect = el.getBoundingClientRect();
                var dx = e.clientX - (rect.left + rect.width/2);
                var dy = e.clientY - (rect.top + rect.height/2);
                var dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 100) {
                    el.style.transform = 'translate(' + dx/4 + 'px, ' + dy/4 + 'px) scale(1.2)';
                } else {
                    el.style.transform = '';
                }
            });
        });
    </script>
</body>
</html>
