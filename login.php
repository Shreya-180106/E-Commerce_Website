<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db.php';
include 'includes/header.php';

$message = "";
$email_value = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_value = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $email = mysqli_real_escape_string($conn, $email_value);

    if ($email_value === '' || $password === '') {
        $message = "All fields are required.";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
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

<section class="auth-page auth-login-page">
    <div class="container">
        <div class="auth-layout">
            <!-- LEFT SIDE -->
            <div class="auth-showcase">
                <span class="badge">Welcome Back</span>
                <h1>Login to continue your shopping journey</h1>
                <p>
                    Access your ShopEase account to manage your cart, track orders,
                    and enjoy a smooth pastel shopping experience across fashion,
                    electronics, beauty, and lifestyle essentials.
                </p>

                <div class="auth-feature-list">
                    <div class="auth-feature-item">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <div>
                            <h4>Quick Shopping Access</h4>
                            <p>View products, manage your cart, and continue checkout seamlessly.</p>
                        </div>
                    </div>

                    <div class="auth-feature-item">
                        <i class="fa-solid fa-shield-heart"></i>
                        <div>
                            <h4>Secure Account Experience</h4>
                            <p>Your login flow is protected for a safer shopping experience.</p>
                        </div>
                    </div>

                    <div class="auth-feature-item">
                        <i class="fa-solid fa-gift"></i>
                        <div>
                            <h4>Exclusive Offers & Orders</h4>
                            <p>Stay updated with your purchases and special product collections.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="auth-card">
                <div class="auth-card-top">
                    <span class="auth-mini-badge">Sign In</span>
                    <h2>Login to ShopEase</h2>
                    <p>Enter your email and password to access your account.</p>
                </div>

                <?php if (!empty($message)) { ?>
                    <div class="auth-alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php } ?>

                <form method="POST" class="auth-form">
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

                    <button type="submit" class="btn auth-submit-btn">Login</button>
                </form>

                <div class="auth-bottom-text">
                    <p>Don’t have an account? <a href="register.php">Create one here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>