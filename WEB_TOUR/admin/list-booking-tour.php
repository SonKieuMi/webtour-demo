<?php
session_start();
if (isset($_SESSION['userrole']) && $_SESSION['userrole'] == "ROLE_ADMIN") {
} else {
    header("Location: /WEB_TOUR/home.php");
}

$page = 'list-booking-tour';
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
$pagingResult = $cth->booksPaging('', $page);
if (isset($_POST['confirm'])) {
    $id = $_POST['bill-id'];
    $change = $cth->changeStatus($id);
    if ($change) {
        echo ("<script>alert('Xác nhận thành công!');
				location.href = list-booking-tour.php';
			</script>");
    } else {
        echo ("<script>alert('Xác nhận thất bại!');</script>");
    }
}
if (isset($_POST['complete'])) {
    $id = $_POST['bill-id'];
    $change = $cth->changeStatusComplete($id);
    if ($change) {
        echo ("<script>alert('Xác nhận thành công!');
				location.href = list-booking-tour.php';
			</script>");
    } else {
        echo ("<script>alert('Xác nhận thất bại!');</script>");
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
                                        <h3 class="title">Danh Sách Đặt Tour</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="form-content">
                                <div class="table-form table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-img" tabindex="0" style="width: 125px;">Mã</th>
                                                <th class="col" tabindex="0" style="width: 125px;">Họ và Tên</th>
                                                <th class="col" tabindex="0" style="width: 120px;">Số Điện Thoại</th>
                                                <th class="col" tabindex="0" style="width: 100px;">Email</th>
                                                <th class="col" tabindex="0" style="width: 250px;">Tour</th>
                                                <th class="col" tabindex="0" style="width: 150px;">Ngày Bắt Đầu</th>
                                                <th class="col" tabindex="0" style="width: 50px;">Số Ngày</th>
                                                <th class="col" tabindex="0" style="width: 100px;">Tổng Số Tiền</th>
                                                <th class="col" tabindex="0" style="width: 250px;">Trạng Thái</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $cth = new contentHandler();
                                        $result = $cth->loadListBookTour($page);
                                        foreach ($result as $row) {
                                            echo '<tbody class="list-booking-tour">
                                                <tr>                                                   
                                                    <td><a href="booking-detail.php?id=' . $row['id'] . '">' . $row['order_id'] . '</a></td>
                                                    <td>' . $row['full_name'] . '</td>
                                                    <td>' . $row['phone'] . '</td>
                                                    <td>' . $row['email'] . '</td>
                                                    <td>' . $row['name_tour'] . '</td>
                                                    <td>' . $row['start'] . '</td>
                                                    <td>' . $row['num_days'] . '</td>
                                                    <td>' . number_format($row['total']) . ' VND</td>';
                                            if ($row['status']  == 1) {
                                                echo '<td>
                                                                <form action="list-booking-tour.php" method="POST">
                                                                    <input type="hidden" name="bill-id" value="' . $row['id'] . '" />
                                                                    <button type="submit" name="confirm">Xác Nhận</button>
                                                                </form>
                                                            </td>';
                                            }
                                            if ($row['status']  == 2) {
                                                echo '<td>
                                                        <form action="list-booking-tour.php" method="POST">
                                                        <input type="hidden" name="bill-id" value="' . $row['id'] . '" />
                                                        <button type="submit" name="complete" class="confirm">Đã Xác Nhận</button>
                                                        </form>
                                                        </td>';
                                            }
                                            if ($row['status']  == 0) {
                                                echo '<td>
                                                        <span class="cancel">Đã Hủy</span>
                                                        </td>';
                                            }
                                            if ($row['status']  == 3) {
                                                echo '<td>
                                                        <span class="confirm">Đã Hoàn Thành</span>
                                                        </td>';
                                            }
                                            if ($row['status']  == 4) {
                                                echo '<td>
                                                        <span class="rating">Đã Đánh Giá</span>
                                                        </td>';
                                            }
                                            echo "</tr>";
                                            echo "</tbody>";
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