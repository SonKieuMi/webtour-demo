<?php
session_start();
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: /WEB_TOUR/home.php");
}

$page = 'duyet-comment';
require_once "sideleft.php";
require "includes/contentHandler.php";

?>
<?php
$cth = new contentHandler();
$page = 1;
if (!isset($_GET["page"])) {
    $_GET["page"] = 1;
}
$page = htmlspecialchars($_GET["page"]);
$pagingResult = $cth->commentPaging('', $page);
if(isset($_POST['confirm'])) {
    $id = $_POST['id_cmt'];
    $change = $cth->changeCmt($id);
    if($change) {
        echo("<script>alert('Duyệt thành công!');
				location.href = duyetcomment.php';
			</script>");      
    }
    else {
        echo("<script>alert('Duyệt thất bại!');</script>"); 

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
                                    <h2 class="sec__title font-size-30 text-white">Quản Lý Duyệt Comment</h2>
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
                                            <h3 class="title">Danh Sách Comment</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-content">
                                    <div class="table-form table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-img" tabindex="0" style="width: 50px;">Mã Comment</th>
                                                    <th class="col" tabindex="0" style="width: 100px;">ID User</th>
                                                    <th class="col" tabindex="0" style="width: 300px;">Nội Dung Comment</th>
                                                    <th class="col" tabindex="0" style="width: 70px;">Mã Bài Viết</th>
                                                    <th class="col" tabindex="0" style="width: 300px;">Tiêu Đề Bài Viết</th>
                                                    <th class="col" tabindex="0" style="width: 200px;">Trạng Thái</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $result = $cth->loadCommentPost($page);
                                            foreach($result as $row) {                                           
                                            echo '<tbody class="list-booking-tour">
                                                <tr>                                                   
                                                    <td><a href="cmtdetail.php?id=' .$row['id_cmt']. '">' .$row['id_cmt']. '</a></td>
                                                    <td>' .$row['user_id']. '</td>
                                                    <td>' .$row['comment']. '</td>
                                                    <td>' .$row['id']. '</td>
                                                    <td>' .substr(($row['title']), 0, 50). '...</td>';                                                   
                                                    if ($row['isActive']  == 0) {
                                                        echo '<td>
                                                        <form action="duyetcomment.php?id=' .$row['id_cmt']. '"" method="POST">
                                                        <input type="hidden" name="id_cmt" value="' .$row['id_cmt']. '" />
                                                        <button type="submit" name="confirm">Duyệt</button>
                                                        </form>
                                                        </td>';
                                                    } 
                                                    if ($row['isActive']  == 1) {
                                                        echo '<td>
                                                        <span class="confirm">Đã Duyệt</span>
                                                        </td>';
                                                    }                                                   
                                                                                              
                                            echo "</tr>
                                            </tbody>";
                                            }
                                            ?>
                                            
                                        </table>
                                        <?php
                                            echo $pagingResult;
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