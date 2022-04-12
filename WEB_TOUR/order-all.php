<?php
session_start();

if (isset($_SESSION['userrole']) && $_SESSION['userrole'] == "ROLE_USER") {
    require "includes/header-logined.php";
} else {
    header("Location: admin/quanlytour.php");
}
require "includes/contentHandler.php";
require "includes/userHandler.php";
?>
<?php
$userid = 0;
$cth = new contentHandler();
if (isset($_SESSION["id_user"])) {
    $userid = $_SESSION["id_user"];
}
$uhd = new userHandler();
$result = $uhd->userAccount($userid);
$row = $result->fetch_assoc();
?>
<?php
if (isset($_POST['cancel'])) {
    $id = $_POST['bill-id'];
    $change = $cth->changeStatus($id);
    if ($change) {
        echo ("<script>alert('Hủy thành công!');
				location.href = 'order-all.php';
			</script>");
    } else {
        echo ("<script>alert('Hủy thất bại!');</script>");
    }
}

?>

<!-- Start-Content-->
<div id="app">
    <section class="g_main margin-top-0">
        <!-- Start-Side-Left -->
        <ul class="sidebar g_left j_side_menu">
            <li>
                <div class="profile_box g_rel">
                    <div class="profile_avatar">
                        <label for="avatar">
                            <span class="klook-symbol t28 g_v_c_mid camera"><i class="fa-camera" aria-hidden="true"></i></span>
                        </label>
                        <input type="file" name="avatar" id="avatar" class="f_hidden" accept="image/png, image/jpg, image/jpeg">
                        <img width="100" height="100" class="avatar_url" src="assets/img/avatar.png" alt="">
                        <div class="profile-loading f_hidden"><i></i></div>
                    </div>
                    <h3><?php echo $row['full_name'] ?></h3>
                </div>
                <div class="entrances_box">
                    <div class="entrances_box_hover">
                        <a href="manage_info.php">
                            <span>Quản lý thông tin</span>
                        </a>
                    </div>
                    <div class="entrances_box_hover">
                        <a href="order-all.php">
                            <span class="active-profile">Đơn hàng</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
        <!-- End-Side-Left -->

        <!-- Start-Booking-List-Tour -->
        <div class="user_center-content g_rel g_right">

            <!-- Start-Side-Bar-Top-->
            <div class="bookings-container">
                <div class="booking-list">
                    <a class="booking-item booking-active" href="order-all.php"><span class="booking-label">Tất
                            cả</span></a>
                    <a class="booking-item" href="order-wait.php"><span class="booking-label">Chờ xác
                            nhận</span></a>
                    <a class="booking-item" href="ordered.php"><span class="booking-label">Đã xác nhận</span></a>
                    <a class="booking-item" href="order-cancel.php"><span class="booking-label">Đã Hủy</span></a>
                </div>
            </div>
            <!-- End-Side-Bar-Top-->

            <!-- Start-List-Booking-->
            <div class="booking-tour-list">
                <?php
                $list = $cth->loadBookTourAll($userid);
                foreach ($list as $book) {
                    echo "<div>";
                    echo '<div class="col-sm-12 item-booking-tour">
                            <div class="item mg-bot30">
                                <div class="row">
                                    <div class="container-name">
                                        <div class="booking-tour-name">
                                            <a href="tour-detail.php?id=' . $book['id_tour'] . '"
                                                title="' . $book['name_tour'] . '">
                                                <h3>' . $book['name_tour'] . '</h3>
                                            </a>';
                    if ($book['status']  == 1) {
                        echo '<div class="booking-status">Đang chờ xác nhận</div>';
                    }
                    if ($book['status']  == 2) {
                        echo '<div class="booking-status">Đã xác nhận</div>';
                    }
                    if ($book['status']  == 0) {
                        echo '<div class="booking-status">Đã Hủy</div>';
                    }
                    if ($book['status']  == 3) {
                        echo '<div class="booking-status">Đã hoàn thành tour</div>';
                    }
                    if ($book['status']  == 4) {
                        echo '<div class="booking-status">Đã đánh giá</div>';
                    }
                    echo '</div>
                                    <div class="order__id-tour">Mã đơn hàng: <span>' . $book['order_id'] . '</span></div>
                                    </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 item-img">
                                        <div class="pos-relative">
                                            <a href="tour-detail.php?id=' . $book['id_tour'] . '"
                                                title="' . $book['name_tour'] . '"><img
                                                    src="' . $book['image'] . '"
                                                    class="img-responsive pic-lt"
                                                    alt="' . $book['name_tour'] . '"></a>
                                        </div>
                                    </div>
                                    <div class="info-items">
                                        <div class="frame-info pos-relative">
                                            <div class="row">
                                                <div class="info-booking-left mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-date.png" alt="date">
                                                    </div>
                                                    <div class="f-left r">Ngày đi: <span
                                                            class="font500">' . $book['start'] . '</span></div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-chair.png" alt="chair">
                                                    </div>
                                                    <div class="f-left r">
                                                        Phương tiện: <span class="font500">' . $book['name_vehicle'] . '</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="info-booking-left mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-price.png" alt="price">
                                                    </div>
                                                    <div class="f-left r">
                                                        Giá:
                                                        <span class="font500 price">' . number_format($book['price']) . ' VND</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div> 
                                                <div class="mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-calendar.png" alt="date"></div>
                                                        <div class="f-left r">Số ngày:
                                                            <span class="font500">' . $book['num_days'] . '</span></div>
                                                    <div class="clear"></div>
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="area-bot">
                                <div class="bot-booking bot1"> </div>
                                <div class="bot-booking bot2"> </div>
                            </div>                                                       
                            <div class="type-money">
                                <div class="total-type-money quantity_people">
                                    <div class="name-type">Số người:</div>
                                    <div class="total-money total-type-price total-quantity">' . $book['quantity_people'] . '</div>
                                </div>
                                <div class="total-type-money">
                                    <div class="name-type">Tổng số tiền:</div>
                                    <div class="total-money total-type-price">' . number_format($book['total']) . ' VND</div>
                                </div>';
                    if ($book['status']  == 1) {
                        echo '<form action="order-all.php?id=' . $book['id'] . '" method="POST">
                                    <div class="cancel-booking-tour">
                                        <div class="button-cancel-booking">
                                        <input type="hidden" name="bill-id" value="' . $book['id'] . '" />
                                            <button type="submit" class="btn-cancel-booking" name="cancel">Hủy Tour</button>
                                        </div>
                                    </div>
                                    </form>';
                    }
                    if ($book['status']  == 3) {
                        if (isset($_POST['btn__rating'])) {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $id = $_POST['bill-id'];
                            $tourId = $book['id_tour'];
                            $rating = $_POST['rating'];
                            $date = date("Y-m-d H:i:s");
                            $review = $_POST['rating__cmt'];
                            $cmtReview = $cth->insertReview($userid, $tourId, $review, $rating, $date);
                            $changeReview = $cth->changeStatusReview($id);
                            if ($changeReview) {
                                echo ("<script>alert('Đánh giá tour thành công!');
                                                    location.href = 'order-all.php';
                                                </script>");
                            }
                        }
                        echo '<div class="cancel-booking-tour">
                                        <div class="button-cancel-booking">
                                            <button type="submit" class="btn-cancel-booking" id="btn-rating">Đánh Giá Tour</button>
                                            <div class="rating__tour">
                                                <span class="close-rating"><i class="fa fa-times"></i></i></span>
                                                <form action="order-all.php" method="POST">
                                                    <div class="rating__title">
                                                        <h2>Đánh Giá Tour</h2>
                                                    </div>
                                                    <div class="area__rating">
                                                        <div class="form__rating">
                                                            <div class="info__tour">
                                                                <input type="hidden" name="bill-id" value="' . $book['id'] . '" />
                                                                <a href="tour-detail.php?id=' . $book['id_tour'] . '" class="link__tour" target="_blank">
                                                                    <div class="content__tour">
                                                                        <img src="' . $book['image'] . '" alt="' . $book['image'] . '">
                                                                        <div class="content__info-tour">
                                                                            <p>' . $book['name_tour'] . '</p>
                                                                            <div id="rating">
                                                                                <input type="radio" id="star5" name="rating" value="5" />
                                                                                <label class="full" for="star5" title="Awesome - 5 stars"></label>

                                                                                <input type="radio" id="star4" name="rating" value="4" />
                                                                                <label class="full" for="star4" title="Pretty good - 4 stars"></label>

                                                                                <input type="radio" id="star3" name="rating" value="3" />
                                                                                <label class="full" for="star3" title="Meh - 3 stars"></label>

                                                                                <input type="radio" id="star2" name="rating" value="2" />
                                                                                <label class="full" for="star2" title="Kinda bad - 2 stars"></label>

                                                                                <input type="radio" id="star1" name="rating" value="1" />
                                                                                <label class="full" for="star1" title="Sucks big time - 1 star"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="zone-rating-area">
                                                                <div class="comment-rating">
                                                                    <textarea class="form-control" placeholder="Ý kiến đánh giá của bạn?" name="rating__cmt"></textarea>                              
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                     
                                                    <div class="btn__rating-tour">
                                                        <button class="btn__rating" name="btn__rating">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="rating-overlay"></div>
                                        </div>
                                    </div>';
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
            <!-- End-List-Booking-->
        </div>
        <!-- End-Booking-List-Tour -->
    </section>
</div>
<!-- End-Content-->
<script>
    var btn = document.getElementById('btn-rating');
    var box = document.querySelector('.rating__tour');
    var bg = document.querySelector('.rating-overlay');
    var close = document.querySelector('.close-rating');

    btn.addEventListener('click', function() {
        box.classList.add('open__box');
        bg.classList.add('open__background');
    })

    bg.addEventListener('click', function() {
        bg.classList.remove('open__background');
        box.classList.remove('open__box');
    })

    close.addEventListener('click', function() {
        box.classList.remove('open__box');
        bg.classList.remove('open__background');
    })
</script>
<?php
require "includes/footer.php"
?>