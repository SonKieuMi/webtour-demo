<?php
require_once "includes/header.php";
require_once "includes/userHandler.php";
session_start();
if(isset($_SESSION['reset_pwd'])){
	if($_SESSION['reset_pwd']==true){
		unset($_SESSION['reset_pwd']);
	}
	else{
		header("Location: login.php");
	}	
}
else{
	if(isset($_POST["reset"])){
		if(isset($_SESSION['emailUser'])){
			$email=$_SESSION['emailUser'];
		}
		$password = $_POST["password"];
		$uhd = new userHandler();
		$result = $uhd->reset($email,$password);
		echo(" <script>alert('Đổi mật khẩu thành công');
		location.href = 'login.php';
		</script>");		
	}
	else{
		echo(" <script>alert('Trang Không thể truy cập');
		location.href = 'login.php';
		</script>");	
	}

}



?>

<!-- Start Reset -->
<section class="login-form">
		<div class="overlay">
			<div class="wrapper">
				<div class="form-section">
					<h3 class="reset_pd">Đặt Lại Mật Khẩu </h3>	
					<form action="reset_pwd.php" method="post" class="signin-form">
          				<div class="form-input">
							<input type="password" class="pswrd_1" name="password" placeholder="Mật khẩu" required="">
							<span>Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số, một chữ hoa và chữ thường</span>
						</div>
						<div class="form-input">
							<input type="password" class="pswrd_2" name="repassword" placeholder="Nhập Lại Mật khẩu" required="">
							<span class="error-text"></span>
						</div>
						<button type="submit" class="btn-primary theme-button mt-4" name="reset">Tiếp Tục</button>						
					</form>
				</div>
			</div>
		</div>
		<div class="clear"> </div>
	</section>
	<script>
	const inputs = document.querySelectorAll('input');
// regex patterns
		const patterns = {
					password: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/
		};
// validation function
		function validate(field, regex){

				if(regex.test(field.value)){
						field.className = 'valid';
				} else {
						field.className = 'invalid';
				}
		}
		// attach keyup events to inputs
		inputs.forEach((input) => {
				input.addEventListener('keyup', (e) => {
								//console.log(patterns[e.target.attributes.name.value]);
								validate(e.target, patterns[e.target.attributes.name.value]);
				});
		});

				const pswrd_1 = document.querySelector(".pswrd_1");
				const pswrd_2 = document.querySelector(".pswrd_2");
				const errorText = document.querySelector(".error-text");
				const btn = document.querySelector("button");

				btn.onclick = function(){
           if(pswrd_1.value != pswrd_2.value){
             errorText.style.display = "block";
             errorText.classList.remove("matched");
             errorText.textContent = "Mật khẩu không khớp!";
             return false;
           }
         }
	</script>
    <!-- End Reset -->

<?php
require_once "includes/footer.php";
?>