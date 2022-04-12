<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: /WEB_TOUR/home.php");
}

$page = 'quanlytintuc';
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
    $postId=$params['id'];
$cth = new contentHandler();
    if(isset ($_POST["save"])){
        $title = $_POST["title"];
		$description_1 = $_POST["description_1"];
		$description_2 = $_POST["description_2"];
        $date_post = $_POST["date_post"];
            $result = $cth->editPost($postId,$title,$description_1,$description_2,$date_post);   
            if($result){
                echo("    
                <script>
                alert('Sửa thành công');               
                </script>");
                header("Location: quanlytintuc.php");      
            }
            else{
                echo("
                <script>
                    alert('thêm thất bại');
                </script>");
            }
         }

    


$rs=$cth->getPostById($postId);

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
                                    <?php
                                         foreach($rs as $row)
                                        {
                                            echo'<form action="edit-news.php?id='.$postId.'" method="post" class="text-center">
                                                <div class="form-row">
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="input-group-text" class="">Mã Bài Viết</label>
                                                            <input type="text" class="form-control" required="" value="'.$postId.'" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label class="input-group-text">Tiêu Đề Bài Viết</label>
                                                            <input type="text" name="title" class="form-control" required="" value="'.$row['title'].'">
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-md">
                                            <div class="form-group">
                                                    <label class="input-group-text">Ngày Đăng</label>
                                                    <input type="date" name="date_post" class="form-control" required="" value="'.$row['date_post'].'">
                                                </div>
                                            </div>          
                                                <div class="form-group">
                                                    <textarea name="description_1" class="form-control textarea text-right p-3">'.$row['description_1'].' </textarea>
                                                    <textarea name="description_2" class="form-control textarea text-right p-3">'.$row['description_2'].' </textarea>
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <button name="save" type="submit" class="theme-btn btn-add-new">Lưu</button>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="quanlytintuc.php" class="theme-btn btn-cancel">Cancel</a>
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