<?php session_start();require_once "../config/config.php" ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.2/css/all.css?fbclid=IwAR2Lefv1ZTLJsKEsnl4HGMf5XRZuPqx5yOFnFaOFbVgCiCeU87S0up6ptKU">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- ICON FONTAWESOME CDN -->
    <link href="https://site-assets.fontawesome.com/releases/v6.1.2/css/all.css?fbclid=IwAR2Lefv1ZTLJsKEsnl4HGMf5XRZuPqx5yOFnFaOFbVgCiCeU87S0up6ptKU"  rel="stylesheet" type="text/css"/>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion navbar-left" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-regular fa-leaf" style="color: #ffffff;"></i>
                </div>
                <div class="sidebar-brand-text mx-3">OGANI</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <span>Trang chủ</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Thông tin
            </div>
            <li class="nav-item">
                <a class="nav-link" href="./product.php">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>
            <?php
                if($_SESSION['idRole'] == 1){
                    ?>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="employee.php">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>Nhân viên</span>
                            </a>
                        </li>
                    <?php
                }
            ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="customer.php" >
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Khách hàng</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Đơn hàng
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="storage.php" 
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Kho</span>
                </a>
            </li>
        </ul>