<?php

$pageTitle = 'Contact Us - SHOP.CO';

$projectPath = realpath(__DIR__ . '/..');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');

$siteRoot = '';

if ($projectPath && $documentRoot) {
    $projectPath = str_replace('\\', '/', $projectPath);
    $documentRoot = str_replace('\\', '/', $documentRoot);

    if (strpos($projectPath, $documentRoot) === 0) {
        $siteRoot = substr($projectPath, strlen($documentRoot));
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
        href="<?= htmlspecialchars($siteRoot, ENT_QUOTES, 'UTF-8') ?>/assets/css/style.css"
    >

    <style>

        .contact-hero-flex {
            display: flex !important;
            position: relative !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 2rem !important;
            min-height: 480px !important;
            width: 100% !important;
            padding: 2rem 0 !important;
        }

        .contact-hero-text {
            position: static !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            transform: none !important;
            flex: 1 1 420px !important;
            max-width: 600px !important;
            width: auto !important;
            text-align: left !important;
            z-index: auto !important;
        }

        .contact-hero-image-wrap {
            position: static !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            transform: none !important;
            flex: 0 1 400px !important;
            width: auto !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            z-index: auto !important;
        }

        .contact-hero-image-wrap img {
            position: static !important;
            display: block !important;
            width: 100% !important;
            max-width: 220px !important;
            height: auto !important;
            max-height: none !important;
            object-fit: contain !important;
        }

        @media (max-width: 767.98px) {

            .contact-hero-flex {
                flex-direction: column !important;
                text-align: center !important;
                min-height: auto !important;
                padding: 1.5rem 0 !important;
            }

            .contact-hero-text {
                text-align: center !important;
                max-width: 100% !important;
            }

            .contact-hero-image-wrap {
                order: -1 !important;
            }

            .contact-hero-image-wrap img {
                max-width: 170px !important;
            }

        }

        @media (max-width: 575.98px) {

            .contact-hero-image-wrap img {
                max-width: 140px !important;
            }

            .contact-form-row {
                flex-direction: column !important;
            }

        }

    </style>

</head>

<body>

<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="contact-page">

    <section class="contact-hero">

        <div class="container">

            <div class="contact-breadcrumb">

                <a href="<?= htmlspecialchars($siteRoot, ENT_QUOTES, 'UTF-8') ?>/index.php">
                    Home
                </a>

                <i class="bi bi-chevron-right"></i>

                <span>
                    Contact
                </span>

            </div>

            <div class="contact-hero-flex">

                <div class="contact-hero-text">

                    <span class="contact-label">
                        GET IN TOUCH
                    </span>

                    <h1>
                        We'd love to
                        <br class="d-none d-md-inline">
                        hear from you.
                    </h1>

                    <p>
                        Have a question, need help with your order,
                        or simply want to talk to us? Our team is
                        here to help.
                    </p>

                </div>

                <div class="contact-hero-image-wrap">

                    <img
                        src="<?= htmlspecialchars($siteRoot, ENT_QUOTES, 'UTF-8') ?>/assets/images/contact.svg"
                        alt=""
                    >

                </div>

            </div>

        </div>

    </section>

    <section class="contact-main">

        <div class="container">

            <div class="row g-5">

                <div class="col-lg-5">

                    <div class="contact-info">

                        <span class="contact-label">
                            CONTACT US
                        </span>

                        <h2>
                            Let's talk.
                        </h2>

                        <p class="contact-info-intro">
                            We're always happy to help. Reach out
                            to us through any of the options below
                            and we'll get back to you as soon as
                            possible.
                        </p>

                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>

                                <span>
                                    Email
                                </span>

                                <a href="mailto:support@shop.co">
                                    support@shop.co
                                </a>

                            </div>

                        </div>

                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-telephone"></i>
                            </div>

                            <div>

                                <span>
                                    Phone
                                </span>

                                <a href="tel:+201000000000">
                                    +20 100 000 0000
                                </a>

                            </div>

                        </div>

                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div>

                                <span>
                                    Location
                                </span>

                                <p>
                                    Cairo, Egypt
                                </p>

                            </div>

                        </div>

                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>

                                <span>
                                    Working Hours
                                </span>

                                <p>
                                    Sunday - Thursday
                                    <br>
                                    9:00 AM - 6:00 PM
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-7">

                    <div class="contact-form-wrapper">

                        <h2>
                            Send us a message
                        </h2>

                        <p>
                            Fill out the form below and we'll
                            get back to you.
                        </p>

                        <form
                            class="contact-form"
                            id="contactForm"
                            action="#"
                            method="post"
                        >

                            <div class="contact-form-row">

                                <div class="contact-field">

                                    <label for="contact-name">
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        id="contact-name"
                                        name="name"
                                        placeholder="Your name"
                                        autocomplete="name"
                                        required
                                    >

                                </div>

                                <div class="contact-field">

                                    <label for="contact-email">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        id="contact-email"
                                        name="email"
                                        placeholder="Your email"
                                        autocomplete="email"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="contact-field">

                                <label for="contact-subject">
                                    Subject
                                </label>

                                <input
                                    type="text"
                                    id="contact-subject"
                                    name="subject"
                                    placeholder="What can we help you with?"
                                    required
                                >

                            </div>

                            <div class="contact-field">

                                <label for="contact-message">
                                    Message
                                </label>

                                <textarea
                                    id="contact-message"
                                    name="message"
                                    rows="6"
                                    placeholder="Write your message..."
                                    required
                                ></textarea>

                            </div>

                            <button
                                type="submit"
                                class="contact-submit"
                            >

                                <span>
                                    Send Message
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </button>

                            <p
                                class="contact-form-note"
                                id="contactFormNote"
                            >
                                We'll get back to you as soon as
                                possible.
                            </p>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="contact-help">

        <div class="container">

            <div class="contact-section-heading">

                <span class="contact-label">
                    NEED HELP?
                </span>

                <h2>
                    We've got you covered.
                </h2>

            </div>

            <div class="row g-4">

                <div class="col-md-4">

                    <article class="contact-help-card">

                        <div class="contact-help-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <h3>
                            Order Questions
                        </h3>

                        <p>
                            Need help with an order,
                            delivery, or tracking?
                            We're here to help.
                        </p>

                        <a href="#contactForm">
                            Contact Us
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </article>

                </div>

                <div class="col-md-4">

                    <article class="contact-help-card">

                        <div class="contact-help-icon">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>

                        <h3>
                            Returns & Exchanges
                        </h3>

                        <p>
                            Have questions about returning
                            or exchanging an item?
                            Contact our team.
                        </p>

                        <a href="#contactForm">
                            Contact Us
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </article>

                </div>

                <div class="col-md-4">

                    <article class="contact-help-card">

                        <div class="contact-help-icon">
                            <i class="bi bi-headset"></i>
                        </div>

                        <h3>
                            Customer Support
                        </h3>

                        <p>
                            Can't find what you're looking for?
                            Send us a message and we'll help.
                        </p>

                        <a href="#contactForm">
                            Contact Us
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </article>

                </div>

            </div>

        </div>

    </section>

    <section class="contact-cta">

        <div class="container">

            <div class="contact-cta-content">

                <h2>
                    Still have questions?
                </h2>

                <p>
                    Don't hesitate to reach out.
                    We're here for you.
                </p>

                <a
                    href="#contactForm"
                    class="contact-cta-button"
                >
                    Send Us a Message
                </a>

            </div>

        </div>

    </section>

</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('contactForm');
    const note = document.getElementById('contactFormNote');

    if (form && note) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            note.textContent =
                'Thank you! Your message has been received.';

            note.classList.add('is-success');

            form.reset();

        });

    }

});
</script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>