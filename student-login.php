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
    <title>Student Login - Cherub Library</title>
    <link rel="stylesheet" href="student-login.css">
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
                <a href="index.php" class="nav-link">🏠 Home</a>
                <a href="books.php" class="nav-link">📚 Books</a>
                <a href="login.php" class="nav-link active">🔑 Login</a>
                <a href="signup.php" class="nav-link">✨ Sign Up</a>
            </nav>
        </header>
        <main class="main-content">
            <section class="hero">
                <div class="hero-content">
                    <div class="floating-card student-card">
                        <h2>🎓 Student Login</h2>
                        <form method="POST" action="student-login.php">
                            <div class="input-group">
                                <label for="student-fullname">✨ Full Name</label>
                                <input type="text" id="student-fullname" name="student-fullname" required placeholder="Enter your full name">
                            </div>
                            <div class="input-group">
                                <label for="student-password">🔒 Confirm Password</label>
                                <input type="password" id="student-password" name="student-password" required placeholder="Enter your password" minlength="8">
                            </div>
                            <button type="submit" name="student-login" class="btn btn-student">Sign In as Student 🌸</button>
                        </form>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                        <button class="back-btn" onclick="window.location.href='login.php'">← Back</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
