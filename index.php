<?php

$basePath = '.';
$pageTitle = 'SHOP.CO';

require_once __DIR__ . '/shared/auth.php';

/*
 * Load ALL brands from the database.
 * The brands table is managed by the admin/CRUD part of the project.
 */
$brandList = [];

try {
    $brandStatement = $pdo->query(
        "SELECT id, name, logo, website
         FROM brands
         ORDER BY name ASC"
    );

    $brandList = $brandStatement->fetchAll();
} catch (PDOException $e) {
    // Keep the home page working if the brands table is temporarily unavailable.
    $brandList = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= htmlspecialchars($pageTitle) ?></title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >


    <!-- Main Website CSS -->

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars($basePath) ?>/assets/css/style.css"
    >

</head>


<body>


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <?php require __DIR__ . '/shared/header.php'; ?>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main>


        <!-- =================================================
             HERO
        ================================================== -->

        <section class="hero">

            <div class="container">

                <div class="row align-items-center">


                    <!-- HERO TEXT -->

                    <div class="col-12 col-md-6">

                        <h1>
                            FIND CLOTHES<br>
                            THAT MATCHES<br>
                            YOUR STYLE!
                        </h1>


                        <p>
                            Browse through our diverse range of meticulously
                            crafted garments, designed to bring out your
                            individuality and cater to your sense of style.
                        </p>


                        <a
                            href="pages/products.php"
                            class="btn btn-dark hero-button"
                        >
                            Shop Now
                        </a>


                        <div class="hero-stats">


                            <div>

                                <strong
                                    class="count-number"
                                    data-target="200"
                                    data-suffix="+"
                                >
                                    0
                                </strong>

                                <span>
                                    International Brands
                                </span>

                            </div>


                            <div>

                                <strong
                                    class="count-number"
                                    data-target="2000"
                                    data-suffix="+"
                                >
                                    0
                                </strong>

                                <span>
                                    High-Quality Products
                                </span>

                            </div>


                            <div>

                                <strong
                                    class="count-number"
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

                    </div>


                    <!-- HERO IMAGE -->

                    <div class="col-12 col-md-6">

                        <div class="hero-image">

                            <img
                                src="assets/images/Hero.png"
                                alt="SHOP.CO fashion collection"
                            >
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- =================================================
             BRANDS
        ================================================== -->

     <section
    class="brands-section"
    aria-label="Featured brands"
>

    <div class="brands-marquee">

        <div class="brands-marquee-track">

            <!-- FIRST SET -->

            <div class="brands-marquee-group">

                <?php foreach ($brandList as $brand): ?>

                    <a
                        href="pages/products.php?brand=<?= urlencode((string)$brand['id']) ?>"
                        class="marquee-brand"
                    >
                        <?= htmlspecialchars(
                            $brand['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </a>

                <?php endforeach; ?>

            </div>


            <!-- SECOND SET
                 Exact copy for seamless looping -->

            <div
                class="brands-marquee-group"
                aria-hidden="true"
            >

                <?php foreach ($brandList as $brand): ?>

                    <a
                        href="pages/products.php?brand=<?= urlencode((string)$brand['id']) ?>"
                        class="marquee-brand"
                        tabindex="-1"
                    >
                        <?= htmlspecialchars(
                            $brand['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </a>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</section>



        <!-- =================================================
             NEW ARRIVALS
        ================================================== -->

        <section class="products-section">

            <div class="container">

                <h2 class="section-title">
                    NEW ARRIVALS
                </h2>


                <div class="row g-3">


                    <!-- PRODUCT 1 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=graphic-blue-tshirt"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic1.jpg"
                                    class="img-fluid"
                                    alt="Graphic Blue T-Shirt"
                                >

                                <h3>
                                    Graphic Blue T-Shirt
                                </h3>

                                <div class="product-rating">
                                    4.5/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $120.00
                                    </strong>

                                    <del>
                                        $150.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 2 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=black-graphic-tshirt"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic2.jpg"
                                    class="img-fluid"
                                    alt="Black Graphic T-Shirt"
                                >

                                <h3>
                                    Black Graphic T-Shirt
                                </h3>

                                <div class="product-rating">
                                    4.3/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $110.00
                                    </strong>

                                    <del>
                                        $140.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 3 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=burgundy-graphic-tshirt"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic3.jpg"
                                    class="img-fluid"
                                    alt="Burgundy Graphic T-Shirt"
                                >

                                <h3>
                                    Burgundy Graphic T-Shirt
                                </h3>

                                <div class="product-rating">
                                    4.6/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $125.00
                                    </strong>

                                    <del>
                                        $160.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 4 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=blue-print-tshirt"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic4.jpg"
                                    class="img-fluid"
                                    alt="Blue Print T-Shirt"
                                >

                                <h3>
                                    Blue Print T-Shirt
                                </h3>

                                <div class="product-rating">
                                    4.4/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $115.00
                                    </strong>

                                    <del>
                                        $145.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                </div>


                <div class="text-center">

                    <a
                        href="pages/products.php?tag=new"
                        class="btn btn-light view-all-button"
                    >
                        View All
                    </a>

                </div>

            </div>

        </section>



        <!-- =================================================
             TOP SELLING
        ================================================== -->

        <section class="products-section">

            <div class="container">

                <h2 class="section-title">
                    TOP SELLING
                </h2>


                <div class="row g-3">


                    <!-- PRODUCT 1 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=dark-green-hoodie"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic19.jpg"
                                    class="img-fluid"
                                    alt="Dark Green Hoodie"
                                >

                                <h3>
                                    Dark Green Hoodie
                                </h3>

                                <div class="product-rating">
                                    4.8/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $245.00
                                    </strong>

                                    <del>
                                        $305.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 2 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=dark-graphic-tshirt"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic5.jpg"
                                    class="img-fluid"
                                    alt="Dark Graphic T-Shirt"
                                >

                                <h3>
                                    Dark Graphic T-Shirt
                                </h3>

                                <div class="product-rating">
                                    4.7/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $130.00
                                    </strong>

                                    <del>
                                        $160.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 3 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=white-print-hoodie"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic15.jpg"
                                    class="img-fluid"
                                    alt="White Graphic Hoodie"
                                >

                                <h3>
                                    White Graphic Hoodie
                                </h3>

                                <div class="product-rating">
                                    4.7/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $235.00
                                    </strong>

                                    <del>
                                        $295.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                    <!-- PRODUCT 4 -->

                    <div class="col-6 col-md-3">

                        <article class="product-card h-100">

                            <a
                                href="pages/product-details.php?id=black-jeans"
                                class="text-decoration-none text-reset"
                            >

                                <img
                                    src="assets/images/products/Pic27.jpg"
                                    class="img-fluid"
                                    alt="Black Straight Jeans"
                                >

                                <h3>
                                    Black Straight Jeans
                                </h3>

                                <div class="product-rating">
                                    4.7/5
                                </div>

                                <div class="product-price">

                                    <strong>
                                        $245.00
                                    </strong>

                                    <del>
                                        $305.00
                                    </del>

                                </div>

                            </a>

                        </article>

                    </div>


                </div>


                <div class="text-center">

                    <a
                        href="pages/products.php?tag=top-selling"
                        class="btn btn-light view-all-button"
                    >
                        View All
                    </a>

                </div>

            </div>

        </section>



        <!-- =================================================
             DRESS STYLE
        ================================================== -->

        <section class="dress-style-section">

            <div class="container">

                <div class="dress-style-box">

                    <h2 class="section-title">
                        BROWSE BY DRESS STYLE
                    </h2>


                    <div class="row g-3">


                        <!-- CASUAL -->

                        <div class="col-12 col-md-5">

                            <a
                                href="pages/products.php?style=Casual"
                                class="dress-style-card"
                            >

                                <span>
                                    Casual
                                </span>

                                <img
                                    src="assets/images/Casual.png"
                                    alt="Casual clothing"
                                >

                            </a>

                        </div>


                        <!-- FORMAL -->

                        <div class="col-12 col-md-7">

                            <a
                                href="pages/products.php?style=Formal"
                                class="dress-style-card"
                            >

                                <span>
                                    Formal
                                </span>

                                <img
                                    src="assets/images/Formal.png"
                                    alt="Formal clothing"
                                >

                            </a>

                        </div>


                        <!-- PARTY -->

                        <div class="col-12 col-md-7">

                            <a
                                href="pages/products.php?style=Party"
                                class="dress-style-card"
                            >

                                <span>
                                    Party
                                </span>

                                <img
                                    src="assets/images/Party.png"
                                    alt="Party clothing"
                                >

                            </a>

                        </div>


                        <!-- GYM -->

                        <div class="col-12 col-md-5">

                            <a
                                href="pages/products.php?style=Gym"
                                class="dress-style-card"
                            >

                                <span>
                                    Gym
                                </span>

                                <img
                                    src="assets/images/gym.png"
                                    alt="Gym clothing"
                                >

                            </a>

                        </div>


                    </div>

                </div>

            </div>

        </section>



        <!-- =================================================
             CUSTOMER REVIEWS
        ================================================== -->

        <section class="reviews-section">

            <div class="container">


                <div class="reviews-header">

                    <h2 class="section-title mb-0">
                        OUR HAPPY CUSTOMERS
                    </h2>


                    <div class="reviews-arrows">

                        <button
                            type="button"
                            data-bs-target="#reviewsCarousel"
                            data-bs-slide="prev"
                            aria-label="Previous reviews"
                        >

                            <i
                                class="bi bi-arrow-left"
                                aria-hidden="true"
                            ></i>

                        </button>


                        <button
                            type="button"
                            data-bs-target="#reviewsCarousel"
                            data-bs-slide="next"
                            aria-label="Next reviews"
                        >

                            <i
                                class="bi bi-arrow-right"
                                aria-hidden="true"
                            ></i>

                        </button>

                    </div>

                </div>



                <div
                    id="reviewsCarousel"
                    class="carousel slide"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">


                        <!-- REVIEW SLIDE 1 -->

                        <div class="carousel-item active">

                            <div class="row g-3">


                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            Sarah M.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "I absolutely love the quality of
                                            the clothes. Everything looks
                                            exactly like the pictures!"
                                        </p>

                                    </article>

                                </div>



                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            Alex K.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "Great quality and fast delivery.
                                            I will definitely shop here again."
                                        </p>

                                    </article>

                                </div>



                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            James L.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "The clothes fit perfectly and the
                                            quality is really good. Highly
                                            recommended!"
                                        </p>

                                    </article>

                                </div>


                            </div>

                        </div>



                        <!-- REVIEW SLIDE 2 -->

                        <div class="carousel-item">

                            <div class="row g-3">


                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            Emma R.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "The designs are beautiful and the
                                            ordering process was really easy."
                                        </p>

                                    </article>

                                </div>



                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            Michael B.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "Very happy with my purchase. The
                                            clothes feel great and look even
                                            better."
                                        </p>

                                    </article>

                                </div>



                                <div class="col-12 col-md-4">

                                    <article class="review-card">

                                        <div class="review-stars">

                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>

                                        </div>


                                        <h3>
                                            Olivia T.
                                            <i class="bi bi-patch-check-fill"></i>
                                        </h3>


                                        <p>
                                            "Amazing experience from start to
                                            finish. I found exactly what I was
                                            looking for."
                                        </p>

                                    </article>

                                </div>


                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </section>


    </main>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <?php require __DIR__ . '/shared/footer.php'; ?>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script
        src="assets/js/home.js"
    ></script>


</body>

</html>