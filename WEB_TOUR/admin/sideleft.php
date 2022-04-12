<html lang="en">

<head>
    <title>DashBoard | Quản Lý Tin Tức</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/1e104ff2e1.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_dashboard/style-rtl.css">
</head>

<body class="section-bg" data-new-gr-c-s-check-loaded="14.1005.0" data-gr-ext-installed="" style="padding-top: 0px;">
    <div class="sidebar-nav">
        <div class="sidebar-nav-body">
            <div class="sidebar-menu-wrap">
                <ul class="sidebar-menu list-items">
                    <li class="<?php if($page=='quanlytour'){echo 'page-active';} ?>"><a href="quanlytour.php">Quản Lý Tour</a></li>
                    <li class="<?php if($page=='quanlytintuc'){echo 'page-active';} ?>"><a href="quanlytintuc.php">Quản Lý Tin Tức</a></li>
                    <li class="<?php if($page=='list-booking-tour'){echo 'page-active';} ?>"><a href="list-booking-tour.php">Quản Lý Đặt Tour</a></li>
                    <li class="<?php if($page=='duyet-comment'){echo 'page-active';} ?>"><a href="duyetcomment.php">Quản Lý Duyệt Comment</a></li>
                    <li><a href="logout.php">Đăng Xuất</a></li>
                </ul>
            </div><!-- end sidebar-menu-wrap -->
        </div>
    </div>
    