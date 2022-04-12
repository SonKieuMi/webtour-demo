<?php
$page = 'duyet-comment';
require_once "sideleft.php";
require "includes/contentHandler.php";
?>
<?php
    $cth = new contentHandler();
    $id = htmlspecialchars($_GET["id"]);
    $result = $cth->cmtDetail($id);
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
                                            <a href="duyetcomment.php">
                                                <button class="theme-btn">Quay Lại</button>
                                            </a>                                           
                                        </div>
                                    </div>
                                </div>
                                <ul class="form-content-detail">                                   
                                    <li class="item">
                                        <label>Mã Comment:</label>
                                        <p><?php echo  $row['id_cmt'] ?></p>
                                    </li>
                                    <li class="item"> 
                                        <label>ID User:</label>
                                        <p><?php echo  $row['user_id'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Nội Dung Comment:</label>
                                        <p><?php echo  $row['comment'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Mã Bài Viết:</label>
                                        <p><?php echo  $row['id'] ?></p>
                                    </li>
                                    <li class="item">
                                        <label>Tiêu Đề Bài Viết:</label>
                                        <p><?php echo  $row['title'] ?></p>
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