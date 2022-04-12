<?php
session_start();
$page = 'home';
require "includes/contentHandler.php";
if(isset( $_SESSION['tendangnhap'])) 
{
    if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
    {
        require "includes/header-logined.php";
    }
    else{
       header ("Location: admin/quanlytour.php");
    }
}
else{
   require "includes/header.php";
}
?>
<?php
if ( isset($_GET["p"]) )
    $p = $_GET["p"];
else
    $p = "";
?>
<?php
switch($p){
    case "search" : require "search-tour.php"; break;
    default;
?>
<?php 
//cth là biến để gọi class contenthandle của file contenthandle.php
$cth = new contentHandler();
// if (isset($_GET["searchbutton"])) {
//     $search =  addslashes($_GET["search"]);  
//     $result = $cth->getSearchTour($search); 
// }
?>
<!-- Start-slide-show -->
<div class="slide">
        <?php     
        //$result là biến đủ để trỏ tới 1 hàm trong class contenHandler
        $result = $cth->imageHome();
        //fetch_array là nó trả về kết quả của câu truy vấn trong my SQL dưới dạng mảng 
        while ($row = $result->fetch_array()) {
            // row là biến  chứa kq trả về của câu truy vấn
		echo '<div class="chuyen-slide">
			<img src="' . ($row['image']) . '"> 
		</div>';
        }
        ?>
        <div class="main-banner-title">
            <h1>TỰ DO KHÁM PHÁ </h1>
            <h2>Khám phá và đặt các hoạt động du lịch đặc sắc với giá độc quyền </h2>
            <div>
                <div class="banner-search">
                    <form method="get" action="">
                    <input type="text" placeholder="Tour du lịch, Điểm đến..." class="banner-txt-search" name="q" />
                    <button type="submit" class="banner-btn">Tìm Kiếm</button>
                    <input type="hidden" name="p" value="search"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Start-famous-place -->
    <div class="small-container">
        <h2 class="title">Địa điểm nổi tiếng</h2>
        <div class="card-swiper-items" style="transform:translateX(-0px);">
            <div class="card-swiper-item swiper-item" style="width:1160px;margin-right:20px;">
                <?php 
                $cth = new contentHandler();
                $result = $cth->diaDiemNoiTieng_Tren();                           
                foreach ($result as $row) { 
                ?>
                    <?php
                    echo '<a href="type-tour.php?id=' . ($row['id']) . '" class="destination-item" style="background-image: url(' . ($row['img']) . ')">
                    <div style="width:100%;height:100%;">
                        <div class="title-line limit-3">' . ($row['name_province']) . '</div>
                    </div></a>';
                    ?>               
                <?php
                }
                $result->free();
                ?>
            </div>
            <div class="card-swiper-item swiper-item" style="width:1160px;margin-right:20px;">
            <?php 
                $result = $cth->diaDiemNoiTieng_Duoi();                           
                foreach ($result as $row) { 
                    echo '<a href="type-tour.php?id=' . ($row['id']) . '" class="destination-item" style="background-image: url(' . ($row['img']) . ')">
                    <div style="width:100%;height:100%;">
                        <div class="title-line limit-3">' . ($row['name_province']) . '</div>
                    </div></a>';

                }
                $result->free();
            ?>
               
            </div>
        </div>
    </div>
    <!-- End-famous-place -->


    <!-- Start-favorite-place -->
    <div class="small-container">
        <h2 class="title">Địa điểm ngẫu nhiên</h2>
        <div class="card-swiper-items" style="transform:translateX(-0px);">
            <div class="card-swiper-item swiper-item" style="width:1160px;margin-right:20px;">
            <?php 
                $result = $cth->diaDiemRanDom();                           
                foreach ($result as $row) { 
                    echo '<a href="type-tour.php?id=' . ($row['id']) . '" class="destination-item" style="background-image: url(' . ($row['img']) . ')">
                    <div style="width:100%;height:100%;">
                        <div class="title-line limit-3">' . ($row['name_province']) . '</div>
                    </div></a>';

                }
                $result->free();
            ?>
            </div>
        </div>
    </div>
    <!-- End-favorite-place -->

    <!-- Start-banner-why -->
    <div class="banner-why">
        <div class="frame-why">
            <div class="container-why">
                <div class="row-why-bn">
                    <div class="col-lg-4 hidden-xs">
                        <div class="bg-why">
                            <img src="assets/img/bg-why.png" class="pic-why">
                            <div class="pos-title">
                                <h2 class="l-height">
                                    <span class="t-visao">Vì sao chọn</span><br>
                                    <span class="t-chonvtv">chúng tôi?</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <div class="row-why">
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">1.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Mạng bán tour</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">Đầu tiên tại Việt Nam</p>
                                        <p>Ứng dụng công nghệ mới nhất</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">2.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Thanh toán</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">An toàn và linh hoạt</p>
                                        <p>Liên kết với các tổ chức tài chính</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">3.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Giá cả</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">Luôn có mức giá tốt nhất</p>
                                        <p>Bảo đảm giá tốt</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">4.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Sản phẩm</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">Đa dạng, chất lượng</p>
                                        <p>Đạt chất lượng tốt nhất</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">5.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Đặt tour</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">Dễ dàng và nhanh chóng</p>
                                        <p>Đặt tour chỉ với 3 bước</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mg-bot">
                                <div class="item" style="height:130px;">
                                    <div class="item-num">6.</div>
                                    <div class="item-name" style="text-transform: uppercase;">Hỗ trợ</div>
                                    <div class="item-line">---------------------------</div>
                                    <div class="item-des">
                                        <p class="mg-bot5">Từ 08h00 - 22h00</p>
                                        <p>Hotline và hỗ trợ trực tuyến</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-banner-why -->  
<?php
}
?>

<?php
require_once "includes/footer.php";
?>