<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Travel VN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php
    require "bootstrap.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body style="background-color: rgb(247, 247, 247);">
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
                        <li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="assets/img/avatar.png" class="avatar-user" />
                                    <span class="name_user"><?php if (isset($_SESSION["tendangnhap"])) {
                                                                $username =  $_SESSION["tendangnhap"];
                                                            }
                                                            echo $username; ?>
                                    </span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="manage_info.php">Tài Khoản Của Tôi</a>
                                    <a class="dropdown-item" href="order-all.php">Đơn Mua</a>
                                    <div class="dropdown-divider"></div>
                                    <a class='dropdown-item' href='logout.php'>Đăng xuất</a>
                                </div>
                            </div>
                        </li>
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