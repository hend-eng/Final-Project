<?php

require_once __DIR__ . '/../config/db.php';

$pageTitle = 'Our Team - SHOP.CO';


/* =========================================================
   GET TEAM MEMBERS
========================================================= */

$sql = "
    SELECT
        id,
        name,
        position,
        image,
        bio
    FROM team
    ORDER BY id ASC
";

$stmt = $pdo->query($sql);

$teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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


<main class="team-page">


    <!-- =====================================================
         TEAM HERO
    ====================================================== -->

    <section class="team-hero">

        <div class="container">

            <div class="team-breadcrumb">

                <a href="/Final-Project/index.php">
                    Home
                </a>

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

                <span>
                    Team
                </span>

            </div>


            <div class="team-hero-content">

                <span class="team-label">
                    MEET THE TEAM
                </span>


                <h1>
                    The people behind
                    <br>
                    SHOP.CO.
                </h1>


                <p>
                    Meet the people who work together to create
                    a simple, stylish, and enjoyable shopping
                    experience.
                </p>

            </div>

        </div>

    </section>



    <!-- =====================================================
         TEAM INTRO
    ====================================================== -->

    <section class="team-intro">

        <div class="container">

            <div class="team-intro-content">

                <span class="team-label">
                    OUR TEAM
                </span>


                <h2>
                    Different skills.
                    <br>
                    One vision.
                </h2>


                <p>
                    SHOP.CO is built by a team of creative and
                    motivated people working together to create
                    a better shopping experience.
                </p>

            </div>

        </div>

    </section>



    <!-- =====================================================
         TEAM MEMBERS
    ====================================================== -->

    <section class="team-members">

        <div class="container">


            <?php if (empty($teamMembers)): ?>


                <!-- =================================================
                     EMPTY TEAM
                ================================================== -->

                <div class="team-empty">

                    <div class="team-empty-icon">

                        <i class="bi bi-people"></i>

                    </div>


                    <h2>
                        Our team is coming soon.
                    </h2>


                    <p>
                        Our team members will appear here once
                        they are added to SHOP.CO.
                    </p>

                </div>


            <?php else: ?>


                <!-- =================================================
                     TEAM GRID
                ================================================== -->

                <div class="row g-4">


                    <?php foreach ($teamMembers as $member): ?>


                        <?php

                        $memberName =
                            trim((string)($member['name'] ?? ''));

                        $memberPosition =
                            trim((string)($member['position'] ?? ''));

                        $memberBio =
                            trim((string)($member['bio'] ?? ''));

                        $memberImage =
                            trim((string)($member['image'] ?? ''));


                        /*
                        |--------------------------------------------------------------------------
                        | IMAGE PATH
                        |--------------------------------------------------------------------------
                        */

                        $imageUrl = '';

                        if ($memberImage !== '') {

                            if (
                                str_starts_with(
                                    $memberImage,
                                    'http://'
                                )
                                ||
                                str_starts_with(
                                    $memberImage,
                                    'https://'
                                )
                            ) {

                                $imageUrl = $memberImage;

                            } elseif (
                                str_starts_with(
                                    $memberImage,
                                    '/'
                                )
                            ) {

                                $imageUrl = $memberImage;

                            } else {

                                $imageUrl =
                                    '/Final-Project/' .
                                    ltrim($memberImage, '/');

                            }

                        }

                        ?>


                        <!-- =================================================
                             TEAM CARD
                        ================================================== -->

                        <div class="col-sm-6 col-lg-4">

                            <article class="team-card">


                                <!-- IMAGE -->

                                <div class="team-avatar">


                                    <?php if ($imageUrl !== ''): ?>


                                        <img
                                            src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>"
                                            alt="<?= htmlspecialchars($memberName, ENT_QUOTES, 'UTF-8') ?>"
                                        >


                                    <?php else: ?>


                                        <i
                                            class="bi bi-person"
                                            aria-hidden="true"
                                        ></i>


                                    <?php endif; ?>


                                </div>



                                <!-- CONTENT -->

                                <div class="team-card-content">


                                    <?php if ($memberPosition !== ''): ?>

                                        <span class="team-role">
                                            <?= htmlspecialchars($memberPosition, ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    <?php endif; ?>


                                    <h3>
                                        <?= htmlspecialchars(
                                            $memberName ?: 'Team Member',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </h3>


                                    <?php if ($memberBio !== ''): ?>

                                        <p>
                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $memberBio,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            ) ?>
                                        </p>

                                    <?php endif; ?>


                                </div>


                            </article>

                        </div>


                    <?php endforeach; ?>


                </div>


            <?php endif; ?>


        </div>

    </section>



    <!-- =====================================================
         TEAM CTA
    ====================================================== -->

    <section class="team-cta">

        <div class="container">

            <div class="team-cta-content">

                <span class="team-label">
                    SHOP.CO
                </span>


                <h2>
                    Great things happen
                    <br>
                    when we work together.
                </h2>


                <a
                    href="/Final-Project/pages/contact.php"
                    class="team-cta-button"
                >
                    Get In Touch
                </a>

            </div>

        </div>

    </section>


</main>


<?php require __DIR__ . '/../shared/footer.php'; ?>


</body>

</html>