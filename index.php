<?php
require_once __DIR__ . '/config/products.php';
$basePath = '.';
$pageTitle = 'SHOP.CO';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>SHOP.CO</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <body>
    <?php require __DIR__ . '/shared/header.php'; ?>

    <main>
      <section class="hero">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-md-6">
              <h1>
                FIND CLOTHES<br />
                THAT MATCHES<br />
                YOUR STYLE!
              </h1>

              <p>
                Browse through our diverse range of meticulously crafted
                garments, designed to bring out your individuality and cater to
                your sense of style.
              </p>

              <a href="pages/products.php" class="btn btn-dark hero-button">
                Shop Now
              </a>

              <div class="hero-stats">
                <div>
                  <strong>200+</strong>
                  <span>International Brands</span>
                </div>

                <div>
                  <strong>2,000+</strong>
                  <span>High-Quality Products</span>
                </div>

                <div>
                  <strong>30,000+</strong>
                  <span>Happy Customers</span>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="hero-image">
                <img src="assets/images/Hero.png" alt="Fashion models" />

                <i
                  class="bi bi-stars hero-spark hero-spark-large"
                  aria-hidden="true"
                ></i>

                <i
                  class="bi bi-stars hero-spark hero-spark-small"
                  aria-hidden="true"
                ></i>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="brands-section" aria-label="Featured brands">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-around">
            <div class="col">
              <span class="brand-name">VERSACE</span>
            </div>

            <div class="col">
              <span class="brand-name">ZARA</span>
            </div>

            <div class="col">
              <span class="brand-name">GUCCI</span>
            </div>

            <div class="col">
              <span class="brand-name">PRADA</span>
            </div>

            <div class="col">
              <span class="brand-name">Calvin Klein</span>
            </div>
          </div>
        </div>
      </section>

      <section class="products-section">
        <div class="container">
          <h2 class="section-title">NEW ARRIVALS</h2>

          <div class="row g-3"><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=graphic-blue-tshirt" class="text-decoration-none text-reset"><img src="assets/images/products/Pic1.jpg" class="img-fluid" alt="Graphic Blue T-Shirt"><h3>Graphic Blue T-Shirt</h3><div class="product-rating">4.5/5</div><strong>$120.00</strong> <del>$150.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=black-graphic-tshirt" class="text-decoration-none text-reset"><img src="assets/images/products/Pic2.jpg" class="img-fluid" alt="Black Graphic T-Shirt"><h3>Black Graphic T-Shirt</h3><div class="product-rating">4.3/5</div><strong>$110.00</strong> <del>$140.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=burgundy-graphic-tshirt" class="text-decoration-none text-reset"><img src="assets/images/products/Pic3.jpg" class="img-fluid" alt="Burgundy Graphic T-Shirt"><h3>Burgundy Graphic T-Shirt</h3><div class="product-rating">4.6/5</div><strong>$125.00</strong> <del>$160.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=blue-print-tshirt" class="text-decoration-none text-reset"><img src="assets/images/products/Pic4.jpg" class="img-fluid" alt="Blue Print T-Shirt"><h3>Blue Print T-Shirt</h3><div class="product-rating">4.4/5</div><strong>$115.00</strong> <del>$145.00</del></a></article></div></div>

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

      <section class="products-section">
        <div class="container">
          <h2 class="section-title">TOP SELLING</h2>

          <div class="row g-3"><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=dark-green-hoodie" class="text-decoration-none text-reset"><img src="assets/images/products/Pic19.jpg" class="img-fluid" alt="Dark Green Hoodie"><h3>Dark Green Hoodie</h3><div class="product-rating">4.8/5</div><strong>$245.00</strong> <del>$305.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=dark-graphic-tshirt" class="text-decoration-none text-reset"><img src="assets/images/products/Pic5.jpg" class="img-fluid" alt="Dark Graphic T-Shirt"><h3>Dark Graphic T-Shirt</h3><div class="product-rating">4.7/5</div><strong>$130.00</strong> <del>$160.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=white-print-hoodie" class="text-decoration-none text-reset"><img src="assets/images/products/Pic15.jpg" class="img-fluid" alt="White Graphic Hoodie"><h3>White Graphic Hoodie</h3><div class="product-rating">4.7/5</div><strong>$235.00</strong> <del>$295.00</del></a></article></div><div class="col-6 col-md-3"><article class="product-card h-100"><a href="pages/product-details.php?id=black-jeans" class="text-decoration-none text-reset"><img src="assets/images/products/Pic27.jpg" class="img-fluid" alt="Black Straight Jeans"><h3>Black Straight Jeans</h3><div class="product-rating">4.7/5</div><strong>$245.00</strong> <del>$305.00</del></a></article></div></div>

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

      <section class="dress-style-section">
        <div class="container">
          <div class="dress-style-box">
            <h2 class="section-title">BROWSE BY DRESS STYLE</h2>

            <div class="row g-3">
              <div class="col-12 col-md-5">
                <a href="pages/products.php?style=Casual" class="dress-style-card">
                  <span>Casual</span>

                  <img src="assets/images/Casual.png" alt="Casual clothing" />
                </a>
              </div>

              <div class="col-12 col-md-7">
                <a href="pages/products.php?style=Formal" class="dress-style-card">
                  <span>Formal</span>

                  <img src="assets/images/Formal.png" alt="Formal clothing" />
                </a>
              </div>

              <div class="col-12 col-md-7">
                <a href="pages/products.php?style=Party" class="dress-style-card">
                  <span>Party</span>

                  <img src="assets/images/Party.png" alt="Party clothing" />
                </a>
              </div>

              <div class="col-12 col-md-5">
                <a href="pages/products.php?style=Gym" class="dress-style-card">
                  <span>Gym</span>

                  <img src="assets/images/gym.png" alt="Gym clothing" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="reviews-section">
        <div class="container">
          <div class="reviews-header">
            <h2 class="section-title mb-0">OUR HAPPY CUSTOMERS</h2>

            <div class="reviews-arrows">
              <button
                type="button"
                data-bs-target="#reviewsCarousel"
                data-bs-slide="prev"
                aria-label="Previous reviews"
              >
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
              </button>

              <button
                type="button"
                data-bs-target="#reviewsCarousel"
                data-bs-slide="next"
                aria-label="Next reviews"
              >
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div
            id="reviewsCarousel"
            class="carousel slide"
            data-bs-ride="false"
            aria-label="Customer reviews"
          >
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "I absolutely love the quality of the clothes.
                        Everything looks exactly like the pictures!"
                      </p>
                    </article>
                  </div>

                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "Great quality and fast delivery. I will definitely shop
                        here again."
                      </p>
                    </article>
                  </div>

                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "The clothes fit perfectly and the quality is really
                        good. Highly recommended!"
                      </p>
                    </article>
                  </div>
                </div>
              </div>

              <div class="carousel-item">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "The designs are beautiful and the ordering process was
                        really easy."
                      </p>
                    </article>
                  </div>

                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "Very happy with my purchase. The clothes feel great and
                        look even better."
                      </p>
                    </article>
                  </div>

                  <div class="col-12 col-md-4">
                    <article class="review-card">
                      <div class="review-stars" aria-label="5 out of 5 stars">
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
                        "Amazing experience from start to finish. I found
                        exactly what I was looking for."
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

    <?php require __DIR__ . '/shared/footer.php'; ?>
  </body>
</html>
