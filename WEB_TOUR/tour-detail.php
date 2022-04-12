<?php
session_start();
$page = 'danhsachtour';
require "includes/contentHandler.php";

if (isset($_SESSION['tendangnhap'])) {
    if (isset($_SESSION['userrole']) && $_SESSION['userrole'] == "ROLE_USER") {
        require "includes/header-logined.php";
    } else {
        header("Location: admin/quanlytour.php");
    }
} else {
    require_once "includes/header.php";
}
?>
<?php
$cth = new contentHandler();
$id = htmlspecialchars($_GET["id"]);
$result = $cth->tourDetail($id);
$row =  $result->fetch_assoc();
$quantity_ticket = $row["quantity_tickets"];
$_SESSION['id_tour'] = $row["id_tour"];
?>
<!-- Start-Content-->
<div class="main-container">
    <div class="main-banner-detail">
        <div class="slideshow-container">
            <div class="mySlides">
                <img src="<?php echo $row['image']; ?>" style="width:100%">
            </div>
        </div>
    </div>
    <!-- Start-Content-detail -->
    <div class="content-detail">
        <div class="main-info">
            <div class="header-info">
                <span>
                    <h1 class="title-tour-detail"><?php echo  $row['name_tour']; ?></h1>
                </span>
                <div class="markdown-container">
                    <!---->
                    <div class="activity-markdown markdown-content">
                        <p class="description-tour-detail"><?php echo $row['description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="page-activity-package-options">
                <div class="page-activity-section-title" style="margin-top:0px;">
                    <h2 class="activity-section-title">
                        Các gói dịch vụ
                    </h2>
                </div>
                <!---->
                <form action="<?php echo "book-tour.php?id="  . ($row['id_tour']) ?>" method="POST">
                    <div class="activity-package-options">
                        <div class="package-options-content">
                            <p class="package-options-content-title">Số lượng</p>
                            <div class="booking-options-units-tips">
                                <span class="booking-options-units-tips_content">Bạn phải chọn
                                    <span class="min_pax">1</span> hoặc nhiều hơn để tiếp tục
                                </span>
                            </div>
                            <div class="package-detail-counter order-item">
                                <div class="package-detail-top">
                                    <div class="counter-left">
                                        Số người
                                        <!---->
                                        <!---->
                                    </div>
                                    <div class="counter-right">
                                        <!---->
                                        <div class="activity-counter">
                                            <input class="is-form minus" onclick="decrement()" type='button' value='-' />
                                            <input class="input-qty" id='quantity' min='1' name='quantity' type='text' value='1' />
                                            <input class="is-form plus" onclick="increment(<?php echo $quantity_ticket; ?>)" type='button' value='+' />
                                        </div>
                                        <script>
                                            var result = document.getElementById('quantity');

                                            function increment(quantity) {
                                                var value = result.value;
                                                if (value >= quantity) {
                                                    alert('Số lượng vé không đủ! Vui lòng kiểm tra lại!');
                                                } else {
                                                    document.getElementById('book').disabled = false;
                                                    result.value++;
                                                }
                                            }

                                            function decrement() {
                                                var value = result.value;
                                                document.getElementById('book').disabled = false;
                                                if (value > 1) {
                                                    result.value--;
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                                <!---->
                            </div>
                        </div>
                        <div class="package-options-btnGroup options-btn">
                            <div class="options-btnGroup-left">
                                <!---->
                                <p>
                                    <span class="preview-price-type">Giá vé: </span>
                                    <span class="preview-sell-price"><?php echo number_format($row['price']); ?> VND</span>
                                </p>
                                <p class="attr-tip">Vui lòng hoàn tất các mục yêu cầu để chuyển đến
                                    bước tiếp theo</p>
                            </div>

                            <div class="options-btnGroup-right">
                                <div class="in-house-btn">
                                    <?php
                                    if (isset($_SESSION['tendangnhap'])) {
                                        if ($quantity_ticket == 0) {
                                            echo '<button type="submit" href="" class="order-tour klk-button klk-button-large" disabled>
                                                    <span>Đặt Ngay</span>
                                                    </button>';
                                        } else {
                                            echo '<button type="submit" id="book" href="" class="order-tour klk-button klk-button-large">
                                                    <span>Đặt Ngay</span>
                                                    </button>';
                                        }
                                    } else {
                                        echo '<a href="login.php" class="order-tour klk-button klk-button-large">
                                                    <span>Đặt Ngay</span>
                                                    </a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!---->
            </div>
            <div class="page-activity-reviews">
                <div class="page-activity-section-title" style="margin-top: 40px;">
                    <h2 class="js-desktop-activity-section-title activity-section-title">Đánh giá</h2>
                </div>
                <div class="page-activity-reviews-total-score">
                    <?php
                    $avgRating = $cth->avgReview($id);
                    $avg = mysqli_fetch_array($avgRating);
                    if ($avg['AVGRating'] <= 0) {
                        echo '<span class="score">0.0</span>';
                    } else {
                        echo '<span class="score">' .  $avg['AVGRating'] . '</span>';
                    }
                    ?>

                    <div class="rating">
                        <i class="fa fa-star"></i>
                    </div>
                    <?php
                    $amtReview = $cth->amountReview($id);
                    $amt = mysqli_num_rows($amtReview);
                    if ($amt <= 0) {
                        echo '<span class="reviews-number">Chưa có đánh giá</span>';
                    } else {
                        echo '<span class="reviews-number">' . $amt . ' Đánh giá</span>';
                    }
                    ?>

                </div>
                <?php
                $id = htmlspecialchars($_GET["id"]);
                $page = 1;
                if (!isset($_GET["page"])) {
                    $_GET["page"] = 1;
                }
                $page = htmlspecialchars($_GET["page"]);
                $pagingResult = $cth->reviewPaging($id, '', $page);
                ?>
                <?php
                $review = $cth->loadReview($id, $page);
                foreach ($review as $row) {
                    echo '<div class="zone-comment-tabs" id="commentcontainer">
                            <div class="tab-content">
                                <div class="usercomment" rel="">
                                    <div class="primary-comment">
                                        <figure class="ava">
                                            <img alt="' . $row['full_name'] . '" class="loaded" src="assets/img/avatar.png">
                                        </figure>
                                        <div class="data">
                                            <div class="user_id">
                                                <h4>' . $row['full_name'] . '<h4>
                                            </div>';
                    if ($row['rating'] == 5) {
                        echo '<div class="user_rating">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <span class="level_rating">Rất hài lòng</span>
                                            </div>';
                    }
                    if ($row['rating'] == 4) {
                        echo '<div class="user_rating">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <span class="level_rating">Hài lòng</span>
                                            </div>';
                    }
                    if ($row['rating'] == 3) {
                        echo '<div class="user_rating">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <span class="level_rating">Bình thường</span>
                                            </div>';
                    }
                    if ($row['rating'] == 2) {
                        echo '<div class="user_rating">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <span class="level_rating">Không hài lòng</span>
                                            </div>';
                    }
                    if ($row['rating'] == 1) {
                        echo '<div class="user_rating">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <span class="level_rating">Rất không hài lòng</span>
                                            </div>';
                    }
                    echo '<div class="comment">' . $row['review'] . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                echo $pagingResult;
                ?>
            </div>
        </div>
    </div>
    <!-- Start-Tour-bonus -->
    <div class="col-xs-12 tour-similar">
        <div class="row">
            <div class="col-xs-12 mg-bot20">
                <div class="title-ft">Các tour ngẫu nhiên</div>
            </div>
            <div id="theogia">
            </div>
            <div id="ngaykhoihanh">
                <?php
                $cth = new contentHandler();
                $result = $cth->tourRandom();
                while ($row = $result->fetch_array()) {
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mg-bot30">
                        <a href="tour-detail.php?id=' .  ($row['id_tour']) . '"
                            title="' . ($row['name_tour']) . '">
                            <div class="pos-relative">
                                <img src="' . ($row['image']) . '" class="img-responsive pic-ttt" alt="' . ($row['name_tour']) . '">
                                <div class="frame-ttt1">
                                    <div class="f-left">
                                        <img src="assets/img/i-date-w.png" alt="date">
                                    </div>
                                    <div class="f-left date">
                                        <span class="yellow">' . ($row['start']) . '</span> -
                                        <span class="yellow">' . ($row['num_days']) . ' ngày</span>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </a>
                        <div class="frame-ttt2">
                            <a href="tour-detail.php?id=' .  ($row['id_tour']) . '"
                                title="' . ($row['name_tour']) . '">
                                <div class="ttt-title dot-dot cut-ttt">' . substr(($row['name_tour']), 0, 30) . ' ... </div>
                            </a>
                            <div class="ttt-line"></div>
                            <div>
                                <img src="assets/img/i-price.png" class="f-left" alt="price">
                                <div class="f-left ttt-info">
                                    <span class="price-n">' . number_format($row['price']) . ' VND</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>';
                }
                $result->free();
                ?>
            </div>
        </div>
    </div>
    <!-- end-Tour-bonus -->
</div>
<!-- Start-Content-detail -->
</div>
</div>
<!-- End-Content -->

<?php
require_once "includes/footer.php";
?>