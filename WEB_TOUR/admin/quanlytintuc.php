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

?>
<?php
$cth = new contentHandler();
$page = 1;
$flag = true;
if (!isset($_GET["page"])) {
    $_GET["page"] = 1;
}
$page = htmlspecialchars($_GET["page"]);
$pagingResult = $cth->newsPaging('', $page);
$searchText = "";
if (isset($_POST["searchbutton"])) {
    $searchText = $_POST["searchText"];  
}

?>
<?php
if(isset($_POST["deletepost"])){
    $id = $_POST['postid'];
    $delete = $cth->deletePost($id);
    if($delete){
        echo("    
        <script>
        alert('xóa thành công');
        </script>");
        // header("Location: login.php");    
    }
    else{
        echo("
        <script>
        alert('xóa thất bại');
        </script>");
    }

}
?>
    <section class="dashboard-area">
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
                                        <form action="quanlytintuc.php" method="post">
                                        <div>
                                            <h3 class="title">Danh Sách Bài Viết Tin Tức</h3>
                                            <input type="text"name="searchText" class="search" class="search" placeholder="Tìm kiếm Tin Tức">
                                            <button type="submit" name="searchbutton"  class="theme-btn theme-btn-search">Tìm Kiếm</button>
                                        </div>
                                        </form>
                                        <div>
                                            <a href="thempost.php">
                                                <button class="theme-btn">Thêm Mới</button>
                                            </a>                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-content">
                                    <div class="table-form table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-img" tabindex="0" style="width: 150px;">Ảnh</th>
                                                    <th class="col" tabindex="0" style="width: 100px;">Mã Bài Viết</th>
                                                    <th class="col" tabindex="0" style="width: 342px;">Tiêu Đề Bài Viết</th>
                                                    <th class="col" tabindex="0" style="width: 392px;">Mô Tả</th>
                                                    <th class="col" tabindex="0" style="width: 200px;">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                            if($searchText == ""){
                                                $flag = true;
                                                $result = $cth->quanLyTin($page);
                                                foreach($result as $row)
                                            {
                                                echo '<tbody>
                                                <tr>
                                                    <td class="col_1">
                                                        <img src="../'.$row['image'].'" class="img-fluid rounded-circle"
                                                            width="40px">
                                                    </td>
                                                    <td>'.$row['id'].'</td>
                                                    <td>'.$row['title'].'</td>                                                   
                                                    <td>'.substr(($row['description_1']), 0, 50).'...</td>
                                                    <td class="action">
                                                    <form action="quanlytintuc.php?id='.$row['id'].'" method="POST">
                                                    <a href="edit-news.php?id='.$row['id'].'"><i class="fas fa-edit"></i></a>
                                                    <input type="hidden" name="postid" value="'.$row['id'].'" />
                                                    <button class="fa-delete" type="submit" name="deletepost"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                    </td>

                                                </tr>
                                            </tbody>';
                                            }                                       
                                            }
                                            else{
                                                $flag = false;
                                                $result = $cth->getSearchPost($searchText);
                                                foreach($result as $row)
                                            {
                                                echo '<tbody>
                                                <tr>
                                                    <td class="col_1">
                                                        <img src="../'.$row['image'].'" class="img-fluid rounded-circle"
                                                            width="40px">
                                                    </td>
                                                    <td>'.$row['id'].'</td>
                                                    <td>'.$row['title'].'</td>                                                   
                                                    <td>'.substr(($row['description_1']), 0, 50).'...</td>
                                                    <td class="action">
                                                    <form action="quanlytour.php?id='.$row['id'].'" method="POST">
                                                    <a href="edit-news.php?id='.$row['id'].'"><i class="fas fa-edit"></i></a>
                                                    <input type="hidden" name="postid" value="'.$row['id'].'" />
                                                    <button class="fa-delete" type="submit" name="deletepost"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                    </td>
                                                </tr>
                                            </tbody>';
                                        }                                              
                                            }                                          
                                        ?>                                          
                                        </table>
                                        <?php
                                        if($flag){
                                            echo $pagingResult;  
                                        }
                                        ?>
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