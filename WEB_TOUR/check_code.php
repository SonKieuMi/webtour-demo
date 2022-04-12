<?php
require_once "includes/header.php";
require_once "includes/userHandler.php";
require_once "mail/mailHandler.php";
session_start();
if(isset($_POST["checkcode"]) && $_POST['code']){
	$code=$_POST['code'];
	// tìm cách lưu  $code lại chuyển qua màn hình nhập code. Sau đó so sánh code nhập với $code đúng thì cho đặt lại mật khẩu.
	if(isset($_SESSION['code']) && (time() - $_SESSION['timeOut'] > (60*60*24))){
		unset($_SESSION['code']);
		unset($_SESSION['timeOut']);
		unset($_SESSION['emailUser']);
		echo ("    
        <script>
        alert('Quá thời gian nhập code!');
        location.href = 'forgot_pwd.php';
        </script>");	
	}
	else{
		if(isset($_SESSION['code'])&& trim($_SESSION['code'])== trim($code)){
			// gan co de truy cap duoc trAng resetpass
			unset($_SESSION['code']);	
			unset($_SESSION['timeOut']);
			$_SESSION['reset_pwd'] = true;
			echo ("    
			<script>
			alert('Nhập code thành công!');		
			location.href = 'reset_pwd.php';	
			</script>");	
		}
		else{
			echo("    
			<script>
			alert('Sai code vui lòng nhập lại!');
			</script>");
		}
	}
}
?>
<!-- Start Login -->
<section class="login-form">
		<div class="overlay">
			<div class="wrapper">
				<div class="form-section">
					<h3 class="reset_pd">Nhập mã code </h3>	
					<form action="check_code.php" method="post" class="signin-form">
						<div class="form-input">
							<p class="notice">Vui lòng nhập đúng mã mà chúng tôi gửi cho bạn ở trong tài khoản mail</p>
							<input type="text" name="code"  required="" autofocus />
						</div>
						<button id = "btnCheck"   type="submit" class="btn-primary theme-button mt-4" name="checkcode">Xác Nhận</button>			
					</form>
				</div>
			</div>
		</div>
		<div class="clear"> </div>
	</section>
    <!-- End Forgot -->

<?php
require_once "includes/footer.php";
?>