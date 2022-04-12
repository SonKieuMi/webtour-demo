<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: /WEB_TOUR/home.php");
}

$page ='quanlytintuc';
require_once "sideleft.php";
require_once "includes/contentHandler.php";

if(isset($_POST["thempost"])){
    if($_POST["title"]==null){
        echo("chua nhap title");
    }
    if($_POST["description_1"]==null){
        echo("chua nhap mieu ta 1");
    }
    if($_POST["description_2"]==null){
        echo("chua nhap mieu ta 2");
    }
    if($_POST["date_post"]==null){
        echo("chua nhap ngay");
    }
    
    if($_POST["title"]!=null&&$_POST["description_1"]!=null&&$_POST["description_2"]!=null
    &&$_POST["date_post"]!=null){
        $title = $_POST["title"];
		$description_1 = $_POST["description_1"];
		$description_2 = $_POST["description_2"];
        $date_post = $_POST["date_post"];
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
        $result = $uhd->addpost($title,$description_1,$description_2,$image,$date_post);   
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
                                    <h2 class="sec__title font-size-30 text-white">Quản Lý Tin Tức</h2>
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
                                            <h3 class="title">Thêm Bài Viết Mới</h3>
                                        </div>
                                        <div>
                                            <a href="quanlytintuc.php">
                                                <button class="theme-btn">Quay Lại</button>
                                            </a>                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-add-tour">
                                    <form enctype="multipart/form-data" action="thempost.php" method="post" class="text-center">
                                        <div class="form-row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="input-group-text">Tiêu Đề Bài Viết</label>
                                                    <input type="text" name="title" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="input-group-text">Ngày Đăng</label>
                                                    <input type="date" name="date_post" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="file">Hình Ảnh:</label>
                                                <input type="file" name="file" id="file" /><br>
                                            </div>
                                        </div>                                
                                        <div class="form-group">
                                            <textarea name="description_1" class="form-control textarea text-right p-3" rows="5" placeholder="Vui lòng nhập mô tả..."></textarea>
                                            <textarea name="description_2" class="form-control textarea text-right p-3" rows="5" placeholder="Vui lòng nhập mô tả..."></textarea>
                                        </div>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <button type="submit" name="thempost"class="theme-btn btn-add-new">Thêm Mới</button>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="quanlytintuc.php" name=cancle class="theme-btn btn-cancel">Cancel</a>
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