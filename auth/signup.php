<?php
require_once __DIR__ . '/../shared/auth.php';

$basePath  = '..';
$pageTitle = 'Sign Up - SHOP.CO';

if (isLoggedIn()) {
    redirectTo(authRedirectPath(currentUser(), $basePath));
}

$errors = [];
$old    = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $confirm  = (string)($_POST['confirm_password'] ?? '');
        $old['name']  = $name;
        $old['email'] = $email;

        if ($name === '' || $email === '' || $password === '' || $confirm === '') {
            $errors[] = 'Please fill in all fields.';
        }
        if ($name !== '' && mb_strlen($name) < 2) {
            $errors[] = 'Please enter your full name.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($password !== '' && mb_strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        }
        if ($password !== '' && $password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }

        if (!$errors) {
            $check = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            $check->execute([$email]);
            if ($check->fetch()) {
                $errors[] = 'An account with that email already exists.';
            }
        }

        
        if (!$errors) {
            $stmt = $pdo->prepare(
                'INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                'customer',
            ]);

            $user = [
                'id'    => $pdo->lastInsertId(),
                'name'  => $name,
                'email' => $email,
                'role'  => 'customer',
            ];
            loginUser($user);
            setFlash('success', 'Welcome to SHOP.CO, ' . $name . '!');
            redirectTo(authRedirectPath($user, $basePath));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>/assets/css/style.css" />
  </head>

  <body>
    <?php require __DIR__ . '/../shared/header.php'; ?>

    <main>
      <section class="auth-section">
        <div class="container">
          <div class="auth-card">
            <h1 class="auth-title">Create an Account</h1>
            <p class="auth-subtitle">Sign up and get 20% off your first order.</p>

            <?php if ($errors): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <form method="post" novalidate>
              <?= csrfField() ?>

              <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" class="form-control" required autofocus
                       value="<?= htmlspecialchars($old['name']) ?>">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required
                       value="<?= htmlspecialchars($old['email']) ?>">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                <small class="form-hint">At least 8 characters.</small>
              </div>

              <div class="form-group">
                <label for="confirm_password">Confirm password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="8">
              </div>

              <button type="submit" class="btn btn-dark auth-submit">Create Account</button>
            </form>

            <p class="auth-switch">
              Already have an account?
              <a href="<?= htmlspecialchars($basePath) ?>/auth/login.php">Login</a>
            </p>
          </div>
        </div>
      </section>
    </main>

    <?php require __DIR__ . '/../shared/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
