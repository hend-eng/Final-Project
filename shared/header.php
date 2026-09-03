<?php

require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'SHOP.CO';

$authUser = currentUser();

$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

$siteRoot = preg_replace(
    '#/(pages|auth|dasboard|shared)$#',
    '',
    $scriptDir
);

if ($siteRoot === '/') {
    $siteRoot = '';
}

?>

<div class="promo-bar" id="promoBar">

    <div class="promo-content">

        <span>
            Sign up and get 20% off your first order
        </span>

        <a href="<?= $siteRoot ?>/auth/signup.php">
            Sign Up Now
        </a>

    </div>

    <button
        type="button"
        class="promo-close"
        id="promoClose"
        aria-label="Close promotion"
        onclick="document.getElementById('promoBar').style.display='none';"
    >
        ×
    </button>

</div>

<header class="site-header">

    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>

            <a
                href="<?= $siteRoot ?>/index.php"
                class="logo"
            >
                SHOP.CO
            </a>

            <div
                class="collapse navbar-collapse"
                id="mainNavbar"
            >

                <ul class="navbar-nav nav-links">

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/index.php"
                        >
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/products.php"
                        >
                            Shop
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/products.php?tag=sale"
                        >
                            On Sale
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/products.php?tag=new"
                        >
                            New Arrivals
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/brands.php"
                        >
                            Brands
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/about.php"
                        >
                            About
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/team.php"
                        >
                            Team
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= $siteRoot ?>/pages/contact.php"
                        >
                            Contact
                        </a>
                    </li>

                </ul>

                <form
                    action="<?= $siteRoot ?>/pages/products.php"
                    method="get"
                    class="search-box"
                >

                    <i
                        class="bi bi-search search-icon"
                        aria-hidden="true"
                    ></i>

                    <input
                        type="search"
                        name="search"
                        class="search-input"
                        placeholder="Search for products..."
                        aria-label="Search for products"
                    >

                </form>

                <div class="header-icons">

                    <?php if ($authUser): ?>

                        <a
                            href="<?= $siteRoot ?>/pages/profile.php"
                            class="icon-button"
                            title="Profile"
                            aria-label="Profile"
                        >
                            <i class="bi bi-person"></i>
                        </a>

                        <?php if (($authUser['role'] ?? '') === 'admin'): ?>

                            <a
                                href="<?= $siteRoot ?>/dasboard/index.php"
                                class="icon-button"
                                title="Dashboard"
                                aria-label="Dashboard"
                            >
                                <i class="bi bi-speedometer2"></i>
                            </a>

                        <?php else: ?>

                            <a
                                href="<?= $siteRoot ?>/pages/orders.php"
                                class="icon-button"
                                title="My Orders"
                                aria-label="My Orders"
                            >
                                <i class="bi bi-bag"></i>
                            </a>

                        <?php endif; ?>

                        <a
                            href="<?= $siteRoot ?>/auth/logout.php"
                            class="icon-button"
                            title="Logout"
                            aria-label="Logout"
                        >
                            <i class="bi bi-box-arrow-right"></i>
                        </a>

                    <?php else: ?>

                        <a
                            href="<?= $siteRoot ?>/auth/login.php"
                            class="icon-button"
                            title="Login"
                            aria-label="Login"
                        >
                            <i class="bi bi-person"></i>
                        </a>

                    <?php endif; ?>

                    <a
                        href="<?= $siteRoot ?>/pages/cart.php"
                        class="icon-button"
                        title="Shopping Cart"
                        aria-label="Shopping Cart"
                    >
                        <i class="bi bi-cart3"></i>
                    </a>

                </div>

            </div>

        </div>

    </nav>

</header>