<?php
include 'includes/db.php';
include 'includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                echo "<script>alert('Login successful!'); window.location='index.php';</script>";
                exit;
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "No account found with this email.";
        }
    }
}
?>

<div class="form-container">
    <h2>Login</h2>

    <?php if (!empty($message)) { ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit" class="btn">Login</button>
    </form>

    <p class="form-link">Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include 'includes/footer.php'; ?>