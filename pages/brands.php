<?php

$pageTitle = 'Our Brands - SHOP.CO';

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

$brands = [
    [
        'name' => 'Prada',
        'desc' => 'Italian luxury fashion house known for leather handbags and high-end apparel.',
        'tag' => 'Luxury & Elegance',
        'font_style' => 'font-family: serif; letter-spacing: 3px;'
    ],
    [
        'name' => 'Versace',
        'desc' => 'Bold, glamorous Italian design with iconic high-fashion aesthetics.',
        'tag' => 'Glamour & Style',
        'font_style' => 'font-family: sans-serif; font-weight: 900; letter-spacing: 3px;'
    ],
    [
        'name' => 'Zara',
        'desc' => 'Trend-setting fast fashion bringing modern styles to everyday wear.',
        'tag' => 'Modern Essentials',
        'font_style' => 'font-family: sans-serif; font-weight: 800;'
    ],
    [
        'name' => 'Calvin Klein',
        'desc' => 'Minimalist modern aesthetic defining casual luxury and iconic denim.',
        'tag' => 'Minimal & Iconic',
        'font_style' => 'font-family: sans-serif; font-weight: 300; letter-spacing: 2px;'
    ],
    [
        'name' => 'Gucci',
        'desc' => 'Influential, innovative and progressive Italian haute couture.',
        'tag' => 'High Couture',
        'font_style' => 'font-family: serif; font-weight: bold; letter-spacing: 4px;'
    ]
];

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

        .brands-hero {
            background: #f0eeed;
            padding: 50px 20px;
            border-radius: 20px;
            margin-top: 20px;
        }

        .brand-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 16px;
            padding: 30px 24px;
            transition: all 0.3s ease-in-out;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: #000;
        }

        .brand-logo-preview {
            background: #000;
            color: #fff;
            padding: 25px 15px;
            border-radius: 12px;
            text-align: center;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .brand-tag {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 1px;
        }

        .btn-explore {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .brand-card:hover .btn-explore {
            background-color: #000;
            color: #fff;
        }

    </style>

</head>

<body>

<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="container my-5">

    <div class="brands-hero text-center mb-5">

        <h1 class="fw-bold display-5">
            Featured Brands
        </h1>

        <p class="text-muted mb-0">
            Explore our exclusive collections from top international fashion brands.
        </p>

    </div>


    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

        <?php foreach ($brands as $brand): ?>

            <div class="col">

                <div class="brand-card">

                    <div>

                        <div class="brand-logo-preview">

                            <span style="<?= htmlspecialchars($brand['font_style'], ENT_QUOTES, 'UTF-8') ?>">

                                <?= htmlspecialchars(
                                    strtoupper($brand['name']),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </span>

                        </div>


                        <span class="brand-tag d-block mb-2">

                            <?= htmlspecialchars(
                                $brand['tag'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </span>


                        <h3 class="fw-bold fs-4 mb-2">

                            <?= htmlspecialchars(
                                $brand['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </h3>


                        <p class="text-muted fs-6 mb-4">

                            <?= htmlspecialchars(
                                $brand['desc'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </p>

                    </div>


                    <div class="pt-3 border-top">

                        <a
                            href="<?= $siteRoot ?>/pages/products.php?brand=<?= urlencode($brand['name']) ?>"
                            class="btn btn-outline-dark btn-explore w-100"
                        >

                            Explore Collection

                            <i class="bi bi-arrow-right ms-1"></i>

                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</main>


<?php require __DIR__ . '/../shared/footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>