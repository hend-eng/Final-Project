<?php
/*
 * Sidebar used by all dashboard pages.
 * The absolute project path prevents broken links when this file
 * is included from categories/, brands/, products/, etc.
 */

$dashboardBase = '/allprojects/Final-Project/dasboard';

$currentFile = basename($_SERVER['PHP_SELF']);
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));

function sidebarActive(string $section, string $currentFile, string $currentFolder): string
{
    if ($section === 'dashboard') {
        return ($currentFile === 'index.php' && $currentFolder === 'dasboard')
            ? 'active'
            : '';
    }

    return $currentFolder === $section ? 'active' : '';
}
?>

<link rel="stylesheet"
        href="/allprojects/Final-Project/assets/css/sidebar.css">

<aside class="sidebar">

    <div class="logo">
        <h2>Admin</h2>
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="<?= $dashboardBase ?>/index.php"
               class="<?= sidebarActive('dashboard', $currentFile, $currentFolder) ?>">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="<?= $dashboardBase ?>/categories/index.php"
               class="<?= sidebarActive('categories', $currentFile, $currentFolder) ?>">
                <span>📁</span>
                <span>Categories</span>
            </a>
        </li>

        <li>
            <a href="<?= $dashboardBase ?>/brands/index.php"
               class="<?= sidebarActive('brands', $currentFile, $currentFolder) ?>">
                <span>🏷️</span>
                <span>Brands</span>
            </a>
        </li>

        <li>
            <a href="<?= $dashboardBase ?>/products/index.php"
               class="<?= sidebarActive('products', $currentFile, $currentFolder) ?>">
                <span>📦 </span>
                <span> Products</span>
            </a>
        </li>

        <!-- These pages do not currently exist in the uploaded project. -->
        <li>
            <a href="../teampage.html" title="Team page not created yet">
                <span>👥 </span>
                <span>Team</span>
            </a>
        </li>

       
        <li>
            <a href="#" onclick="return false;" title="Orders page not created yet">
                <span>🛒</span>
                <span>Orders</span>
            </a>
        </li>

        <li>
            <a href="#" onclick="return false;" title="Clients page not created yet">
                <span>👤</span>
                <span>Clients</span>
            </a>
        </li>


    </ul>

    <div class="logout">
       <a href="/allprojects/Final-Project/auth/logout.php">
            <span>🚪</span>
            <span>Logout</span>
        </a>
    </div>

</aside>