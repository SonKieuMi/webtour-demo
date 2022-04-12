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

if(isset($_POST["themtour"])){
    if($_POST["name_tour"]==null){
        echo("chua nhap ten tour");
    }
    if($_POST["start"]==null){
        echo("chua nhap ngày");
    }
    if($_POST["num_days"]==null){
        echo("chua nhap so ngay");
    }
    if($_POST["description"]==null){
        echo("chua nhap mieu ta");
    }
    if($_POST["price"]==null){
        echo("chua nhap gia ");
    }
    
    if($_POST["vehicle"]==null){
        echo("chua nhap phuong tien ");
    }
    

    

   
	//kiem tra password nhập lại có giống không  password and repassword

    if($_POST["name_tour"]!=null&&$_POST["start"]!=null&&$_POST["num_days"]!=null&&$_POST["description"]!=null&&$_POST["price"]!=null&&$_POST["vehicle"]!=null){
        $name_tour = $_POST["name_tour"];
		$start = $_POST["start"];
		$num_days = $_POST["num_days"];
		$description =$_POST["description"];
        $price = $_POST["price"];
        $quantity_tickets = $_POST["quantity_ticket"];
        $vehicle = $_POST["vehicle"];
//them hinh

if (isset($_FILES["file"])) {
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $tmp = explode(".", $_FILES["file"]["name"]);
    $extension = end($tmp);
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/pjpeg"))
        && ($_FILES["file"]["size"] < 2000000)
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            echo(
            "<script>
                alert('thêm thất bại');
            </script>");
        } 
        else {
            if (file_exists("../assets/img/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                move_uploaded_file(
                    $_FILES["file"]["tmp_name"],
                    "../assets/img/" . $_FILES["file"]["name"]
                );
                $image ="assets/img/" . $_FILES["file"]["name"];
            }
            $uhd = new contentHandler();
            $result = $uhd->addtour($name_tour, $start, $num_days, $description, $image, $price, $quantity_tickets, $vehicle);   
            if($result){
                echo("    
                <script>
                alert('thêm thành công');
                </script>");
                // header("Location: dashboard.php");
                
            }
            else{
                echo("
                <script>
                    alert('thêm thất bại');
                </script>");
            }

        }
    } else {
        echo("
        <script>
            alert('thêm thất bại');
        </script>");
    }
}

    }
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
                                        <h3 class="title">Thêm Tour Mới</h3>
                                    </div>
                                    <div>
                                        <a href="quanlytour.php">
                                            <button class="theme-btn">Quay Lại</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-add-tour">
                                <form enctype="multipart/form-data" action="themtour.php" method="post" class="text-center">
                                    <div class="form-row">
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="input-group-text" class="">Tên Tour</label>
                                                <input type="text" name="name_tour" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label class="input-group-text">Ngày Đi</label>
                                                <input type="date" name="start" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="input-group-text" class="">Số Ngày</label>
                                                <input type="text" name="num_days" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="file">Hình Ảnh</label>
                                                <input type="file" name="file" id="file" /><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label class="input-group-text">Giá</label>
                                                <input type="text" name="price" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="input-group-text" class="">Phương Tiện</label>
                                                <select name="vehicle" class="form-control">
                                                    <option selected="">Chọn...</option>
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
                                                <label for="input-group-text" class="">Số Lượng Vé</label>
                                                <input type="text" name="quantity_ticket" id="quantity_ticket" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>



                                    <!-- <label for="file">Tên tập tin:</label>
                                        <input type="file" name="file" id="file"><br>
                                         <input type="submit" name="image" value="Upload"> -->

                                    <div class="form-group">
                                        <textarea name="description" class="form-control textarea text-right p-3"
                                            rows="5" placeholder="Vui lòng nhập mô tả..."></textarea>
                                    </div>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <button type="submit" name="themtour" class="theme-btn btn-add-new">Thêm
                                                Mới</button>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="quanlytour.php" class="theme-btn btn-cancel">Cancel</a>
                                        </li>
                                    </ul>
                                </form>
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