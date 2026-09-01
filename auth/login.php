<?php
require_once __DIR__ . '/../shared/auth.php';

$basePath   = '..';
$pageTitle  = 'Login - SHOP.CO';
$redirectTo = $_GET['redirect'] ?? ($basePath . '/pages/profile.php');

if (isLoggedIn()) {
    redirectTo(authRedirectPath(currentUser(), $basePath));
}

$errors = [];
$old    = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $email    = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $old['email'] = $email;

        if ($email === '' || $password === '') {
            $errors[] = 'Please enter your email and password.';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = 'Incorrect email or password.';
            } else {
                loginUser($user);
                setFlash('success', 'Welcome back, ' . $user['full_name'] . '!');
                redirectTo($_POST['redirect'] !== '' ? $_POST['redirect'] : authRedirectPath($user, $basePath));
            }
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
            <h1 class="auth-title">Login</h1>
            <p class="auth-subtitle">Welcome back! Enter your details below.</p>

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
              <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirectTo) ?>">

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus
                       value="<?= htmlspecialchars($old['email']) ?>">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-dark auth-submit">Login</button>
            </form>

            <p class="auth-switch">
              Don't have an account?
              <a href="<?= htmlspecialchars($basePath) ?>/auth/signup.php">Sign up</a>
            </p>
          </div>
        </div>
      </section>
    </main>

    <?php require __DIR__ . '/../shared/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
