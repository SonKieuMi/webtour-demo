<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Travel VN</title>
    <link rel="stylesheet" href="fonts/themify-icons/themify-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>
    <!-- Header -->
    <div class="head" style="position: fixed; top: 0px; bottom: auto; left: 0px; width: 100%; z-index: 10;">
        <!-- Top-header -->
        <div class="top-header">
            <div class="wrap">
                <div class="top-header-left">
                    <div class="support-phone">
                        <span class="hotline">Hotline:</span>
                        <span class="num">1900 1006</span>
                    </div>
                </div>
                <div class="top-header-right">
                    <ul>
                        <li><a href="login.php" class="btn-login-hd">Đăng Nhập</a></li>
                        <li><a href="signup.php" class="btn-signup-hd">Đăng Ký</a></li>
                        <!-- <li>
                            <input type="text" class="search-txt" placeholder="Tour du lịch, Điểm đến..." />
                            <img src="assets/img/i-search-mini.png" />
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- End-Top-header -->

        <div class="header">
            <div class="wrap">
                <!-- Start-logo -->
                <div class="logo">
                    <a href="home.php"><img src="assets/img/MNV.png" title="MNV" /></a>
                </div>
                <!-- End-logo -->

                <!-- Start-Header -->
                <div class="header-nav">
                    <ul class="flexy-menu thick orange">
                        <li class="<?php if ($page == 'home') {
                                        echo 'active';
                                    } ?>"><a href="home.php">Trang chủ</a></li>
                        <li class="<?php if ($page == 'danhsachtour') {
                                        echo 'active';
                                    } ?>"><a href="danhsachtour.php">Danh sách Tour</a>
                        <li class="<?php if ($page == 'news_tour') {
                                        echo 'active';
                                    } ?>"><a href="news_tour.php">Tin tức du lịch</a></li>
                        <li class="<?php if ($page == 'contact') {
                                        echo 'active';
                                    } ?>"><a href="contact.php">Liên Hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End-Head -->