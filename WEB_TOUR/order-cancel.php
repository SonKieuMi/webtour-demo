<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
{
    require "includes/header-logined.php";
}
else{
   header ("Location: admin/quanlytour.php");
}
require "includes/contentHandler.php";
require "includes/userHandler.php";
?>
<?php
$cth = new contentHandler();
if(isset($_SESSION["id_user"])){
    $userid = $_SESSION["id_user"];
}
$uhd = new userHandler();
$result = $uhd->userAccount($userid);
$row = $result->fetch_assoc();
?>

    <div id="app">
        <section class="g_main margin-top-0">
            <ul class="sidebar g_left j_side_menu">
                <li>
                    <div class="profile_box g_rel">
                        <div class="profile_avatar">
                            <label for="avatar">
                                <span class="klook-symbol t28 g_v_c_mid camera"><i class="fa-camera"
                                        aria-hidden="true"></i></span>
                            </label>
                            <input type="file" name="avatar" id="avatar" class="f_hidden"
                                accept="image/png, image/jpg, image/jpeg">
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
                            <a href="order-all .php">
                                <span class="active-profile">Đơn hàng</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="user_center-content g_rel g_right">
                <div class="bookings-container">
                    <div class="booking-list">
                        <a class="booking-item" href="order-all.php"><span class="booking-label">Tất cả</span></a>
                        <a class="booking-item" href="order-wait.php"><span class="booking-label">Chờ xác nhận</span></a>
                        <a class="booking-item" href="ordered.php"><span class="booking-label">Đã thanh toán</span></a>
                        <a class="booking-item booking-active" href="order-cancel.php"><span class="booking-label">Đã Hủy</span></a>
                    </div>
                </div>
                <div class="booking-tour-list">
                    <?php                   
                    $list = $cth->loadBookTourCancel($userid);
                    foreach ($list as $book ) {
                    echo '<div>
                    <div class="col-sm-12 item-booking-tour">
                            <div class="item mg-bot30">
                                <div class="row">
                                    <div class="container-name">
                                        <div class="booking-tour-name">
                                            <a href="tour-detail.php?id=' .$book['id_tour']. '"
                                                title="' .$book['name_tour']. '">
                                                <h3>' .$book['name_tour']. '</h3>
                                            </a>
                                            <div class="booking-status">Đã Hủy</div>
                                        </div>
                                        <div class="order__id-tour">Mã đơn hàng: <span>'. $book['order_id'] .'</span></div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 item-img">
                                        <div class="pos-relative">
                                            <a href="tour-detail.php?id=' .$book['id_tour']. '"
                                                title="' .$book['name_tour']. '"><img
                                                    src="' .$book['image']. '"
                                                    class="img-responsive pic-lt"
                                                    alt="' .$book['name_tour']. '"></a>
                                        </div>
                                    </div>
                                    <div class="info-items">
                                        <div class="frame-info pos-relative">
                                            <div class="row">
                                                <div class="info-booking-left mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-date.png" alt="date">
                                                    </div>
                                                    <div class="f-left r">Ngày đi: <span
                                                            class="font500">' .$book['start']. '</span></div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-chair.png" alt="chair">
                                                    </div>
                                                    <div class="f-left r">
                                                        Phương tiện: <span class="font500">' .$book['name_vehicle']. '</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="info-booking-left mg-bot10">
                                                    <div class="f-left l"><img src="assets/img/i-price.png" alt="price">
                                                    </div>
                                                    <div class="f-left r">
                                                        Giá:
                                                        <span class="font500 price">' .number_format($book['price']). ' đ</span>
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
                                    <div class="total-money total-type-price total-quantity">' .$book['quantity_people']. '</div>
                                </div>
                                <div class="total-type-money">
                                    <div class="name-type">Tổng số tiền:</div>
                                    <div class="total-money total-type-price">' .number_format($book['total']). ' đ</div>
                                </div>
                                                                                                                          
                        </div>
                        </div>                 
                        </div>';                  
                    }
                    ?>                  
                </div>
            </div>           
        </section>
    </div>

<?php
require_once "includes/footer.php"
?>