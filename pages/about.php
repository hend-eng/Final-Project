<?php

$pageTitle = 'About Us - SHOP.CO';

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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="<?= $siteRoot ?>/assets/css/style.css"
    >

</head>

<body>

<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="about-page">

    <section class="about-hero">

        <div class="container">

            <div class="about-breadcrumb">

                <a href="<?= $siteRoot ?>/index.php">
                    Home
                </a>

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

                <span>
                    About
                </span>

            </div>

            <div
                style="
                    position: relative;
                    min-height: 480px;
                    width: 100%;
                "
            >

                <div
                    style="
                        position: absolute;
                        left: 0;
                        top: 50%;
                        transform: translateY(-50%);
                        width: 55%;
                        text-align: left;
                        z-index: 2;
                    "
                >

                    <span class="about-label">
                        ABOUT SHOP.CO
                    </span>

                    <h1>
                        Style that speaks
                        <br>
                        for you.
                    </h1>

                    <p>
                        SHOP.CO is a fashion destination created
                        for people who want to express their
                        personality through what they wear.
                    </p>

                </div>

                <div
                    style="
                        position: absolute;
                        right: 5%;
                        top: 50%;
                        transform: translateY(-50%);
                        width: 400px;
                        height: 400px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 1;
                    "
                >

                    <img
                        src="<?= $siteRoot ?>/assets/images/About.jpeg"
                        alt="About SHOP.CO"
                        style="
                            display: block;
                            width: 250px;
                            height: 250px;
                            max-width: 250px;
                            max-height: 250px;
                            object-fit: contain;
                        "
                    >

                </div>

            </div>

        </div>

    </section>


    <section class="about-story">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-6">

                    <div class="about-story-visual">

                        <div class="about-story-card">

                            <span>
                                SHOP.CO
                            </span>

                            <strong>
                                YOUR STYLE.
                            </strong>

                            <strong>
                                YOUR WAY.
                            </strong>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="about-content">

                        <span class="about-label">
                            OUR STORY
                        </span>

                        <h2>
                            Fashion made
                            <br>
                            simple.
                        </h2>

                        <p>
                            SHOP.CO was created with one simple
                            idea: shopping for clothes should be
                            easy, enjoyable, and inspiring.
                        </p>

                        <p>
                            We bring together carefully selected
                            styles so you can discover pieces
                            that match your personality and make
                            you feel confident every day.
                        </p>

                        <p>
                            From everyday essentials to statement
                            pieces, SHOP.CO is designed to help
                            you find something that feels like
                            you.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <section class="about-mission">

        <div class="container">

            <div class="about-mission-content">

                <span class="about-label">
                    OUR MISSION
                </span>

                <h2>
                    We believe style
                    <br>
                    should be yours.
                </h2>

                <p>
                    Our mission is to make fashion more
                    accessible while giving everyone the
                    freedom to discover and express their
                    own unique style.
                </p>

            </div>

        </div>

    </section>


    <section class="about-values">

        <div class="container">

            <div class="about-section-heading">

                <span class="about-label">
                    WHY SHOP.CO
                </span>

                <h2>
                    Everything you need
                    <br>
                    to find your style.
                </h2>

            </div>

            <div class="row g-4">

                <div class="col-md-4">

                    <article class="about-value-card">

                        <div class="about-value-icon">
                            <i class="bi bi-stars"></i>
                        </div>

                        <h3>
                            Curated Styles
                        </h3>

                        <p>
                            Discover a collection of styles
                            selected to help you build looks
                            that feel uniquely yours.
                        </p>

                    </article>

                </div>

                <div class="col-md-4">

                    <article class="about-value-card">

                        <div class="about-value-icon">
                            <i class="bi bi-bag-check"></i>
                        </div>

                        <h3>
                            Easy Shopping
                        </h3>

                        <p>
                            Browse, search, filter, and discover
                            your favorite pieces with a simple
                            and convenient shopping experience.
                        </p>

                    </article>

                </div>

                <div class="col-md-4">

                    <article class="about-value-card">

                        <div class="about-value-icon">
                            <i class="bi bi-heart"></i>
                        </div>

                        <h3>
                            Made for You
                        </h3>

                        <p>
                            Whether you prefer timeless basics
                            or bold looks, SHOP.CO gives you
                            the freedom to dress your way.
                        </p>

                    </article>

                </div>

            </div>

        </div>

    </section>


    <section class="about-stats">

        <div class="container">

            <div class="row text-center g-4">

                <div class="col-6 col-md-3">

                    <div class="about-stat">

                        <strong
                            class="about-count-number"
                            data-target="200"
                            data-suffix="+"
                        >
                            0
                        </strong>

                        <span>
                            Products
                        </span>

                    </div>

                </div>

                <div class="col-6 col-md-3">

                    <div class="about-stat">

                        <strong
                            class="about-count-number"
                            data-target="30000"
                            data-suffix="+"
                        >
                            0
                        </strong>

                        <span>
                            Happy Customers
                        </span>

                    </div>

                </div>

                <div class="col-6 col-md-3">

                    <div class="about-stat">

                        <strong
                            class="about-count-number"
                            data-target="50"
                            data-suffix="+"
                        >
                            0
                        </strong>

                        <span>
                            Brands
                        </span>

                    </div>

                </div>

                <div class="col-6 col-md-3">

                    <div class="about-stat">

                        <strong
                            class="about-count-number"
                            data-target="24"
                            data-suffix="/7"
                        >
                            0
                        </strong>

                        <span>
                            Support
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <section class="about-cta">

        <div class="container">

            <div class="about-cta-content">

                <span class="about-label">
                    FIND YOUR STYLE
                </span>

                <h2>
                    Ready to find
                    <br>
                    your next favorite look?
                </h2>

                <p>
                    Explore our collection and discover
                    something made for your style.
                </p>

                <a
                    href="<?= $siteRoot ?>/pages/products.php"
                    class="about-cta-button"
                >
                    Shop Now
                </a>

            </div>

        </div>

    </section>

</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const counters =
        document.querySelectorAll('.about-count-number');

    const statsSection =
        document.querySelector('.about-stats');

    if (!counters.length || !statsSection) {
        return;
    }

    function animateCounter(counter) {

        const target =
            Number(counter.dataset.target);

        const suffix =
            counter.dataset.suffix || '';

        const duration = 1800;

        const startTime =
            performance.now();

        function updateCounter(currentTime) {

            const elapsed =
                currentTime - startTime;

            const progress =
                Math.min(elapsed / duration, 1);

            const easedProgress =
                1 - Math.pow(1 - progress, 3);

            const currentValue =
                Math.floor(target * easedProgress);

            counter.textContent =
                currentValue.toLocaleString() + suffix;

            if (progress < 1) {

                requestAnimationFrame(updateCounter);

            } else {

                counter.textContent =
                    target.toLocaleString() + suffix;

            }

        }

        requestAnimationFrame(updateCounter);
    }

    const observer =
        new IntersectionObserver(
            function (entries, observerInstance) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        counters.forEach(function (counter) {
                            animateCounter(counter);
                        });

                        observerInstance.unobserve(
                            entry.target
                        );

                    }

                });

            },
            {
                threshold: 0.3
            }
        );

    observer.observe(statsSection);

});

</script>

</body>

</html>