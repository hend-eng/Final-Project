<?php

require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function currentUser(): ?array
{
    global $pdo;

    static $user = null;
    static $loaded = false;

    if ($loaded) {
        return $user;
    }

    $loaded = true;

    if (empty($_SESSION['user_id'])) {
        return $user = null;
    }

    $stmt = $pdo->prepare(
        'SELECT id, full_name, email, role, created_at
         FROM users
         WHERE id = ?
         LIMIT 1'
    );

    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch();

    if (!$row) {
        // Session points at a user that no longer exists.
        unset($_SESSION['user_id']);

        return $user = null;
    }

    return $user = $row;
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

function isAdmin(): bool
{
    $user = currentUser();

    return $user !== null && $user['role'] === 'admin';
}

function loginUser(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
}

function logoutUser(): void
{
    $_SESSION = [];

    session_regenerate_id(true);
}

/**
 * Where a user should land right after logging in.
 */
function authRedirectPath(array $user, string $basePath): string
{
    if ($user['role'] === 'admin') {
        return $basePath . '/dasboard/index.php';
    }

    return $basePath . '/pages/profile.php';
}

function redirectTo(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Block access unless logged in.
 */
function requireLogin(string $basePath): void
{
    if (!isLoggedIn()) {
        $redirect = urlencode($_SERVER['REQUEST_URI'] ?? '');

        redirectTo(
            $basePath . '/auth/login.php?redirect=' . $redirect
        );
    }
}

/**
 * Block access unless logged in AND an admin.
 */
function requireAdmin(string $basePath): void
{
    requireLogin($basePath);

    if (!isAdmin()) {
        redirectTo($basePath . '/pages/profile.php');
    }
}

/* ----------------------------------------------------------------
 * CSRF protection
 * ----------------------------------------------------------------
 */

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(csrfToken()) .
        '">';
}

function csrfCheck(): bool
{
    return isset(
        $_POST['csrf_token'],
        $_SESSION['csrf_token']
    )
    && hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token']
    );
}

/* ----------------------------------------------------------------
 * One-time flash messages
 * ----------------------------------------------------------------
 */

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];

    unset($_SESSION['flash']);

    return $flash;
}