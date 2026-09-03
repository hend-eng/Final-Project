<?php

require_once __DIR__ . '/../config/db.php';

$pageTitle = 'Our Team - SHOP.CO';

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

    <style>

        .team-hero-flex {
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

        .team-hero-text {
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

        .team-hero-image-wrap {
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

        .team-hero-image-wrap img {
            position: static !important;
            display: block !important;
            width: 100% !important;
            max-width: 240px !important;
            height: auto !important;
            max-height: none !important;
            object-fit: contain !important;
        }

        @media (max-width: 767.98px) {

            .team-hero-flex {
                flex-direction: column !important;
                text-align: center !important;
                min-height: auto !important;
                padding: 1.5rem 0 !important;
            }

            .team-hero-text {
                text-align: center !important;
                max-width: 100% !important;
            }

            .team-hero-image-wrap {
                order: -1 !important;
            }

            .team-hero-image-wrap img {
                max-width: 180px !important;
            }

        }

        @media (max-width: 575.98px) {

            .team-hero-image-wrap img {
                max-width: 150px !important;
            }

        }

    </style>

</head>

<body>

<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="team-page">

    <section class="team-hero">

        <div class="container">

            <div class="team-breadcrumb">

                <a href="<?= $siteRoot ?>/index.php">
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

            <div class="team-hero-flex">

                <div class="team-hero-text">

                    <span class="team-label">
                        MEET THE TEAM
                    </span>

                    <h1>
                        The people behind
                        <br class="d-none d-md-inline">
                        SHOP.CO.
                    </h1>

                    <p>
                        Meet the people who work together to create
                        a simple, stylish, and enjoyable shopping
                        experience.
                    </p>

                </div>

                <div class="team-hero-image-wrap">

                    <img
                        src="<?= $siteRoot ?>/assets/images/Team.svg"
                        alt="SHOP.CO Team"
                    >

                </div>

            </div>

        </div>

    </section>

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

    <section class="team-members">

        <div class="container">

            <?php if (empty($teamMembers)): ?>

                <div class="team-empty">

                    <div class="team-empty-icon">

                        <i
                            class="bi bi-people"
                            aria-hidden="true"
                        ></i>

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

                        $imageUrl = '';

                        if ($memberImage !== '') {

                            if (
                                str_starts_with($memberImage, 'http://') ||
                                str_starts_with($memberImage, 'https://')
                            ) {

                                $imageUrl = $memberImage;

                            } elseif (
                                str_starts_with($memberImage, '/')
                            ) {

                                $imageUrl = $memberImage;

                            } else {

                                $imageUrl =
                                    $siteRoot . '/' .
                                    ltrim($memberImage, '/');

                            }

                        }

                        ?>

                        <div class="col-sm-6 col-lg-4">

                            <article class="team-card">

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
                    href="<?= $siteRoot ?>/pages/contact.php"
                    class="team-cta-button"
                >
                    Get In Touch
                </a>

            </div>

        </div>

    </section>

</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>
