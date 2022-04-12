<?php
require_once "database.php";
require_once "Constant.php";
class contentHandler
{
    var $connect;
    public function __construct()
    {
    }
    //dùng để hiển thị tiêu đề các tin tức ở phía bên phải của trang chi tiêt tin tức
    public function tinMoiNhat()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM post ORDER BY id DESC LIMIT 5");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị ngẫu nhiên các tiêu đề các tin tức ở phía bên phải của trang chi tiêt tin tức 
    public function tinNgauNhien()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM post ORDER BY RAND() LIMIT 5");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị card của các tỉnh ở phía trên ở (file home.php / dòng 69) 
    public function diaDiemNoiTieng_Tren()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM province ORDER BY id ASC LIMIT 0, 6");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị card của các tỉnh ở phía dưới ở (file home.php / dòng 85) 
    public function diaDiemNoiTieng_Duoi()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM province ORDER BY id ASC LIMIT 6, 6");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị ở phần các địa điểm ngẫu nhiên (file home.php / dòng 108) 
    public function diaDiemRanDom()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM province ORDER BY RAND() LIMIT 6");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị các tour ở file type-tour.php khi click vào card tour ở trang home (file typr-tour.php / dòng 117  )
    public function typeTour($id)
    {
        //$tmp = $_POST('test');
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT province.id, tour.id_tour, tour.name_tour, tour.num_days, tour.start, tour.image, tour.price, tour.quantity_tickets, vehicle.id, vehicle.name_vehicle FROM province, tour, travel_location, list_location, vehicle WHERE province.id = travel_location.province_id && travel_location.id = list_location.location_travel_id && tour.id_tour = list_location.tour_id && tour.vehicle_id = vehicle.id && province.id = " . $id . " order by tour.id_tour DESC");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị danh sách các tỉnh ở phần tìm kiếm (file danhsachtour.php/ dòng 177)
    public function danhSachDiaDiem()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM province ORDER BY id DESC");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị chi tiết của 1 tour ( file tour-detail.php/ dòng 19)
    public function tourDetail($id)
    {
        //$tmp = $_POST('test');
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM tour where id_tour=" . $id); // id = order by content_id desc limit 3");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị 4 tour ở trang chi tiết tour ( file tour-detail.php/ dòng 275)
    public function tourRandom()
    {
        //$tmp = $_POST('test');
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM tour ORDER BY RAND() LIMIT 4"); // id = order by content_id desc limit 3");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị ảnh ở trang home (file home.php/ dòng 40)
    public function imageHome()
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM tour ORDER BY RAND() LIMIT 1");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị chi tiết tin tức (file new-detail.php/ dòng 24)
    public function getNewsDetails($id)
    {
        //$tmp = $_POST('test');
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM post where id=" . $id); // id = order by content_id desc limit 3");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị các tour (file danhsachtour.php / dòng 157 )
    public function loadTours($currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, tour.quantity_tickets, vehicle.name_vehicle FROM tour, vehicle WHERE tour.vehicle_id = vehicle.id ORDER BY tour.id_tour DESC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để phân trang, hiển thị số trang ở trang danh sách tour( file danhsachtour.php / dòng 24)
    public function tourPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="danhsachtour.php?page=%s">&laquo;</a>';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM tour ORDER BY id_tour DESC"); // id = order by content_id desc limit 3");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            $first = '<a href="danhsachtour.php?page=1">&laquo;</a>';
            $last = '<a href="danhsachtour.php?&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="danhsachtour.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="danhsachtour.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="danhsachtour.php?page=1">&laquo;</a>';
                    $next = '<a href="danhsachtour.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="danhsachtour.php?page=' . $i . '">' . $i . '</a>';
                    // $pageString .= sprintf($tmp, $i, $i);
                }
            }
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        $pageString =  '<div class="small-container-pagination"><div class="pagination">' . $pre . $pageString . $next . '</div></div>'; //. $next;
        return $pageString;
    }
    // dùng để hiển thị danh sách tin tức ở trang tin tức ( file new-tour.php/ dòng 46)
    public function loadNews($currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT * FROM post ORDER BY id DESC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql); // id = order by content_id desc limit 3");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để phân trang tin tức (file news-tour.php/ dòng 43)
    public function newsPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM post ORDER BY id DESC");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="news_tour.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="news_tour.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="news_tour.php?page=1">&laquo;</a>';
                    $next = '<a href="news_tour.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="news_tour.php?page=' . $i . '">' . $i . '</a>';
                    // $pageString .= sprintf($tmp, $i, $i);
                }
            }
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        $pageString =  '<div class="small-container-pagination"><div class="pagination">' . $pre . $pageString . $next . '</div></div>'; //. $next;
        return $pageString;
    }
    // dùng để tìm kiếm tour ở trang home (file search-tour.php/ dòng 30)
    public function getSearchTour($textsearch)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT DISTINCT province.id, province.name_province, tour.id_tour, tour.name_tour, tour.num_days, tour.start, tour.image, tour.price, tour.quantity_tickets, vehicle.id, vehicle.name_vehicle  FROM province, tour, travel_location, list_location, vehicle WHERE province.id = travel_location.province_id && travel_location.id = list_location.location_travel_id && tour.id_tour = list_location.tour_id && tour.vehicle_id = vehicle.id && 
            (province.name_province LIKE '%" . $textsearch . "%' OR tour.name_tour LIKE '%" . $textsearch . "%') order by tour.id_tour DESC";
            $result = mysqli_query($connect, $sql); // id = order by content_id desc limit 3");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để cmt trang chi tiết tin tức ( file news-detail.php/ dòng 74)
    public function insertComment($userId, $postId, $comment)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "INSERT INTO comment_post VALUES (null, " . $userId . ", " . $postId . ", '" . $comment . "', 0)";
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
        }
        mysqli_close($connect);
    }
    // dùng để hiển thị cmt chi tiết tin tức (file news-detail.php /dòng 128)
    public function loadComment($contentId, $currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT * FROM comment_post, user WHERE comment_post.isActive=1 AND user.id = comment_post.user_id AND comment_post.post_id=" . $contentId . " ORDER BY comment_post.id_cmt ASC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để phân trang cmt ( news-detail.php / dòng 125)
    public function commentPaging($contentId, $redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="news-detail.php?id=' . $contentId . '&page=%s">&laquo;</a>';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM comment_post, user WHERE comment_post.isActive=1 AND user.id = comment_post.user_id AND comment_post.post_id=" . $contentId . " ORDER BY comment_post.id_cmt ASC");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            $first = '<a href="news-detail.php?id=' . $contentId . '&page=1">&laquo;</a>';
            $last = '<a href="news-detail.php?id=' . $contentId . '&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="news-detail.php?id=' . $contentId . '&page=' . ($currentPage + 1) . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="news-detail.php?id=' . $contentId . '&page=' . ($currentPage - 1) . '">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="news-detail.php?id=' . $contentId . '&page=' . ($currentPage - 1) . '">&laquo;</a>';
                    $next = '<a href="news-detail.php?id=' . $contentId . '&page=' . ($currentPage + 1) . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="news-detail.php?id=' . $contentId . '&page=' . $i . '">' . $i . '</a>';
                }
            }
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        $pageString =  '<div class="small-container-pagination"><div class="pagination">' . $pre . $pageString . $next . '</div></div>'; //. $next;
        return $pageString;
    }
    //dùng để lấy tổng số vé ở database lên và truyền vào hàm updateticket (dòng 406)
    public function totalTicket($tourId)
    {
        $db = new database();
        $total = 0;
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "SELECT * FROM tour WHERE id_tour = " . $tourId;
            $result = mysqli_query($connect, $sql);
            $row = $result->fetch_assoc();
            $total = $row['quantity_tickets'];
        }
        return $total;
    }
    // dùng để cập nhật lại số vé sau khi ng dùng đặt thành công và dc sd ở hàm booktour dong 430
    public function updateTicket($tourId, $quantity)
    {
        $sql = "";
        $total = $this->totalTicket($tourId);
        $update = 0;
        $update = $total - $quantity;
        $sql = "UPDATE tour SET quantity_tickets = " . $update . " WHERE tour.id_tour =" . $tourId;
        $db = new database();
        $connect = $db->connectDb();
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
                //$result = $connect->insert_id;
                return true;
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
        }
        mysqli_close($connect);
        return false;
    }
    //dùng để insert thông tin ng dùng và tour xuống database sd (file vnpay-return.php/ 143)
    public function bookTour($order_id, $userId, $tourId, $fullname, $phone, $email, $quantity, $total, $date, $code)
    {
        $sql = "";
        if ($this->updateTicket($tourId, $quantity)) {
            $sql = "INSERT INTO bill VALUES (null, '" . $order_id . "', " . $userId . ", " . $tourId . ", '" . $fullname . "', '" . $phone . "', '" . $email . "', " . $quantity . ", " . $total . ", '" . $date . "', '" . $code . "', 1)";
        }
        if ($sql != "") {
            $db = new database();
            $connect = $db->connectDb();
            if ($connect) {
                try {
                    mysqli_query($connect, $sql);
                    //$result = $connect->insert_id;
                    return true;
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            } else {
                echo 'Failed to connect';
            }
            mysqli_close($connect);
            return false;
        }
        return false;
    }
    //hiển thị các đơn đặt hàng của người dùng ở trang đơn hàng (order-all.php/ 89 )
    public function loadBookTourAll($userId)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, vehicle.name_vehicle, bill.quantity_people, bill.total, bill.status FROM bill, tour, vehicle WHERE bill.tour_id = tour.id_tour && tour.vehicle_id = vehicle.id && bill.user_id = " . $userId . " ORDER BY bill.id DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị các đơn đặt hàng chờ xác nhận (order-wait.php /84)
    public function loadBookTourWait($userId)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, vehicle.name_vehicle, bill.quantity_people, bill.total, bill.status FROM bill, tour, vehicle WHERE bill.tour_id = tour.id_tour && tour.vehicle_id = vehicle.id && bill.status = 1 && bill.user_id = " . $userId . " ORDER BY bill.id DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị các tour đã dc xác nhận (ordered.php/ 66)
    public function loadBookTourOrdered($userId)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, vehicle.name_vehicle, bill.quantity_people, bill.total, bill.status FROM bill, tour, vehicle WHERE bill.tour_id = tour.id_tour AND tour.vehicle_id = vehicle.id AND bill.status BETWEEN 2 AND 4 AND bill.user_id = " . $userId . " ORDER BY bill.id DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị các đơn đặt hàng bị hủy (order-cancel.php/ 65)
    public function loadBookTourCancel($userId)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, vehicle.name_vehicle, bill.quantity_people, bill.total, bill.status FROM bill, tour, vehicle WHERE bill.tour_id = tour.id_tour && tour.vehicle_id = vehicle.id && bill.status = 0 && bill.user_id = " . $userId . " ORDER BY bill.id DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để thay đổi ô status ở bảng bill ở database từ số 1 về số 0 co nghĩa là hủy tour (order-all.php /25, order-wait.php/25)
    public function changeStatus($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE bill SET bill.status = 0 WHERE bill.id =" . $id;
        $result = 0;
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
                //$result = $connect->insert_id;
                return mysqli_query($connect, $sql);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
            return false;
        }
        mysqli_close($connect);
        return false;
    }
    // dùng để đánh giá tour, dùng để cmt và số sao vào database review-tour (  odered.php / 158)
    public function insertReview($userId, $tourId, $review, $rating, $date)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "INSERT INTO review_tour VALUES (null, " . $userId . ", " . $tourId . ", '" . $review . "', " . $rating . ", '" . $date . "')";
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
        }
        mysqli_close($connect);
    }
    // dùng thay đổi stt 3->4 trong database bảng bill( odered.php / 159)
    public function changeStatusReview($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE bill SET bill.status = 4 WHERE bill.id =" . $id;
        $result = 0;
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
                //$result = $connect->insert_id;
                return mysqli_query($connect, $sql);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
            return false;
        }
        mysqli_close($connect);
        return false;
    }
    //dùng để hiển thị danh sách ng dùng đã đánh giá tour (tour-detail.php/179)
    public function loadReview($tourId, $currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT * FROM review_tour, user WHERE user.id = review_tour.user_id AND review_tour.tour_id = " . $tourId . " ORDER BY review_tour.id_review ASC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để phân trang danh sách hiển thị ng dùng đánh giá(tour-detail.php/ 176 )
    public function reviewPaging($tourId, $redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="tour-detail.php?id=' . $tourId . '&page=%s">&laquo;</a>';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM review_tour, user WHERE user.id = review_tour.user_id AND review_tour.tour_id=" . $tourId . " ORDER BY review_tour.tour_id ASC");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            $first = '<a href="tour-detail.php?id=' . $tourId . '&page=1">&laquo;</a>';
            $last = '<a href="tour-detail.php?id=' . $tourId . '&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="tour-detail.php?id=' . $tourId . '&page=' . ($currentPage + 1) . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="tour-detail.php?id=' . $tourId . '&page=' . ($currentPage - 1) . '">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="tour-detail.php?id=' . $tourId . '&page=' . ($currentPage - 1) . '">&laquo;</a>';
                    $next = '<a href="tour-detail.php?id=' . $tourId . '&page=' . ($currentPage + 1) . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="tour-detail.php?id=' . $tourId . '&page=' . $i . '">' . $i . '</a>';
                }
            }
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        $pageString =  '<div class="small-container-pagination"><div class="pagination">' . $pre . $pageString . $next . '</div></div>'; //. $next;
        return $pageString;
    }
    // dùng để load danh sách tour 1 tỉnh (danhsachtour.php/ 30)
    public function loadProvinceTour($province)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT DISTINCT province.id, province.name_province, tour.id_tour, tour.name_tour, tour.num_days, tour.start, tour.image, tour.price, tour.quantity_tickets, vehicle.id, vehicle.name_vehicle  FROM province, tour, travel_location, list_location, vehicle WHERE province.id = travel_location.province_id && travel_location.id = list_location.location_travel_id && tour.id_tour = list_location.tour_id && tour.vehicle_id = vehicle.id && province.name_province = '" . $province . "' ORDER BY tour.id_tour DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để load danh sách tour 1 giá tiền (danhsachtour.php/ 135)
    public function loadPriceTour($from, $to)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, tour.quantity_tickets, vehicle.name_vehicle FROM tour, vehicle WHERE tour.vehicle_id = vehicle.id && tour.price BETWEEN " . $from . " AND " . $to . " ORDER BY tour.price DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để load danh sách tour theo ngày tháng năm (danhsachtour.php/ 145)
    public function loadDateTour($fromDate, $toDate)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, tour.quantity_tickets, vehicle.name_vehicle FROM tour, vehicle WHERE tour.vehicle_id = vehicle.id && tour.start BETWEEN '" . $fromDate . "' AND '" . $toDate . "' ORDER BY tour.start ASC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để hiển thị số đánh giá của  ng dùng (tour-detail.php/ 159)
    public function amountReview($tourid)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM review_tour WHERE tour_id = " . $tourid);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để hiển thị số sao đánh giá TB( tour-detail.php/146)
    public function avgReview($tourid)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT ROUND(AVG(rating),1) as AVGRating FROM review_tour WHERE tour_id = " . $tourid);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
}
