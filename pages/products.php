<?php

require_once __DIR__ . '/../config/products.php';

$basePath = '..';
$pageTitle = 'Shop - SHOP.CO';


/*
|--------------------------------------------------------------------------
| GET ALL PRODUCTS
|--------------------------------------------------------------------------
*/

$allProducts = getProducts();


/*
|--------------------------------------------------------------------------
| GET FILTER VALUES
|--------------------------------------------------------------------------
*/

$category = trim($_GET['category'] ?? '');

$style = trim($_GET['style'] ?? '');

$tag = trim($_GET['tag'] ?? '');

$brand = trim($_GET['brand'] ?? '');

$search = trim($_GET['search'] ?? '');

$minPrice = trim($_GET['min_price'] ?? '');

$maxPrice = trim($_GET['max_price'] ?? '');

$sort = trim($_GET['sort'] ?? 'popular');


/*
|--------------------------------------------------------------------------
| PRICE VALUES
|--------------------------------------------------------------------------
*/

$minPriceValue = null;
$maxPriceValue = null;

if ($minPrice !== '' && is_numeric($minPrice)) {
    $minPriceValue = (float) $minPrice;
}

if ($maxPrice !== '' && is_numeric($maxPrice)) {
    $maxPriceValue = (float) $maxPrice;
}


/*
|--------------------------------------------------------------------------
| HELPER FUNCTIONS
|--------------------------------------------------------------------------
*/

/*
 * Get product brand name.
 *
 * Supports different possible dataset structures:
 *
 * brand
 * brand_name
 * name inside brand
 */

function getProductBrandName(array $product): string
{
    if (!empty($product['brand'])) {

        if (is_array($product['brand'])) {

            return trim(
                (string) (
                    $product['brand']['name']
                    ?? ''
                )
            );
        }

        return trim(
            (string) $product['brand']
        );
    }

    if (!empty($product['brand_name'])) {

        return trim(
            (string) $product['brand_name']
        );
    }

    return '';
}


/*
 * Get product brand ID.
 */

function getProductBrandId(array $product): string
{
    return trim(
        (string) (
            $product['brand_id']
            ?? ''
        )
    );
}


/*
 * Get product tags as an array.
 */

function getProductTags(array $product): array
{
    $tags = $product['tags'] ?? [];

    /*
     * If tags are already an array.
     */

    if (is_array($tags)) {
        return $tags;
    }


    /*
     * If tags are stored as a comma-separated string.
     */

    if (is_string($tags)) {

        $tags = trim($tags);

        if ($tags === '') {
            return [];
        }

        return array_map(
            'trim',
            explode(',', $tags)
        );
    }


    return [];
}


/*
 * Check whether a product is on sale.
 *
 * A product is considered on sale when:
 *
 * discount > 0
 *
 * OR
 *
 * original_price > price
 *
 * OR
 *
 * it has the "sale" tag.
 */

function isProductOnSale(array $product): bool
{
    $price =
        isset($product['price'])
            ? (float) $product['price']
            : (float) productPrice($product);


    $originalPrice =
        isset($product['original_price'])
            ? (float) $product['original_price']
            : 0;


    $discount =
        isset($product['discount'])
            ? (float) $product['discount']
            : 0;


    /*
     * Discount field.
     */

    if ($discount > 0) {
        return true;
    }


    /*
     * Original price is higher than current price.
     */

    if (
        $originalPrice > 0 &&
        $originalPrice > $price
    ) {
        return true;
    }


    /*
     * Sale tag.
     */

    foreach (getProductTags($product) as $productTag) {

        if (
            strcasecmp(
                (string) $productTag,
                'sale'
            ) === 0
        ) {
            return true;
        }
    }


    return false;
}


/*
|--------------------------------------------------------------------------
| FILTER PRODUCTS
|--------------------------------------------------------------------------
*/

$filtered = array_values(
    array_filter(
        $allProducts,
        function ($product) use (
            $category,
            $style,
            $tag,
            $brand,
            $search,
            $minPriceValue,
            $maxPriceValue
        ) {

            /*
            |--------------------------------------------------------------------------
            | PRODUCT INFORMATION
            |--------------------------------------------------------------------------
            */

            $productName =
                trim(
                    (string) (
                        $product['name']
                        ?? ''
                    )
                );


            $productDescription =
                trim(
                    (string) (
                        $product['description']
                        ?? ''
                    )
                );


            $productCategory =
                trim(
                    (string) (
                        $product['category']
                        ?? ''
                    )
                );


            $productStyle =
                trim(
                    (string) (
                        $product['style']
                        ?? ''
                    )
                );


            $productBrand =
                getProductBrandName(
                    $product
                );


            $productBrandId =
                getProductBrandId(
                    $product
                );


            $productTags =
                getProductTags(
                    $product
                );


            /*
            |--------------------------------------------------------------------------
            | CATEGORY FILTER
            |--------------------------------------------------------------------------
            */

            if ($category !== '') {

                if (
                    strcasecmp(
                        $productCategory,
                        $category
                    ) !== 0
                ) {

                    return false;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | DRESS STYLE FILTER
            |--------------------------------------------------------------------------
            */

            if ($style !== '') {

                if (
                    strcasecmp(
                        $productStyle,
                        $style
                    ) !== 0
                ) {

                    return false;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | TAG FILTER
            |--------------------------------------------------------------------------
            */

            if ($tag !== '') {

                /*
                 * Special case:
                 *
                 * On Sale
                 *
                 * We do NOT depend only on a "sale"
                 * tag because your database already
                 * contains discount/original_price.
                 */

                if (
                    strcasecmp(
                        $tag,
                        'sale'
                    ) === 0
                ) {

                    if (
                        !isProductOnSale(
                            $product
                        )
                    ) {

                        return false;
                    }

                } else {

                    /*
                     * Normal tag filtering.
                     */

                    $tagFound = false;


                    foreach (
                        $productTags
                        as $productTag
                    ) {

                        if (
                            strcasecmp(
                                (string) $productTag,
                                $tag
                            ) === 0
                        ) {

                            $tagFound = true;

                            break;
                        }
                    }


                    if (!$tagFound) {

                        return false;
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | BRAND FILTER
            |--------------------------------------------------------------------------
            */

            if ($brand !== '') {

                $brandMatches = false;


                /*
                 * Match brand name.
                 */

                if (
                    $productBrand !== '' &&
                    strcasecmp(
                        $productBrand,
                        $brand
                    ) === 0
                ) {

                    $brandMatches = true;
                }


                /*
                 * Match brand ID.
                 */

                if (
                    !$brandMatches &&
                    $productBrandId !== ''
                ) {

                    if (
                        $productBrandId ===
                        (string) $brand
                    ) {

                        $brandMatches = true;
                    }
                }


                if (!$brandMatches) {

                    return false;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            if ($search !== '') {

                /*
                 * Convert tags into searchable text.
                 */

                $tagsText =
                    implode(
                        ' ',
                        array_map(
                            'strval',
                            $productTags
                        )
                    );


                /*
                 * Search across all useful fields.
                 */

                $haystack =
                    strtolower(
                        implode(
                            ' ',
                            [
                                $productName,
                                $productDescription,
                                $productCategory,
                                $productStyle,
                                $productBrand,
                                $tagsText
                            ]
                        )
                    );


                $searchText =
                    strtolower(
                        $search
                    );


                if (
                    strpos(
                        $haystack,
                        $searchText
                    ) === false
                ) {

                    return false;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | PRICE FILTER
            |--------------------------------------------------------------------------
            */

            $productPrice =
                (float) productPrice(
                    $product
                );


            /*
             * Minimum price.
             */

            if (
                $minPriceValue !== null &&
                $productPrice < $minPriceValue
            ) {

                return false;
            }


            /*
             * Maximum price.
             */

            if (
                $maxPriceValue !== null &&
                $productPrice > $maxPriceValue
            ) {

                return false;
            }


            /*
            |--------------------------------------------------------------------------
            | PRODUCT PASSES ALL FILTERS
            |--------------------------------------------------------------------------
            */

            return true;
        }
    )
);


/*
|--------------------------------------------------------------------------
| SORT PRODUCTS
|--------------------------------------------------------------------------
*/

if ($sort === 'price-low') {

    usort(
        $filtered,
        function ($a, $b) {

            return
                productPrice($a)
                <=>
                productPrice($b);
        }
    );
}


elseif ($sort === 'price-high') {

    usort(
        $filtered,
        function ($a, $b) {

            return
                productPrice($b)
                <=>
                productPrice($a);
        }
    );
}


elseif ($sort === 'rating') {

    usort(
        $filtered,
        function ($a, $b) {

            return
                (float) (
                    $b['rating'] ?? 0
                )
                <=>
                (float) (
                    $a['rating'] ?? 0
                );
        }
    );
}


/*
|--------------------------------------------------------------------------
| BUILD FILTER OPTIONS
|--------------------------------------------------------------------------
*/

$categories = [];

$styles = [];

$brands = [];


foreach ($allProducts as $product) {

    /*
     * CATEGORY OPTIONS
     */

    if (
        !empty(
            $product['category']
        )
    ) {

        $categoryName =
            trim(
                (string)
                $product['category']
            );


        if ($categoryName !== '') {

            $categories[
                $categoryName
            ] = true;
        }
    }


    /*
     * STYLE OPTIONS
     */

    if (
        !empty(
            $product['style']
        )
    ) {

        $styleName =
            trim(
                (string)
                $product['style']
            );


        if ($styleName !== '') {

            $styles[
                $styleName
            ] = true;
        }
    }


    /*
     * BRAND OPTIONS
     */

    $brandName =
        getProductBrandName(
            $product
        );


    if ($brandName !== '') {

        $brands[
            $brandName
        ] = true;
    }
}


/*
|--------------------------------------------------------------------------
| SORT FILTER OPTIONS
|--------------------------------------------------------------------------
*/

ksort($categories);

ksort($styles);

ksort($brands);


/*
|--------------------------------------------------------------------------
| CURRENT FILTERS
|--------------------------------------------------------------------------
|
| Used to preserve filters while sorting.
|
*/

$currentFilters = [

    'category' =>
        $category,

    'style' =>
        $style,

    'tag' =>
        $tag,

    'brand' =>
        $brand,

    'search' =>
        $search,

    'min_price' =>
        $minPrice,

    'max_price' =>
        $maxPrice

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


    <!-- SHOP.CO CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body>


<?php require __DIR__ . '/../shared/header.php'; ?>


<main class="category-page">


    <!-- =====================================================
         SHOP HEADER
    ====================================================== -->

    <section class="category-header">

        <div class="container">

            <div class="category-breadcrumb">

                <a href="../index.php">
                    Home
                </a>

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

                <span>
                    Shop
                </span>

            </div>


            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3"
            >


                <!-- PAGE TITLE -->

                <div>

                    <h1>
                        Shop
                    </h1>

                    <p class="mb-0">

                        <?= count($filtered) ?>

                        product<?= count($filtered) === 1 ? '' : 's' ?>

                        found

                    </p>

                </div>


                <!-- =================================================
                     SORT
                ================================================== -->

                <form
                    method="get"
                    class="sort-box"
                >

                    <?php foreach (
                        $currentFilters
                        as $key => $value
                    ): ?>

                        <?php if ($value !== ''): ?>

                            <input
                                type="hidden"
                                name="<?= htmlspecialchars($key) ?>"
                                value="<?= htmlspecialchars($value) ?>"
                            >

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <label
                        for="sort-products"
                    >
                        Sort by:
                    </label>


                    <select
                        id="sort-products"
                        name="sort"
                        class="form-select"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="popular"
                            <?= $sort === 'popular'
                                ? 'selected'
                                : '' ?>
                        >
                            Most Popular
                        </option>


                        <option
                            value="rating"
                            <?= $sort === 'rating'
                                ? 'selected'
                                : '' ?>
                        >
                            Top Rated
                        </option>


                        <option
                            value="price-low"
                            <?= $sort === 'price-low'
                                ? 'selected'
                                : '' ?>
                        >
                            Price: Low to High
                        </option>


                        <option
                            value="price-high"
                            <?= $sort === 'price-high'
                                ? 'selected'
                                : '' ?>
                        >
                            Price: High to Low
                        </option>

                    </select>

                </form>

            </div>

        </div>

    </section>



    <!-- =====================================================
         PRODUCTS SECTION
    ====================================================== -->

    <section class="category-products-section">

        <div class="container">

            <div class="row g-4">


                <!-- =================================================
                     FILTER SIDEBAR
                ================================================== -->

                <aside class="col-12 col-md-3">

                    <div class="filters">


                        <div class="filter-header">

                            <h2 class="mb-0">
                                Filters
                            </h2>

                        </div>


                        <hr>


                        <form method="get">


                            <!-- =================================================
                                 SEARCH
                            ================================================== -->

                            <div class="filter-group">

                                <h3>
                                    Search
                                </h3>


                                <input
                                    type="text"
                                    name="search"
                                    value="<?= htmlspecialchars($search) ?>"
                                    class="form-control"
                                    placeholder="Search products..."
                                >

                            </div>


                            <hr>


                            <!-- =================================================
                                 CATEGORIES
                            ================================================== -->

                            <div class="filter-group">

                                <h3>
                                    Categories
                                </h3>


                                <div class="filter-list">


                                    <label class="d-block mb-2">

                                        <input
                                            type="radio"
                                            name="category"
                                            value=""
                                            <?= $category === ''
                                                ? 'checked'
                                                : '' ?>
                                        >

                                        All

                                    </label>


                                    <?php foreach (
                                        $categories
                                        as $name => $_
                                    ): ?>

                                        <label class="d-block mb-2">

                                            <input
                                                type="radio"
                                                name="category"
                                                value="<?= htmlspecialchars($name) ?>"
                                                <?= strcasecmp(
                                                    $category,
                                                    $name
                                                ) === 0
                                                    ? 'checked'
                                                    : '' ?>
                                            >

                                            <?= htmlspecialchars($name) ?>

                                        </label>

                                    <?php endforeach; ?>

                                </div>

                            </div>


                            <hr>


                            <!-- =================================================
                                 DRESS STYLE
                            ================================================== -->

                            <div class="filter-group">

                                <h3>
                                    Dress Style
                                </h3>


                                <div class="filter-list">


                                    <label class="d-block mb-2">

                                        <input
                                            type="radio"
                                            name="style"
                                            value=""
                                            <?= $style === ''
                                                ? 'checked'
                                                : '' ?>
                                        >

                                        All

                                    </label>


                                    <?php foreach (
                                        $styles
                                        as $name => $_
                                    ): ?>

                                        <label class="d-block mb-2">

                                            <input
                                                type="radio"
                                                name="style"
                                                value="<?= htmlspecialchars($name) ?>"
                                                <?= strcasecmp(
                                                    $style,
                                                    $name
                                                ) === 0
                                                    ? 'checked'
                                                    : '' ?>
                                            >

                                            <?= htmlspecialchars($name) ?>

                                        </label>

                                    <?php endforeach; ?>

                                </div>

                            </div>


                            <hr>


                            <!-- =================================================
                                 BRANDS
                            ================================================== -->

                            <div class="filter-group">

                                <h3>
                                    Brands
                                </h3>


                                <div class="filter-list">


                                    <label class="d-block mb-2">

                                        <input
                                            type="radio"
                                            name="brand"
                                            value=""
                                            <?= $brand === ''
                                                ? 'checked'
                                                : '' ?>
                                        >

                                        All

                                    </label>


                                    <?php foreach (
                                        $brands
                                        as $name => $_
                                    ): ?>

                                        <label class="d-block mb-2">

                                            <input
                                                type="radio"
                                                name="brand"
                                                value="<?= htmlspecialchars($name) ?>"
                                                <?= strcasecmp(
                                                    $brand,
                                                    $name
                                                ) === 0
                                                    ? 'checked'
                                                    : '' ?>
                                            >

                                            <?= htmlspecialchars($name) ?>

                                        </label>

                                    <?php endforeach; ?>

                                </div>

                            </div>


                            <hr>


                            <!-- =================================================
                                 PRICE
                            ================================================== -->

                            <div class="filter-group">

                                <h3>
                                    Price
                                </h3>


                                <div class="row g-2">


                                    <!-- MIN -->

                                    <div class="col-6">

                                        <label
                                            for="min-price"
                                            class="form-label"
                                        >
                                            Min
                                        </label>


                                        <input
                                            type="number"
                                            id="min-price"
                                            name="min_price"
                                            class="form-control"
                                            min="0"
                                            step="0.01"
                                            value="<?= htmlspecialchars($minPrice) ?>"
                                            placeholder="$0"
                                        >

                                    </div>


                                    <!-- MAX -->

                                    <div class="col-6">

                                        <label
                                            for="max-price"
                                            class="form-label"
                                        >
                                            Max
                                        </label>


                                        <input
                                            type="number"
                                            id="max-price"
                                            name="max_price"
                                            class="form-control"
                                            min="0"
                                            step="0.01"
                                            value="<?= htmlspecialchars($maxPrice) ?>"
                                            placeholder="$1000"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- =================================================
                                 KEEP TAG
                            ================================================== -->

                            <?php if ($tag !== ''): ?>

                                <input
                                    type="hidden"
                                    name="tag"
                                    value="<?= htmlspecialchars($tag) ?>"
                                >

                            <?php endif; ?>


                            <!-- =================================================
                                 APPLY
                            ================================================== -->

                            <button
                                type="submit"
                                class="btn btn-dark w-100 mt-3"
                            >
                                Apply Filter
                            </button>


                            <!-- =================================================
                                 CLEAR
                            ================================================== -->

                            <a
                                href="products.php"
                                class="btn btn-outline-dark w-100 mt-2"
                            >
                                Clear Filters
                            </a>

                        </form>

                    </div>

                </aside>



                <!-- =================================================
                     PRODUCT GRID
                ================================================== -->

                <div class="col-12 col-md-9">

                    <div
                        class="row row-cols-2 row-cols-lg-3 g-4"
                    >


                        <!-- =================================================
                             NO RESULTS
                        ================================================== -->

                        <?php if (!$filtered): ?>

                            <div class="col-12">

                                <div
                                    class="alert alert-light border"
                                >

                                    <h3 class="mb-2">
                                        No products found
                                    </h3>

                                    <p class="mb-0">
                                        Try changing your search
                                        or filters.
                                    </p>

                                </div>

                            </div>

                        <?php endif; ?>



                        <!-- =================================================
                             PRODUCTS
                        ================================================== -->

                        <?php foreach (
                            $filtered
                            as $product
                        ): ?>

                            <div class="col">

                                <article
                                    class="product-card h-100"
                                >

                                    <a
                                        href="product-details.php?id=<?= urlencode($product['id']) ?>"
                                        class="text-decoration-none text-reset"
                                    >


                                        <!-- PRODUCT IMAGE -->

                                        <img
                                            src="../<?= htmlspecialchars(
                                                productImage($product)
                                            ) ?>"
                                            class="img-fluid"
                                            alt="<?= htmlspecialchars(
                                                $product['name']
                                            ) ?>"
                                        >


                                        <!-- PRODUCT NAME -->

                                        <h3>

                                            <?= htmlspecialchars(
                                                $product['name']
                                            ) ?>

                                        </h3>


                                        <!-- RATING -->

                                        <div
                                            class="product-rating"
                                        >

                                            <?= htmlspecialchars(
                                                (string) (
                                                    $product['rating']
                                                    ?? 0
                                                )
                                            ) ?>/5

                                        </div>


                                        <!-- CURRENT PRICE -->

                                        <strong>

                                            $<?= number_format(
                                                productPrice($product),
                                                2
                                            ) ?>

                                        </strong>


                                        <!-- ORIGINAL PRICE -->

                                        <?php

                                        $originalPrice =
                                            productOriginalPrice(
                                                $product
                                            );

                                        ?>


                                        <?php if (
                                            $originalPrice !== null &&
                                            $originalPrice >
                                            productPrice($product)
                                        ): ?>

                                            <del class="ms-2">

                                                $<?= number_format(
                                                    $originalPrice,
                                                    2
                                                ) ?>

                                            </del>

                                        <?php endif; ?>


                                    </a>

                                </article>

                            </div>

                        <?php endforeach; ?>


                    </div>

                </div>

            </div>

        </div>

    </section>


</main>


<?php require __DIR__ . '/../shared/footer.php'; ?>


</body>

</html>