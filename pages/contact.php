<?php

$pageTitle = 'Contact Us - SHOP.CO';

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
        <?= htmlspecialchars($pageTitle) ?>
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- Main CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body>


<?php require __DIR__ . '/../shared/header.php'; ?>


<main class="contact-page">


    <!-- =====================================================
         CONTACT HERO
    ====================================================== -->

    <section class="contact-hero">

        <div class="container">

            <div class="contact-breadcrumb">

                <a href="/Final-Project/index.php">
                    Home
                </a>

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

                <span>
                    Contact
                </span>

            </div>


            <div class="contact-hero-content">

                <span class="contact-label">
                    GET IN TOUCH
                </span>


                <h1>
                    We'd love to
                    <br>
                    hear from you.
                </h1>


                <p>
                    Have a question, need help with your order,
                    or simply want to talk to us? Our team is
                    here to help.
                </p>

            </div>

        </div>

    </section>



    <!-- =====================================================
         CONTACT MAIN
    ====================================================== -->

    <section class="contact-main">

        <div class="container">

            <div class="row g-5">


                <!-- CONTACT INFORMATION -->

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


                        <!-- EMAIL -->

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


                        <!-- PHONE -->

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


                        <!-- LOCATION -->

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


                        <!-- HOURS -->

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



                <!-- CONTACT FORM -->

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


                            <!-- NAME + EMAIL -->

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


                            <!-- SUBJECT -->

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


                            <!-- MESSAGE -->

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


                            <!-- SUBMIT -->

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



    <!-- =====================================================
         HELP SECTION
    ====================================================== -->

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


                <!-- ORDER -->

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


                <!-- RETURNS -->

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


                <!-- SUPPORT -->

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



    <!-- =====================================================
         CTA
    ====================================================== -->

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


<!-- =====================================================
     CONTACT FORM
====================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('contactForm');

    const note =
        document.getElementById('contactFormNote');


    if (!form || !note) {
        return;
    }


    form.addEventListener('submit', function (event) {

        event.preventDefault();


        note.textContent =
            'Thank you! Your message has been received.';


        note.classList.add('is-success');


        form.reset();

    });

});

</script>


</body>

</html>