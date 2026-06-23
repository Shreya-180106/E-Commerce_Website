<?php
include 'includes/db.php';
include 'includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
                exit;
            } else {
                $message = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<div class="form-container">
    <h2>Register</h2>

    <?php if (!empty($message)) { ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
        <button type="submit" class="btn">Register</button>
    </form>

    <p class="form-link">Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>