<?php
session_start();
$page = 'danhsachtour';
require "includes/contentHandler.php";

if(isset( $_SESSION['tendangnhap'] ) )
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
$cth = new contentHandler();
if ( isset ($_GET["p"]) )
 $p = $_GET["p"];
else 
$p = "";
switch ($p) {
    case "tour-detail" : require "tour-detail.php"; break;
        default :
 ?>
 <!-- start-content -->
 <div class="container n3-list-tour mg-bot40">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="list-tour">
                    <!-- start-search -->
                <form action="danhsachtour.php" method="POST">
                    <div class="sort-tour" id="sortHeader">
                        <div class="row">
                            <div class="col-lg-3 col-sm-5 col-xs-12 mgbs" style="margin-left: 10px;">
                                <div>
                                    <div class="f-left title-sort" style="margin-right: 10px;padding-top: 8px;"><span
                                            class=""><i class="fa fa-map-signs i-i"></i>&nbsp;&nbsp;&nbsp;</span>Địa điểm
                                    </div>
                                    <div class="f-left">                                       
                                        <select class="form-control" name="province" style="width:132px;" data-url="departureID">
                                            <option value="0">--Tất cả--</option>
                                            <?php 
                                            $cth = new contentHandler();
                                            $result = $cth->danhSachDiaDiem();                           
                                            while ($row = $result->fetch_array() ) {
                                                echo  '<option>' . ($row['name_province']) . '</option>';                                        
                                            }
                                            $result->free();
                                            ?>
                                        </select>     
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="col-lg-3 text-left mgbs">
                                <div class="f-left">
                                    <div class="f-left title-sort" style="padding-top: 8px;margin-right: 10px;"><span
                                            class=""><i class="fa fa-dollar i-i"></i>&nbsp;&nbsp;&nbsp;</span>Giá</div>
                                    <div class="f-left">
                                        <select class="form-control Filter" id="priceIDFilter" name="price" style="width:156%">
                                            <option selected="" value="0">--Tất cả--</option>
                                            <option value="1">Dưới 1 Triệu</option>
                                            <option value="2"> 1- 2 Triệu</option>
                                            <option value="3"> 2-4 Triệu</option>
                                            <option value="4"> 4-6 Triệu</option>
                                            <option value="5"> 6-10 Triệu</option>
                                            <option value="6">Trên 10 Triệu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-7 col-xs-12 mgb-date">
                                    <div style="display: table;width:117%">
                                        <div class="f-left title-sort mgb-sort"
                                            style="margin-right: 10px;padding-top: 8px;">
                                            <span class="">
                                                <i class="fa fa-calendar i-i"></i>&nbsp;&nbsp;&nbsp;
                                            </span>
                                            Từ ngày
                                        </div>
                                        <div class="f-left mgb-sort">
                                            <input style="width: 91%;" class="form-control input-md hasDatepicker FilterClick2" name="dateFrom" value="2021-08-20" type="date">
                                        </div>
                                        <div class="f-left mgb-sort" style="margin-right: 10px;padding-top: 10px;"><span
                                                class="">-</span><span class=""> đến ngày </span></div>
                                        <div class="f-left ">
                                            <input style="width: 91%;" class="form-control input-md hasDatepicker FilterClick2" name="dateTo" value="2021-09-20" type="date">
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            <div class="col-lg-3 search-list">                                   
                                            <button type="submit" class="btn-search" name="search">Tìm Kiếm</button>
                                        <div class="clear"></div>
                                    </div>
                        </div>
                    </div>
                </form>
                    <!-- end-search -->


                    <div class="list">
                        <div class="row">
                            <div class="col-md-12 text-center" style="padding-bottom:25px;padding-top:20px;width:100%">
                                <h2 class="title" style="text-shadow:none;">DANH SÁCH TOUR</h2>
                            </div>
                            <div>
                            <?php                               
                                $id = htmlspecialchars($_GET["id"]);                             
                               $result = $cth->typeTour($id);
                               foreach ($result as $row) {                               
                                echo '<div class="col-lg-11 col-md-11 col-sm-12 item-tour">
                                        <div class="item mg-bot30">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="tour-name">
                                                        <a href="tour-detail.php?id=' . ($row['id_tour']) . '"
                                                            title="' . ($row['name_tour']) . '">
                                                            <h3>' . ($row['name_tour']) . '</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 item-img">
                                                    <div class="pos-relative">
                                                        <a href="tour-detail.php?id=' . ($row['id_tour']) . '"
                                                            title="' . ($row['name_tour']) . '"><img
                                                            src="' . ($row['image']) . '" class="img-responsive pic-lt"
                                                            alt="' . ($row['name_tour']) . '"></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 info-items">
                                                    <div class="frame-info pos-relative">
                                                        <div class="row">
                                                            <div class="col-md-7 col-sm-7 mg-bot10">
                                                                <div class="f-left l"><img src="assets/img/i-date.png" alt="date">
                                                                </div>
                                                                <div class="f-left r">Ngày đi: 
                                                                <span class="font500">' . ($row['start']) . '</span></div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="col-md-5 col-sm-5 mg-bot10">
                                                                <div class="f-left l"><img src="assets/img/i-chair.png"
                                                                        alt="chair"></div>
                                                                <div class="f-left r">
                                                                    Phương tiện: <span class="font500">' . ($row['name_vehicle']) . '</span>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="col-md-7 col-sm-7 mg-bot10">
                                                                <div class="f-left l"><img src="assets/img/i-price.png"
                                                                        alt="price"></div>
                                                                <div class="f-left r">Giá:
                                                                    <span class="font500 price">' . number_format($row['price']) . '</span>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="col-md-5 col-sm-5">
                                                                <div class="f-left l"><img src="assets/img/i-calendar.png"
                                                                        alt="date"></div>
                                                                <div class="f-left r">Số ngày: <span
                                                                        class="font500">' . ($row['num_days']) . '</span></div>
                                                             <div class="clear"></div>
                                                            </div>  
                                                            <div class="col-md-7 col-sm-7 mg-bot10">
                                                                 <div class="f-left l"><img src="assets/img/i-ticket.png" alt="ticket">
                                                                 </div>
                                                                 <div class="f-left r">Số lượng vé còn: 
                                                                 <span class="font500">' . $row['quantity_tickets'] . '</span></div>
                                                                 <div class="clear"></div>
                                                             </div>                                                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                 
                                }
                                $result->free();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- end-content -->

    <?php
    }
    ?>
<?php
require_once "includes/footer.php";
?>