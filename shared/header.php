<?php
require_once __DIR__ . '/auth.php';

$basePath = $basePath ?? '.';
$pageTitle = $pageTitle ?? 'SHOP.CO';
$authUser = currentUser();
?>
<div class="promo-bar">
  <span>Sign up and get 20% off your first order</span>
  <a href="<?= htmlspecialchars($basePath) ?>/auth/signup.php">Sign Up Now</a>
</div>

<header class="site-header">
  <nav class="navbar">
    <div class="container-fluid">
      <a href="<?= htmlspecialchars($basePath) ?>/index.php" class="navbar-brand logo">SHOP.CO</a>

      <div class="navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav nav-links">
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($basePath) ?>/pages/products.php">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($basePath) ?>/pages/products.php?tag=sale">On Sale</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($basePath) ?>/pages/products.php?tag=new">New Arrivals</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($basePath) ?>/pages/products.php">Brands</a></li>
        </ul>
      </div>

      <form class="search-box d-none d-md-flex" action="<?= htmlspecialchars($basePath) ?>/pages/products.php" method="get">
        <i class="bi bi-search search-icon" aria-hidden="true"></i>
        <input type="search" name="search" class="search-input" placeholder="Search for products..." aria-label="Search for products">
      </form>

      <div class="header-icons">
        <?php if ($authUser): ?>
          <div class="dropdown account-dropdown">
            <button class="icon-button account-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account menu">
              <i class="bi bi-person-check"></i>
              <span class="account-name d-none d-md-inline"><?= htmlspecialchars($authUser['full_name']) ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end account-menu">
              <li><a class="dropdown-item" href="<?= htmlspecialchars($basePath) ?>/pages/profile.php"><i class="bi bi-person"></i> My Profile</a></li>
              <?php if ($authUser['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="<?= htmlspecialchars($basePath) ?>/dasboard/index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="<?= htmlspecialchars($basePath) ?>/pages/orders.php"><i class="bi bi-bag"></i> My Orders</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= htmlspecialchars($basePath) ?>/auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="<?= htmlspecialchars($basePath) ?>/auth/login.php" class="icon-button" aria-label="Account"><i class="bi bi-person"></i></a>
        <?php endif; ?>
        <a href="<?= htmlspecialchars($basePath) ?>/pages/cart.php" class="icon-button" aria-label="Shopping cart"><i class="bi bi-cart3"></i></a>
      </div>
    </div>
  </nav>
</header>
