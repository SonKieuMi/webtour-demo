 

<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: /WEB_TOUR/home.php");
}

$page = 'quanlytour';
require_once "sideleft.php";
require_once "includes/contentHandler.php";

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   

// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];
// Use parse_url() function to parse the URL 
// and return an associative array which
// contains its various components
$url_components = parse_url($url);
  
// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
if(isset($params['id'])){
    $tourId=$params['id'];
    $cth = new contentHandler();
    if(isset ($_POST["save"])){
        $name_tour = $_POST["name_tour"];
		$start = $_POST["start"];
		$num_days = $_POST["num_days"];
		$description =$_POST["description"];
        $price = $_POST["price"];
        $quantity_ticket = $_POST["quantity_ticket"];
        $vehicle = $_POST["vehicle"];
        $result = $cth->editTour($tourId, $name_tour, $start, $num_days, $description, $price, $quantity_ticket, $vehicle);     
            if($result){
                echo("<script>alert('Sửa thành công');
                </script>");
                header("Location: quanlytour.php");      
            }
            else{
                echo("
                <script>
                    alert('Sửa thất bại');
                </script>");
            }
         }
    $rs = $cth->getTourById($tourId);
}

 
?>


    <section class="dashboard-area dashboard-main">
        <div class="dashboard-content-wrap">
            <div class="dashboard-bread dashboard--bread">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="breadcrumb-content">
                                <div class="section-heading">
                                    <h2 class="sec__title font-size-30 text-white">Quản Lý Tour</h2>
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
                                            <h3 class="title">Chỉnh Sửa Tour</h3>
                                        </div>
                                        <div>
                                            <a href="quanlytour.php">
                                                <button class="theme-btn">Quay Lại</button>
                                            </a>                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-add-tour">
                                    <?php
                                        foreach($rs as $row)
                                        {
                                            echo'<form action="edit-tour.php?id='.$tourId.'" method="post" class="text-center">
                                                <div class="form-row">
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Mã Tour</label>
                                                        <input type="text" class="form-control" required="" value="'.$tourId.'" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="input-group-text" class="">Tên Tour</label>
                                                            <input type="text"name="name_tour" class="form-control" required="" value="'.$row['name_tour'].'">
                                                        </div>
                                                    </div>                                          
                                                </div>
                                                <div class="form-row">                                                    
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Ngày Đi</label>
                                                            <input type="date" name="start"class="form-control" required="" value="'.$row['start'].'">
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="file">Hình Ảnh:</label>
                                                            <img src="../'.$row['image'].'" alt="" style="width: 100px; height:50px;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Số Ngày</label>
                                                            <input type="text" name="num_days"class="form-control" required="" value="'.$row['num_days'].'">
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="input-group-text" class="">Phương Tiện</label>
                                                            <select name="vehicle" class="form-control">
                                                                <option value="5">Xe 7 chỗ</option>
                                                                <option value="6">Xe Gường nằm</option>
                                                                <option value="7">Máy Bay</option>
                                                                <option value="8">Xe Máy</option>
                                                            </select>
                                                        </div>
                                                    </div>                                          
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Giá</label>
                                                            <input type="text" name="price" class="form-control" required="" value="'.$row['price'].'">
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Số lượng vé</label>
                                                            <input type="text" name="quantity_ticket" id="quantity_ticket" class="form-control" required="" value="'.$row['quantity_tickets'].'">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="description" class="form-control textarea text-right p-3">'.$row['description'].'</textarea>
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                    <button name="save" type="submit" class="theme-btn btn-add-new">Lưu</button>
                                                      
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="quanlytour.php" class="theme-btn btn-cancel">Cancel</a>
                                                         
                                                    </li>
                                                </ul>
                                             
                                            </form>';
                                        }
                                    ?>
                                    
                                </div>
                            </div><!-- end form-group -->
                        </div><!-- end column -->
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </section>

</body>

</html>