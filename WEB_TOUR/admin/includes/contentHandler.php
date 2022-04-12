<?php
require_once "database.php";
require_once "Constant.php";
class contentHandler
{
    var $connect;
    public function __construct()
    {
    }
    // dùng để hiển thị danh sách tour (quanlytour.php/106)
    public function danhSachTour($currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $cons = new Constant();
        $result = null;
        if ($connect) {
            $sql = "SELECT tour.id_tour, tour.name_tour, tour.start, tour.num_days, tour.image, tour.price, tour.quantity_tickets, vehicle.name_vehicle FROM tour, vehicle WHERE tour.vehicle_id = vehicle.id ORDER BY tour.id_tour DESC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();;
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để phân trang danh sách tour(quanlytour.php/24)
    public function tourPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="quanlytour.php?page=%s">&laquo;</a>';
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
            $first = '<a href="quanlytour.php?page=1">&laquo;</a>';
            $last = '<a href="quanlytour.php?&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="quanlytour.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="quanlytour.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="quanlytour.php?page=1">&laquo;</a>';
                    $next = '<a href="quanlytour.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="quanlytour.php?page=' . $i . '">' . $i . '</a>';
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
    // dùng để hiển thị danh sách tin tức (quanlytintuc.php/102)
    public function quanLyTin($currentPage)
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
    // dùng để phân trang danh sách tin (quanlytintuc.php/24)
    public function newsPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="quanlytintuc.php?page=%s">&laquo;</a>';
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
            $first = '<a href="quanlytintuc.php?page=1">&laquo;</a>';
            $last = '<a href="quanlytintuc.php?&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="quanlytintuc.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="quanlytintuc.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="quanlytintuc.php?page=1">&laquo;</a>';
                    $next = '<a href="quanlytintuc.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="quanlytintuc.php?page=' . $i . '">' . $i . '</a>';
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
    //dùng để them tour (themtour.php/80)
    public function addtour($name_tour, $start, $num_days, $description, $image, $price, $quantity_tickets, $vehicle_id)
    {
        //connect data base 
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        //Kieểm tra kết nối db có thành công hay không?
        if ($connect) {
            $sql = "INSERT INTO tour VALUES (null,'" . $name_tour . "','" . $start . "'," . $num_days . ",'" . $description . "','" . $image . "'," . $price . "," . $quantity_tickets . "," . $vehicle_id . ")";
            if (mysqli_query($connect, $sql)) {
                mysqli_close($connect);
                return true;
            }
            mysqli_close($connect);
        }
        return false;
    }
    //dùng để thêm bài viết(thempost.php/65)
    public function addpost($title, $description_1, $description_2, $image, $date_post)
    {
        //connect data base 
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        //Kieểm tra kết nối db có thành công hay không?
        if ($connect) {
            $sql = "INSERT INTO post VALUES (null,'" . $title . "','" . $description_1 . "','" . $description_2 . "','" . $image . "','" . $date_post . "')";
            if (mysqli_query($connect, $sql)) {
                mysqli_close($connect);
                return true;
            }
            mysqli_close($connect);
        }
        return false;
    }
    //tìm kiếm danh sách tour(quanlytour.php/135)
    public function getSearchTour($textsearch)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "SELECT tour.id_tour, tour.name_tour, tour.num_days, tour.start, tour.image, tour.quantity_tickets,
            tour.price, vehicle.id, vehicle.name_vehicle  FROM  tour, vehicle WHERE tour.vehicle_id = vehicle.id && tour.name_tour LIKE '%" . $textsearch . "%' order by tour.id_tour DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //tìm kiếm danh sách tin tức(quanlytintuc.php/128)
    public function getSearchPost($textsearch)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "SELECT post.id, post.title, post.description_1, post.image  FROM  post WHERE post.id = post.id && post.title LIKE '%" . $textsearch . "%' order by post.id DESC";
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để xóa tour (quanlytour.php/33)
    public function deleteTour($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "DELETE FROM tour where id_tour=" . $id);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để xóa tin tuc (quanlytintuc.php/34)
    public function deletePost($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "DELETE FROM post where id=" . $id);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để edit tour (edit-tour.php/45)
    public function editTour($id, $name_tour, $start, $num_days, $description, $price, $quantity_tickets, $vehicle_id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "UPDATE tour SET name_tour='" . $name_tour . "', start='" . $start . "', num_days=" . $num_days . ", description='" . $description . "', price=" . $price . ", quantity_tickets=" . $quantity_tickets . ", vehicle_id=" . $vehicle_id . " WHERE id_tour = " . $id;
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    // hiển thị thông tin tour lên form(edit_tour.php/58)
    public function getTourById($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM tour where id_tour = $id");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //hiển thị danh sách đơn đăt hàng(list-booking-tour.php/88)
    public function loadListBookTour($currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days,
             tour.price, vehicle.name_vehicle, bill.total, bill.status FROM bill, tour, vehicle 
             WHERE bill.tour_id = tour.id_tour && tour.vehicle_id = vehicle.id  ORDER BY bill.id DESC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để phân trang danh sách đặt hàng (list-booking-tour.php/19)
    public function booksPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="list-booking-tour.php?page=%s">&laquo;</a>';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM bill  ORDER BY id DESC");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            $first = '<a href="list-booking-tour.php?page=1">&laquo;</a>';
            $last = '<a href="list-booking-tour.php?&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="list-booking-tour.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="list-booking-tour.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="list-booking-tour.php?page=1">&laquo;</a>';
                    $next = '<a href="list-booking-tour.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="list-booking-tour.php?page=' . $i . '">' . $i . '</a>';
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
    //dùng để hiển thi chi tiết của 1 đơn hàng (booking-detail.php/9)
    public function bookTourDetail($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT bill.id, bill.order_id, bill.user_id, bill.full_name, bill.phone, bill.email, tour.id_tour, tour.name_tour, tour.start, tour.num_days,
             tour.price, vehicle.name_vehicle, bill.total, bill.status FROM bill, tour, vehicle 
             WHERE bill.tour_id = tour.id_tour && tour.vehicle_id = vehicle.id && bill.id =" . $id;
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để thay đổi trạng thái từ 1->2 của đơn hàng nằm trong list(list-booking-tour.php/22)
    public function changeStatus($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE bill SET bill.status = 2 WHERE bill.id =" . $id;
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
    // dùng để thay đổi trang thái từ 2->3 để ng dùng đánh giá (list-book-tour.php/ 33)
    public function changeStatusComplete($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE bill SET bill.status = 3 WHERE bill.id =" . $id;
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
    //dùng để hiển thị cmt của ng dùng (duyetcomment.php/79)
    public function loadCommentPost($currentPage)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT comment_post.id_cmt, comment_post.user_id, comment_post.comment, post.id, post.title, comment_post.isActive 
            FROM comment_post, post WHERE comment_post.post_id = post.id ORDER BY comment_post.id_cmt DESC LIMIT " . ($currentPage - 1) * $cons->getNumOfRowPerPage() . " ," . $cons->getNumOfRowPerPage();
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để phân trang cho phần duyệt cmt(duyetcomment.php/23)
    public function commentPaging($redirectPage, $currentPage)
    {
        $pageString = '';
        $tmp = '<a href="duyetcomment.php?page=%s">&laquo;</a>';
        $pre = '';
        $next = '';
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT count(*) FROM comment_post  ORDER BY id_cmt DESC");
            $row_db = mysqli_fetch_row($result);
            $total_records = $row_db[0];
            $cons = new Constant();
            $total_pages = ceil($total_records / $cons->getNumOfRowPerPage());
            $first = '<a href="duyetcomment.php?page=1">&laquo;</a>';
            $last = '<a href="duyetcomment.php?&page=' . $total_pages . '">&raquo;</a>';
            if ($total_pages <= 1) {
                $pre = '<a href="#" tabindex="-1">&laquo;</a></li>';
                $next = '<a tabindex="-1" href="#">&raquo;</a></li>';
            } else {
                if ($currentPage == 1) {
                    $pre = '<a href="#" tabindex="-1">&laquo;</a>';
                    $next = '<a href="duyetcomment.php?page=' . $total_pages . '">&raquo;</a>';
                } else if ($currentPage == $total_pages) {
                    $pre = '<a href="duyetcomment.php?page=1">&laquo;</a>';
                    $next = '<a tabindex="-1" href="#">&raquo;</a>';
                } else {
                    $pre = '<a href="duyetcomment.php?page=1">&laquo;</a>';
                    $next = '<a href="duyetcomment.php?page=' . $total_pages . '">&raquo;</a>';
                }
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($currentPage == $i) {
                    $pageString .= '<a href="#" class="active">' . $i . '</a>';
                } else {
                    $pageString .= '<a href="duyetcomment.php?page=' . $i . '">' . $i . '</a>';
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
    //dùng để xem chi tiết của của 1 cmt ở 1 bài viết (cmtdetail.php/9)
    public function cmtDetail($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        $cons = new Constant();
        if ($connect) {
            $sql = "SELECT comment_post.id_cmt, comment_post.user_id, comment_post.comment, post.id, post.title, comment_post.isActive 
            FROM comment_post, post WHERE comment_post.post_id = post.id && comment_post.id_cmt = " . $id;
            $result = mysqli_query($connect, $sql);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để duyệt cmt (duyetcomment.php/26)
    public function changeCmt($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE comment_post SET comment_post.isActive = 1 WHERE comment_post.id_cmt = " . $id;
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
    //dùng để load thông tin bài viết lên (edit-news.php/60)
    public function getPostById($id)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM post where id=$id");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để cập nhật bài viết (edit-tour.php/41)
    public function editPost($id, $title, $description_1, $description_2, $date_post)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "UPDATE post Set title='" . $title . "',description_1='" . $description_1 . "',description_2='" . $description_2 . "',
              date_post='" . $date_post . "' where id=" . $id);
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
}
