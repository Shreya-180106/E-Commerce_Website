<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db.php';
include 'includes/header.php';

$message = "";

$name_value = "";
$email_value = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_value = trim($_POST['name'] ?? '');
    $email_value = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $name = mysqli_real_escape_string($conn, $name_value);
    $email = mysqli_real_escape_string($conn, $email_value);

    if ($name_value === '' || $email_value === '' || $password === '' || $confirm_password === '') {
        $message = "All fields are required.";
    } elseif (!filter_var($email_value, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
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

<section class="auth-page auth-register-page">
    <div class="container">
        <div class="auth-layout">
            <!-- LEFT SIDE -->
            <div class="auth-showcase">
                <span class="badge">Join ShopEase</span>
                <h1>Create your account and start shopping in style</h1>
                <p>
                    Register with ShopEase to explore curated products, manage your orders,
                    save time during checkout, and enjoy a modern pastel shopping experience
                    across fashion, electronics, beauty, and lifestyle essentials.
                </p>

                <div class="auth-feature-list">
                    <div class="auth-feature-item">
                        <i class="fa-solid fa-user-plus"></i>
                        <div>
                            <h4>Create Your Shopping Account</h4>
                            <p>Sign up in seconds and unlock a smooth shopping experience.</p>
                        </div>
                    </div>

                    <div class="auth-feature-item">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <div>
                            <h4>Save Cart & Checkout Faster</h4>
                            <p>Browse products, add items, and complete purchases with ease.</p>
                        </div>
                    </div>

                    <div class="auth-feature-item">
                        <i class="fa-solid fa-star"></i>
                        <div>
                            <h4>Access Premium Collections</h4>
                            <p>Stay connected with trending products, offers, and fresh arrivals.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="auth-card">
                <div class="auth-card-top">
                    <span class="auth-mini-badge">Create Account</span>
                    <h2>Register on ShopEase</h2>
                    <p>Fill in your details below to create your account and begin shopping.</p>
                </div>

                <?php if (!empty($message)) { ?>
                    <div class="auth-alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php } ?>

                <form method="POST" class="auth-form">
                    <div class="auth-form-group">
                        <label>Full Name</label>
                        <div class="auth-input-wrap">
                            <i class="fa-regular fa-user"></i>
                            <input
                                type="text"
                                name="name"
                                placeholder="Enter your full name"
                                value="<?php echo htmlspecialchars($name_value); ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="auth-form-group">
                        <label>Email Address</label>
                        <div class="auth-input-wrap">
                            <i class="fa-regular fa-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your email"
                                value="<?php echo htmlspecialchars($email_value); ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="auth-form-group">
                        <label>Password</label>
                        <div class="auth-input-wrap">
                            <i class="fa-solid fa-lock"></i>
                            <input
                                type="password"
                                name="password"
                                placeholder="Enter password"
                                required
                            >
                        </div>
                    </div>

                    <div class="auth-form-group">
                        <label>Confirm Password</label>
                        <div class="auth-input-wrap">
                            <i class="fa-solid fa-lock"></i>
                            <input
                                type="password"
                                name="confirm_password"
                                placeholder="Confirm password"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn auth-submit-btn">Create Account</button>
                </form>

                <div class="auth-bottom-text">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>