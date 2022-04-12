<?php
session_start();

require "../includes/contentHandler.php";
require_once "../mail/mailHandler.php";

$cth = new contentHandler();

error_reporting(E_ALL & ~E_NOTICE & ~ E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

/**
 * Description of vnpay_ajax
 *
 * @author xonv
 */
require_once("config.php");

$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_Tour = $_POST['tour_id'];
$vnp_OrderInfo = $_POST['order_desc'];
$vnp_OrderType = $_POST['order_type'];
$vnp_Amount = $_POST['total'] * 100;
$vnp_Locale = $_POST['language'];
$vnp_BankCode = $_POST['bank_code'];
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//Add Params of 2.0.1 Version
//Billing
$vnp_Bill_Mobile = $_POST['phone'];
$vnp_Bill_Email = $_POST['email'];
$vnp_Bill_FullName = $_POST['fullname'];
// Invoice
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
    "vnp_Bill_Email"=>$vnp_Bill_Email,
    "vnp_Bill_FullName"=>$vnp_Bill_FullName,
    "vnp_Tour"=>$vnp_Tour
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

$_SESSION['tour_id'] = $_POST['tour_id'];
$_SESSION['fullname'] = $_POST['fullname'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['quantity'] = $_POST['quantity'];
$_SESSION['total'] = $_POST['total'];
//Add Params of 2.0.1 Version
//Billing


//var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
$returnData = array('code' => '00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    if (isset($_POST['booktour'])) {
        if(!empty($_POST['fullname']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['total']) && !empty($_POST['quantity'])){
            header('Location: ' . $vnp_Url);
        }
        else {
                echo("<script>alert('Vui lòng điền đủ thông tin trước khi thanh toán!');
                </script>");
                header('Location: ../book-tour.php?id=' . $vnp_Tour);
            }
    }
    else {
        echo json_encode($returnData);
    }
