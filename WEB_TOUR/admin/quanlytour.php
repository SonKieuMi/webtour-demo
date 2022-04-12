<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: ../home.php");
}

$page = 'quanlytour';
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
$pagingResult = $cth->tourPaging('', $page);
$searchText = "";
if (isset($_POST["searchbutton"])) {
    $searchText =  $_POST["searchText"];  
}
?>
<?php
if(isset($_POST["deletetour"])){
    $id = $_POST['tourid'];
    $delete = $cth->deleteTour($id);
    echo $id;
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
                                        <form action="quanlytour.php" method="post">
                                        <div>
                                            <h3 class="title">Danh Sách Tour</h3>
                                            <input type="text"name="searchText" class="search" placeholder="Tìm kiếm Tour">
                                            <button type="submit" name="searchbutton" class="theme-btn theme-btn-search">Tìm Kiếm</button>
                                        </div>
                                        </form>
                                        <div>
                                            <a href="themtour.php">
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
                                                    <th class="col-img" tabindex="0" style="width: 80px;">Ảnh</th>
                                                    <th class="col" tabindex="0" style="width: 193px;">Mã Tour</th>
                                                    <th class="col" tabindex="0" style="width: 193px;">Tên Tour</th>                                                  
                                                    <th class="col" tabindex="0" style="width: 193px;">Ngày Đi</th>
                                                    <th class="col" tabindex="0" style="width: 80px;">Số ngày</th>
                                                    <th class="col" tabindex="0" style="width: 185px;">Phương Tiện</th>
                                                    <th class="col" tabindex="0" style="width: 185px;">Giá</th>
                                                    <th class="col" tabindex="0" style="width: 200px;">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                            if($searchText == ""){
                                                $flag = true;
                                                $result = $cth->danhSachTour($page);
                                                foreach($result as $row)
                                                {                                           
                                            echo '<tbody>
                                                <tr>
                                                    <td class="col_1">
                                                        <img src="../'.$row['image'].'" class="img-fluid rounded-circle"
                                                            width="40px">
                                                    </td>
                                                    <td>'.$row['id_tour'].'</td>
                                                    <td>'.$row['name_tour'].'</td>                                                   
                                                    <td>'.$row['start'].'</td>
                                                    <td>'.$row['num_days'].'</td>
                                                    <td>'.$row['name_vehicle'].'</td>
                                                    <td>'.number_format($row['price']).' VND</td>
                                                    <td class="action">
                                                    <form action="quanlytour.php?id='.$row['id_tour'].'" method="POST">                                                                                   
                                                        <input type="hidden" name="tourid" value="'.$row['id_tour'].'" />
                                                        <button class="fa-delete" type="submit" name="deletetour"><i class="fas fa-trash-alt"></i></button>                                   
                                                        <a href="edit-tour.php?id='.$row['id_tour'].'"><i class="fas fa-edit"></i></a>
                                                    </form>                                                                                                                                                                                                              
                                                    </td>
                                                </tr>
                                            </tbody>';
                                            
                                        }
                                            }
                                            else{
                                                $flag = false;
                                                $result = $cth->getSearchTour($searchText);
                                                foreach($result as $row)
                                                {
                                            echo '<tbody>
                                                <tr>
                                                    <td class="col_1">
                                                        <img src="../'.$row['image'].'" class="img-fluid rounded-circle"
                                                            width="40px">
                                                    </td>
                                                    <td>'.$row['id_tour'].'</td>
                                                    <td>'.$row['name_tour'].'</td>                                                   
                                                    <td>'.$row['start'].'</td>
                                                    <td>'.$row['num_days'].'</td>
                                                    <td>'.$row['name_vehicle'].'</td>
                                                    <td>'.$row['price'].' VND</td>
                                                    <td class="action">
                                                        <form action="quanlytour.php?id='.$row['id_tour'].'" method="POST">
                                                        <input type="hidden" name="tourid" value="'.$row['id_tour'].'" />
                                                        <button class="fa-delete" type="submit" name="deletetour"><i class="fas fa-trash-alt"></i></button>
                                                        <a href="edit-tour.php?id='.$row['id_tour'].'"><i class="fas fa-edit"></i></a>
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