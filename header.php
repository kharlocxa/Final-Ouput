<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Northwind Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="<?php echo HOSTURL; ?>/assets/img/favicon.png" rel="icon">
    <link href="<?php echo HOSTURL; ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="<?php echo HOSTURL; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo HOSTURL; ?>/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="<?php echo HOSTURL; ?>/assets/css/style.css" rel="stylesheet">

    <script src="<?php echo HOSTURL; ?>/assets/js/jquery.min.js"></script>
</head>

<body>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="<?php echo HOSTURL; ?>/index.php" class="logo d-flex align-items-center">
            <img src="<?php echo HOSTURL; ?>/assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Northwind</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#" id="searchForm">
                <input type="text" name="search" placeholder="Search content" title="Enter search keyword" id="searchInput">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?php echo HOSTURL; ?>/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>Admin User</h6>
                        <span>Manager</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header><aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo HOSTURL; ?>/index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Management</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo HOSTURL; ?>/pages/customer.php">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo HOSTURL; ?>/pages/product.php">
                <i class="bi bi-box-seam"></i>
                <span>Products</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo HOSTURL; ?>/pages/orders.php">
                <i class="bi bi-cart"></i>
                <span>Orders</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo HOSTURL; ?>/pages/report.php">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Reports</span>
            </a>
        </li>

    </ul>
</aside><main id="main" class="main">