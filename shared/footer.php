<?php

$projectPath = realpath(__DIR__ . '/..');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');

$siteRoot = '';

if ($projectPath && $documentRoot) {

    $projectPath = str_replace('\\', '/', $projectPath);
    $documentRoot = str_replace('\\', '/', $documentRoot);

    if (strpos($projectPath, $documentRoot) === 0) {
        $siteRoot = substr(
            $projectPath,
            strlen($documentRoot)
        );
    }
}

$siteRoot = rtrim($siteRoot, '/');

?>

<footer class="site-footer">

    <div class="container">

        <div class="footer-main">

            <div class="footer-brand">

                <a
                    href="<?= $siteRoot ?>/index.php"
                    class="footer-logo"
                >
                    SHOP.CO
                </a>

                <p>
                    We have clothes that suit your style
                    and which you're proud to wear.
                </p>

                <div class="footer-socials">

                    <a
                        href="https://x.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="X"
                        class="footer-social"
                    >
                        <i class="bi bi-twitter-x"></i>
                    </a>

                    <a
                        href="https://www.facebook.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Facebook"
                        class="footer-social"
                    >
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a
                        href="https://www.instagram.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Instagram"
                        class="footer-social"
                    >
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="GitHub"
                        class="footer-social"
                    >
                        <i class="bi bi-github"></i>
                    </a>

                </div>

            </div>


            <div class="footer-column">

                <h3>
                    SHOP
                </h3>

                <ul>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/products.php">
                            All Products
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/products.php?tag=new">
                            New Arrivals
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/products.php?tag=sale">
                            On Sale
                        </a>
                    </li>

                </ul>

            </div>


            <div class="footer-column">

                <h3>
                    COMPANY
                </h3>

                <ul>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/about.php">
                            About Us
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/team.php">
                            Our Team
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/contact.php">
                            Contact Us
                        </a>
                    </li>

                </ul>

            </div>


            <div class="footer-column">

                <h3>
                    ACCOUNT
                </h3>

                <ul>

                    <li>
                        <a href="<?= $siteRoot ?>/auth/login.php">
                            Login
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/profile.php">
                            My Profile
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/orders.php">
                            My Orders
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/cart.php">
                            Cart
                        </a>
                    </li>

                </ul>

            </div>


            <div class="footer-column">

                <h3>
                    HELP
                </h3>

                <ul>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/contact.php">
                            Customer Support
                        </a>
                    </li>

                    <li>
                        <a href="<?= $siteRoot ?>/pages/contact.php#contactForm">
                            Returns & Exchanges
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>


    <div class="footer-bottom">

        <div class="container">

            <p>
                SHOP.CO © 2026. All Rights Reserved.
            </p>

        </div>

    </div>

</footer>