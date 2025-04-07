<?php
require_once __DIR__ . '/../../config/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Book Management System</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <header class="auth-header">
            <h1>Register</h1>
        </header>
        
        <main class="auth-main">
            <section class="auth-form-section">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <form action="/controllers/auth_controller.php?action=register" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group password-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" required>
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">👁️</button>
                        </div>
                    </div>
                    
                    <div class="form-group password-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirm_password" name="confirm_password" required>
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">👁️</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-submit">Register</button>
                </form>
                
                <p class="register-link">Already have an account? <a href="/views/auth/login.php">Login here</a></p>
            </section>
        </main>
        
        <footer class="footer">
            <p>Book Management System © <?php echo date('Y'); ?></p>
        </footer>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const wrapper = this.parentElement;
                const passwordInput = wrapper.querySelector('input');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
            });
        });
    </script>
</body>
</html>
