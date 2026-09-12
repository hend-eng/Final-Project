<?php
require_once __DIR__ . '/../shared/auth.php';

$basePath  = '..';
$pageTitle = 'My Profile - SHOP.CO';

requireLogin($basePath);
$user = currentUser();

$errors  = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $formType = $_POST['form_type'] ?? '';

        // --- Update name / email -------------------------------------------------
        if ($formType === 'details') {
            $name  = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if ($name === '' || mb_strlen($name) < 2) {
                $errors[] = 'Please enter your full name.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }

            if (!$errors) {
                $check = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
                $check->execute([$email, $user['id']]);
                if ($check->fetch()) {
                    $errors[] = 'That email is already used by another account.';
                }
            }

            if (!$errors) {
                $stmt = $pdo->prepare('UPDATE users SET full_name = ?, email = ? WHERE id = ?');
                $stmt->execute([$name, $email, $user['id']]);
                $success = 'Your details have been updated.';
                $user = currentUser(); 
                $user = ['id' => $user['id'], 'full_name' => $name, 'email' => $email, 'role' => $user['role'], 'created_at' => $user['created_at']];
            }
        }

        // --- Change password -------------------------------------------------
        if ($formType === 'password') {
            $current = (string)($_POST['current_password'] ?? '');
            $newPass = (string)($_POST['new_password'] ?? '');
            $confirm = (string)($_POST['confirm_password'] ?? '');

            $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
            $stmt->execute([$user['id']]);
            $hash = $stmt->fetchColumn();

            if (!password_verify($current, $hash)) {
                $errors[] = 'Current password is incorrect.';
            } elseif (mb_strlen($newPass) < 8) {
                $errors[] = 'New password must be at least 8 characters.';
            } elseif ($newPass !== $confirm) {
                $errors[] = 'New passwords do not match.';
            } else {
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $stmt->execute([password_hash($newPass, PASSWORD_DEFAULT), $user['id']]);
                $success = 'Your password has been changed.';
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
      <section class="profile-section">
        <div class="container">
          <h1 class="section-title profile-heading">MY PROFILE</h1>

          <?php if ($flash = getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>">
              <?= htmlspecialchars($flash['message']) ?>
            </div>
          <?php endif; ?>

          <?php if ($errors): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>

          <div class="row g-4">
            <div class="col-12 col-lg-4">
              <div class="profile-card profile-summary">
                <div class="profile-avatar"><?= htmlspecialchars(mb_strtoupper(mb_substr($user['full_name'], 0, 1))) ?></div>
                <h2><?= htmlspecialchars($user['full_name']) ?></h2>
                <p class="profile-email"><?= htmlspecialchars($user['email']) ?></p>
                <span class="profile-role-badge profile-role-<?= htmlspecialchars($user['role']) ?>">
                  <?= $user['role'] === 'admin' ? 'Administrator' : 'Customer' ?>
                </span>

                <?php if ($user['role'] === 'admin'): ?>
                  <a href="<?= htmlspecialchars($basePath) ?>/dasboard/categories/index.php"
   class="btn btn-dark w-100 mt-3">
    Go to Dashboard
</a>
                <?php endif; ?>

                <a href="<?= htmlspecialchars($basePath) ?>/auth/logout.php" class="btn btn-light w-100 mt-2">Logout</a>
              </div>
            </div>

            <div class="col-12 col-lg-8">
              <div class="profile-card">
                <h3 class="profile-card-title">Account Details</h3>
                <form method="post" novalidate>
                  <?= csrfField() ?>
                  <input type="hidden" name="form_type" value="details">

                  <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="full_name" class="form-control" required
                           value="<?= htmlspecialchars($user['full_name']) ?>">
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required
                           value="<?= htmlspecialchars($user['email']) ?>">
                  </div>

                  <button type="submit" class="btn btn-dark">Save Changes</button>
                </form>
              </div>

              <div class="profile-card">
                <h3 class="profile-card-title">Change Password</h3>
                <form method="post" novalidate>
                  <?= csrfField() ?>
                  <input type="hidden" name="form_type" value="password">

                  <div class="form-group">
                    <label for="current_password">Current password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label for="new_password">New password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required minlength="8">
                  </div>

                  <div class="form-group">
                    <label for="confirm_password">Confirm new password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="8">
                  </div>

                  <button type="submit" class="btn btn-dark">Update Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php require __DIR__ . '/../shared/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
