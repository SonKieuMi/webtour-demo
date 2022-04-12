<?php
$page = 'list-booking-tour';
require_once "sideleft.php";
require "includes/contentHandler.php";
?>
<?php
    $cth = new contentHandler();
    $id = htmlspecialchars($_GET["id"]);
    $result = $cth->bookTourDetail($id);
    $row =  $result->fetch_assoc();
?> 
    <section class="dashboard-area dashboard-main">
        <div class="dashboard-content-wrap">
            <div class="dashboard-bread dashboard--bread">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="breadcrumb-content">
                                <div class="section-heading">
                                    <h2 class="sec__title font-size-30 text-white">Quản Lý Đặt Tour</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-box">
                                <div class="form-title-wrap">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="title">Chi Tiết Tour</h3>
                                        </div>
                                        <div>
                                            <a href="list-booking-tour.php">
                                                <button class="theme-btn">Quay Lại</button>
                                            </a>                                           
                                        </div>
                                    </div>
                                </div>
                                <ul class="form-content-detail">                                   
                                    <li class="item">
                                        <label>Mã Đơn Hàng:</label>
                                        <p><?php echo  $row['order_id'] ?></p>
                                    </li>
                                    <li class="item"> 
                                        <label>Họ và Tên:</label>
                                        <p><?php echo  $row['full_name'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Số Điện Thoại:</label>
                                        <p><?php echo  $row['phone'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Email:</label>
                                        <p><?php echo  $row['email'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Mã Tour:</label>
                                        <p><?php echo  $row['id_tour'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Tên Tour:</label>
                                        <p><?php echo  $row['name_tour'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Ngày Bắt Đầu:</label>
                                        <p><?php echo  $row['start'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Số Ngày:</label>
                                        <p><?php echo  $row['num_days'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Giá:</label>
                                        <p><?php echo number_format($row['price']) ?> VND</p>
                                    </li>
                                    <li class="item">
                                        <label>Phương Tiện:</label>
                                        <p><?php echo  $row['name_vehicle'] ?></p> 
                                    </li>                                     
                                    <li class="item">
                                        <label>Tổng số tiền:</label>
                                        <p><?php echo  number_format($row['total']) ?> VND</p>  
                                    </li>                               
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</body>

</html>