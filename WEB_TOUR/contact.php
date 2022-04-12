<?php
$page = 'contact';
require_once "includes/header.php";
require_once "includes/userHandler.php";
require_once "mail/mailHandler.php";
session_start();
if(isset( $_SESSION['tendangnhap'] ) )
{
    if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
    {
        
    }
    else{
       header ("Location: admin/quanlytour.php");
    }
    require "includes/header-logined.php";
}
else{
   require "includes/header.php";
}

	
	

if(isset($_POST['send'])){
    if(isset($_SESSION['tendangnhap'])){
    $txtHoTen=$_POST['txtHoTen'];
    $txtEmail=$_POST['txtEmail'];
    $txtDienThoai=$_POST['txtDienThoai'];
    $txtDiaChi=$_POST['txtDiaChi'];
    $txtTieuDe=$_POST['txtTieuDe'];
    $txtNoiDung=$_POST['txtNoiDung'];
    $send = new mailHandler();
    $content="<strong>Họ tên:</strong> $txtHoTen<br/>
    <strong>Email:</strong> $txtEmail<br/>
    <strong>Điện thoại:</strong> $txtDienThoai<br/>
    <strong>Địa chỉ:</strong> $txtDiaChi<br/>
    <strong>Tiêu đề:</strong> $txtTieuDe<br/>
    <strong>Nội dung:</strong> $txtNoiDung<br/>";
    if($send->sendMail('Liên Hệ',$content,' ',$_POST['txtEmail'])){
        if(isset($_POST['txtEmail'])){
			$email=$_POST['txtEmail'];      
			$uhd = new userHandler();
			$checkemail = $uhd->checkEmail($email);
			$resultCheck = mysqli_fetch_row($checkemail);
            if($resultCheck){
				echo("    
				<script>
				alert('Gửi mail thành công');
				</script>");   
            }
            else{
                echo("    
                <script>
                alert('Gửi mail thất bại');
                </script>");
                }
    }
else{
		echo("    
        <script>
        alert('Gửi mail thất bại');
        </script>");
	 }
     
    }
}

    

}
?>

<div class="container n3-contact">
        <div class="row">
            <div class="col-xs-12 mg-bot15">
                <div class="title title-contact mg-bot15">
                    <h1>LIÊN HỆ</h1>
                </div>
                <div class="text-center">Để có thể đáp ứng được các yêu cầu và các ý kiến đóng góp của quý vị một cách
                    nhanh chóng xin vui lòng liên hệ</div>
            </div>
            <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.427573076779!2d106.78318431402464!3d10.855047960707676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527c3debb5aad%3A0x5fb58956eb4194d0!2zxJDhuqFpIEjhu41jIEh1dGVjaCBLaHUgRQ!5e0!3m2!1svi!2s!4v1647935187884!5m2!1svi!2s" 
                width="800" height="300" style="border:0"  
                allowfullscreen="" loading="lazy"></iframe>
        </div>
            <div class="col-xs-12 mg-bot50">
                <form action="contact.php"  method="post" class="signin-form">
                    <input name="__RequestVerificationToken" type="hidden">
                    <div class="frame-contact">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mg-bot15">
                                <label>Họ tên (<span class="star">*</span>)</label>
                                <input type="text" class="form-control" required="required" name="txtHoTen"
                                    id="txtHoTen">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mg-bot15">
                                <label>Email (<span class="star">*</span>)</label>
                                <input type="email" class="form-control" required="required" name="txtEmail"
                                    id="txtEmail">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mg-bot15">
                                <label>Điện thoại (<span class="star">*</span>)</label>
                                <input type="text" class="form-control" required="required" name="txtDienThoai"
                                    id="txtDienThoai">
                            </div>
                            <div class="col-xs-12 mg-bot15">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" name="txtDiaChi">
                            </div>
                            <div class="col-xs-12 mg-bot15">
                                <label>Tiêu đề (<span class="star">*</span>)</label>
                                <input type="text" class="form-control" required="required" name="txtTieuDe">
                            </div>
                            <div class="col-xs-12 mg-bot30">
                                <label>Nội dung (<span class="star">*</span>)</label>
                                <textarea class="form-control" rows="4" cols="5" required="required"
                                    name="txtNoiDung"></textarea>
                            </div>
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn-contact" name="send">Gửi đi</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
require_once "includes/footer.php";
?>