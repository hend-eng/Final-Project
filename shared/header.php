<?php

require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'SHOP.CO';

$authUser = currentUser();

$scriptPath = str_replace(
    '\\',
    '/',
    $_SERVER['SCRIPT_NAME'] ?? ''
);

$scriptDirectory = dirname($scriptPath);

$siteRoot = preg_replace(
    '#/(pages|auth|dasboard|shared)$#',
    '',
    $scriptDirectory
);

if ($siteRoot === '.' || $siteRoot === '/') {
    $siteRoot = '';
}

$siteRoot = rtrim($siteRoot, '/');

?>

<div class="promo-bar" id="promoBar">

    <div class="promo-content">

        <span>
            Sign up and get 20% off your first order
        </span>

        <a
            href="<?= htmlspecialchars($siteRoot . '/auth/signup.php', ENT_QUOTES, 'UTF-8') ?>"
        >
            Sign Up Now
        </a>

    </div>

    <button
        type="button"
        class="promo-close"
        id="promoClose"
        aria-label="Close promotion"
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
                href="<?= htmlspecialchars($siteRoot . '/index.php', ENT_QUOTES, 'UTF-8') ?>"
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
                            href="<?= htmlspecialchars($siteRoot . '/index.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            Home
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/products.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            Shop
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/products.php?tag=sale', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            On Sale
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/products.php?tag=new', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            New Arrivals
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/brands.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            Brands
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/about.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            About
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/team.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            Team
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= htmlspecialchars($siteRoot . '/pages/contact.php', ENT_QUOTES, 'UTF-8') ?>"
                        >
                            Contact
                        </a>
                    </li>

                </ul>


                <form
                    action="<?= htmlspecialchars($siteRoot . '/pages/products.php', ENT_QUOTES, 'UTF-8') ?>"
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
                            href="<?= htmlspecialchars($siteRoot . '/pages/profile.php', ENT_QUOTES, 'UTF-8') ?>"
                            class="icon-button"
                            title="Profile"
                            aria-label="Profile"
                        >
                            <i class="bi bi-person"></i>
                        </a>


                        <?php if (($authUser['role'] ?? '') === 'admin'): ?>

                            <a
                                href="<?= htmlspecialchars($siteRoot . '/dasboard/index.php', ENT_QUOTES, 'UTF-8') ?>"
                                class="icon-button"
                                title="Dashboard"
                                aria-label="Dashboard"
                            >
                                <i class="bi bi-speedometer2"></i>
                            </a>

                        <?php else: ?>

                            <a
                                href="<?= htmlspecialchars($siteRoot . '/pages/orders.php', ENT_QUOTES, 'UTF-8') ?>"
                                class="icon-button"
                                title="My Orders"
                                aria-label="My Orders"
                            >
                                <i class="bi bi-bag"></i>
                            </a>

                        <?php endif; ?>


                        <a
                            href="<?= htmlspecialchars($siteRoot . '/auth/logout.php', ENT_QUOTES, 'UTF-8') ?>"
                            class="icon-button"
                            title="Logout"
                            aria-label="Logout"
                        >
                            <i class="bi bi-box-arrow-right"></i>
                        </a>


                    <?php else: ?>

                        <a
                            href="<?= htmlspecialchars($siteRoot . '/auth/login.php', ENT_QUOTES, 'UTF-8') ?>"
                            class="icon-button"
                            title="Login"
                            aria-label="Login"
                        >
                            <i class="bi bi-person"></i>
                        </a>

                    <?php endif; ?>


                    <a
                        href="<?= htmlspecialchars($siteRoot . '/pages/cart.php', ENT_QUOTES, 'UTF-8') ?>"
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


<script>

document.addEventListener('DOMContentLoaded', function () {

    const promoBar = document.getElementById('promoBar');
    const promoClose = document.getElementById('promoClose');

    if (promoBar && promoClose) {

        promoClose.addEventListener('click', function () {
            promoBar.style.display = 'none';
        });

    }

});

</script>