<?php
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
require "../includes/contentHandler.php";
require_once "../mail/mailHandler.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <!-- Bootstrap core CSS -->
        <link href="assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="assets/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        <?php
        require_once("config.php");
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        ?>
        <!--Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã đơn hàng:</label>
                    <label><?php echo $_GET['vnp_TxnRef'] ?></label>
                </div>    
                <div class="form-group">
                    <label >Mã Tour:</label>
                    <label><?php echo $_SESSION['tour_id']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Ngày đặt hàng:</label>
                    <label><?php echo $date = date("Y-m-d H:i:s"); ?></label>
                </div> 
                <div class="form-group">
                    <label >Tên tour:</label>
                    <label><?php echo $_SESSION['name_tour'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Người đặt hàng:</label>
                    <label><?php echo $_SESSION['fullname']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Số điện thoại:</label>
                    <label><?php echo $_SESSION['phone'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Địa chỉ email:</label>
                    <label><?php echo $_SESSION['email']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Số người:</label>
                    <label><?php echo $_SESSION['quantity']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Số tiền đã thanh toán:</label>
                    <label><?php echo number_format($_GET['vnp_Amount']/100) ?> VND</label>
                </div>             
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label><?php echo $_GET['vnp_BankCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label><?php echo date("Y-m-d H:i:s") ?></label>
                </div> 
                <div class="form-group">
                <label>
                        <?php
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                $order_id = $_GET['vnp_TxnRef'];
                                $money = $_GET['vnp_Amount']/100;
                                $note = $_GET['vnp_OrderInfo'];
                                $vnp_response_code = $_GET['vnp_ResponseCode'];
                                $code_vnpay = $_GET['vnp_TransactionNo'];
                                $code_bank = $_GET['vnp_BankCode'];
                                $time = $_GET['vnp_PayDate'];
                                $date_time = date("Y-m-d H:i:s");
                                $db = new database();
                                $conn = $db->connectDb();
                                $user_id = $_SESSION['id_user'];
                                $taikhoan = $_SESSION['tendangnhap'];
                                $sql = "SELECT * FROM payments WHERE order_id = '$order_id'";
                                $query = mysqli_query($conn, $sql);
                                $row = mysqli_num_rows($query);                         
                                if ($row > 0) {
                                    $sql = "UPDATE payments SET order_id = '$order_id', money = '$money', note = '$note', vnp_response_code = '$vnp_response_code', code_vnpay = '$code_vnpay', code_bank = '$code_bank' WHERE order_id = '$order_id'";
                                    mysqli_query($conn, $sql);
                                } else {
                                    $sql = "INSERT INTO payments(user_id, order_id, user_name, money, note, vnp_response_code, code_vnpay, code_bank, time) VALUES ('$user_id', '$order_id', '$taikhoan', '$money', '$note', '$vnp_response_code', '$code_vnpay', '$code_bank','$date_time')";
                                    mysqli_query($conn, $sql);
                                }
                                $tour_id = $_SESSION['tour_id'];
                                $cth = new contentHandler();
                                $send = new mailHandler();
                                $result = $cth->tourDetail($tour_id);
                                $row =  $result->fetch_assoc();
                                $fullname = $_SESSION['fullname'];
                                $email = $_SESSION['email'];
                                $phone = $_SESSION['phone'];
                                $quantity = $_SESSION['quantity'];
                                $total = $_SESSION['total'];
                                $code = (int)((mt_rand(0, mt_getrandmax())/mt_getrandmax())*100000000);
                                $code = md5($code);
                                $date = date("Y-m-d H:i:s");
                                $re = $cth->bookTour($order_id, $user_id, $tour_id, $fullname, $phone, $email, $quantity, $total, $date, $code);
                                if($re) {
                                    $content = '<div>
                                    <table width="100%" background-color="#ffffff" cellpadding="0" cellspacing="0" border="0" id="m_-2588793581771457621backgroundTable">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%">
                                                            <table background-color="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="0" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0">
                                                                        <tbody>
                                                                            <tr><td colspan="2" style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px"> </td></tr>
                                                                            <tr><td colspan="2" style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:13px;font-weight:bold">THÔNG TIN ĐƠN HÀNG - DÀNH CHO NGƯỜI MUA</td></tr>
                                                                        </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <table width="100%" background-color="#ffffff" cellpadding="0" cellspacing="0" border="0" id="m_-2588793581771457621backgroundTable">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%">
                                                            <table background-color="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="0" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="2" style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:px"> </td>
                                                                                </tr>
                                                                                <tr>
                                                                                <tr>
                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">Mã đơn hàng: </td><td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">'. $order_id .'</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">Ngày đặt hàng: </td><td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">'. $date .'</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2" width="100%" height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <table width="100%" background-color="#ffffff" cellpadding="0" cellspacing="0" border="0" id="m_-2588793581771457621backgroundTable">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%">
                                                                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="left">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="560" align="center" border="0" cellpadding="0" cellspacing="0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td width="560" height="140" align="left">
                                                                                                <a href="">
                                                                                                    <img src="'. $row['image'] .'" alt="" border="0" width="140" height="140" style="display:block;border:none;outline:none;text-decoration:none" class="CToWUd">
                                                                                                </a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td width="100%" height="15" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td colspan="2" width="" height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td colspan="2" style="font-family:Helvetica,arial,sans-serif;font-size:16px;color:#000000;text-align:left;font-weight=bold">Tên tour: '. $row['name_tour'] .'
                                                                                            </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td colspan="2" width="" height="15" style="word-break:break-word;font-size:1px;line-height:1px">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">Số người: </td>
                                                                                                <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">'. $quantity .'</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">Giá vé: </td>
                                                                                                <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">'. $row['price'] .' VND</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td colspan="2" width="" height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>        
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="width:100%;height:1px;display:block" align="center">
                                        <div style="width:100%;max-width:600px;height:1px;border-top:1px solid #e0e0e0">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div style="width:100%;height:1px;display:block" align="center">
                                        <div style="width:100%;max-width:600px;height:1px;border-top:1px solid #e0e0e0">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <table width="100%" background-color="#ffffff" cellpadding="0" cellspacing="0" border="0" id="m_-2588793581771457621backgroundTable">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%">
                                                            <table background-color="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="0" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">Tổng thanh toán: </td>
                                                                                        <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top" width="280">'. $total .' VND</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px"> </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px"> </td>
                                                                    </tr>
                                                            </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <div style="width:100%;height:1px;display:block" align="center">
                                        <div style="width:100%;max-width:600px;height:1px;border-top:1px solid #e0e0e0">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <table width="100%" background-color="#ffffff" cellpadding="0" cellspacing="0" border="0" id="m_-2588793581771457621backgroundTable">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%">
                                                            <table background-color="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table width="560" align="center" cellpadding="0" cellspacing="0" border="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="font-family:Helvetica,arial,sans-serif;font-weight:bold;font-size:13px;color:#1f1f1f;text-align:left;line-height:18px">
                                                                                        VUI LÒNG CHÚ Ý TRƯỚC KHI LÊN XE
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="100%" height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;text-align:left;line-height:18px">
                                                                                        Dưới đây là liên kết dẫn đến mã QR. Trước khi lên xe quý khách vui lòng xuất trình mã QR này cho hướng dẫn viên du lịch kiểm tra: <br/> <br/> 
                                                                                        <a href="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$code.'">https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$code.'</a><br/><br/>
                                                                                        Chúc bạn luôn có những trải nghiệm tuyệt vời khi du lịch!.
                                                                                    </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="100%" height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="100%" height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                    <td style="font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;text-align:left;line-height:18px">
                                                                                        <br>
                                                                                        Trân trọng,<br>
                                                                                        Nhóm phát triển Website Du Lịch
                                                                                    </td>
                                                                                    </tr>
                                                                            </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                        </div>'; 
                                        if($send->sendMail('Đơn hàng đặt tour', $content,' ',$_SESSION['email'])){   
                                            unset($_SESSION['tour_id']);
                                            unset($_SESSION['fullname']);
                                            unset($_SESSION['email']);
                                            unset($_SESSION['phone']);
                                            unset($_SESSION['quantity']);
                                            unset($_SESSION['total']);
                                        } 
                                } 
                                echo '<script>alert("Đặt tour thành công! Vui lòng kiểm tra email của bạn!")</script>';
                            } else {
                                unset($_SESSION['tour_id']);
                                unset($_SESSION['fullname']);
                                unset($_SESSION['email']);
                                unset($_SESSION['phone']);
                                unset($_SESSION['quantity']);
                                unset($_SESSION['total']);                               
                                echo '<script>alert("Đặt tour không thành công!")</script>';
                            }
                        } else {
                            echo "Chu ky khong hop le";
                        }
                        ?>

                    </label>
                    <br>
                    <a href="../home.php">
                        <button>Quay lại</button>
                    </a>
                </div> 
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                   <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
    </body>
</html>
