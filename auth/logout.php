<?php
require_once __DIR__ . '/../shared/auth.php';

$basePath = '..';

logoutUser();
setFlash('success', 'You have been logged out.');
redirectTo($basePath . '/index.php');
