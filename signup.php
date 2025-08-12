<?php
include "connection.php";

$created_account = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];
    $roll = $_POST["roll"];

    // Check if fullname already exists
    $check_sql = "SELECT fullname FROM student WHERE fullname = '$fullname'";
    $check_res = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_res) > 0) {
        echo "<script type='text/javascript'>alert('This username already exists. Please choose another.');</script>";
    } else {
        $sql = "INSERT INTO student (fullname, email, password, `confirm password`, roll) VALUES ('$fullname', '$email', '$password', '$confirm_password', '$roll')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script type='text/javascript'>alert('Registration successful'); window.location.href='login.php';</script>";
            $created_account = [
                'roll' => $roll,
                'fullname' => $fullname,
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ];
        } else {
            echo "<div style='color:red;text-align:center;'>Error: " . mysqli_error($conn) . "<br>SQL: $sql</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Kawaii Library 🌸</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
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
                <a href="signup.php" class="nav-link active">✨ Sign Up</a>
                    <!-- Admin Login link removed -->
            </nav>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <section class="hero">
                <div class="hero-content" style="background: rgba(255,255,255,0.85); border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(255,182,193,0.15); padding: 2rem; max-width: 400px; margin: 0 auto;">
                    <h2 class="hero-title" style="margin-bottom: 1rem;">Join Cherub Library! 💫</h2>
                    <form class="login-form" method="POST" action="">
                        <div class="input-group">
                            <label for="roll">🆔 Roll</label>
                            <select id="roll" name="roll" required>
                                <option value="">Select Roll</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="name">✨ Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="email">📧 Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="password">🔒 Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="input-group">
                            <label for="confirm-password">🔒 Confirm Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" required>
                        </div>
                        <button type="submit" class="btn btn-student">Create Account 🌸</button>
                    </form>
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <p style="color: #4682B4; font-weight: 500;">
                            Already have an account?
                            <a href="login.php" style="color: #FF1493; text-decoration: none; font-weight: 700;">Login here! 💖</a>
                        </p>
                        <p style="margin-top: 0.5rem;">
                            <a href="#" style="color: #4682B4; text-decoration: underline; font-weight: 600;">Forgot password?</a>
                        </p>
                    </div>
                </div>
                <!-- Display just created account info -->
                <?php if ($created_account): ?>
                <div style="margin:2rem auto; max-width:400px;">
                    <h3 style="text-align:center;">Your Account Information</h3>
                    <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; text-align:left;">
                        <tr style="background:#f8f8ff; font-weight:bold;">
                            <th>Roll</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Confirm Password</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($created_account['roll']); ?></td>
                            <td><?php echo htmlspecialchars($created_account['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($created_account['email']); ?></td>
                            <td><?php echo htmlspecialchars($created_account['password']); ?></td>
                            <td><?php echo htmlspecialchars($created_account['confirm_password']); ?></td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
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

    <!-- JS removed for pure HTML/CSS version -->
</body>
</html>
