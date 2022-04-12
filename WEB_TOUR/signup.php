<?php
require_once "includes/header.php";
require_once "includes/userHandler.php";
session_start();
if(isset($_POST["signup"])){
    if($_POST["username"] == null){
        echo("Chưa nhập user name");
    }
    if($_POST["password"] == null){
        echo("Chưa nhập password");
    }
	//kiem tra password nhập lại có giống không  password and repassword
    if($_POST["username"] != null && $_POST["password"] != null){
        $fullname = $_POST["fullName"];
				$email = $_POST["email"];
				$phone = $_POST["phone"];
				$username =$_POST["username"];
        $password = $_POST["password"];
        // post is active lấy đâu ra ?????
        $uhd = new userHandler();
				$checkUsername = $uhd->checkUsername($username);
				$resultCheck = mysqli_fetch_row($checkUsername);
				if($resultCheck) {
					echo "Username đã tồn tại!";
				}
				else {
					$signup = $uhd->signup($fullname,$email,$phone,$username,$password);      
					if($signup){
					echo("    
								<script>
								alert('Đăng ký thành công');
								location.href = 'login.php';
							</script>");
					}
				// else{
				// 	echo("
				// 	<script>
				// 	alert('Đăng ký thất bại');
				// </script>");
				// }
				}
    }
}
?>
<section class="signup-form">
		<div class="overlay">
			<div class="wrapper">
				<div class="form-section">
					<h3>Đăng Kí</h3>	
					<p class="login">Bạn đã có tài khoản? <a href="login.html" class="login-link">Đăng nhập</a></p>
					<form action="signup.php" method="post" class="signin-form">
						<div class="form-input">
							<input type="text" name="fullName" placeholder="Họ và Tên" required="" autofocus>
						</div>
						<div class="form-input">
							<input type="email" name="email" placeholder="Email" required="" onblur="checkEmail(this.value)"/>
							<span>Email phải là một địa chỉ hợp lệ, ví dụ: me@mydomain.com</span>
							<span id="error-mail"></span>	
						</div>
						<div class="form-input">
							<input type="tel" name="phone" placeholder="Số điện thoại" required="" pattern="^\d{10}$"/>
							<span>Điện thoại phải là số điện thoại hợp lệ của Việt Nam (10 chữ số)</span>
						</div>
						<div class="form-input">
							<input type="text" name="username" placeholder="Tên tài khoản" required="" onblur="checkUsername(this.value)"/>
							<span>Tên tài khoản phải là chữ và số, và có 5 - 12 ký tự</span>
							<span id="error-username"></span>	
						</div>
						<div class="form-input">
							<input type="password" class="pswrd_1" name="password" placeholder="Mật khẩu" required="">
							<span>Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số, một chữ hoa và chữ thường</span>
						</div>
						<div class="form-input">
							<input type="password" class="pswrd_2" name="repassword" placeholder="Nhập Lại Mật khẩu" required="">
							<span class="error-text"></span>
						</div>
						<button type="submit" class="btn-primary theme-button mt-4"name="signup" id="reg">Đăng Ký</button>
					</form>
				</div>
			</div>
		</div>	
		<div class="clear"> </div>
	</section>
	<script>
		function checkEmail(email){
			$.post('checkemail.php', {'email': email}, function(data){
				var result = data.trim() === "true";
						if(result) {
							$("#error-mail").text("Email đã tồn tại!");
							$("#reg").attr({
									"disabled": ''
							});
						}else {
							$("#error-mail").text("");
							$("#reg").removeAttr("disabled");
						}			
			});
		}

		function checkUsername(username){
			$.post('checkusername.php', {'username': username}, function(data){
				var result = data.trim() === "true";
						if(result) {
							$("#error-username").text("Username đã tồn tại!");
							$("#reg").attr({
									"disabled": ''
							});
						}else {
							$("#error-username").text("");
							$("#reg").removeAttr("disabled");
						}			
			});
		}

		const inputs = document.querySelectorAll('input');
// regex patterns
		const patterns = {
					phone: /^(086|096|097|098|032|033|034|035|036|037|038|039|088|091|094|083|084|085|081|082|070|076|077|078|079|089|090|093|093|056|058|099|059)\d{7}$/,
					username: /^[a-z0-9].{4,11}$/,
					password: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/,
					email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/
		};
// validation function
		function validate(field, regex){
				if(regex.test(field.value)){
						field.className = 'valid';
						return true;
				} else {
						field.className = 'invalid';
						return false;
				}
		}
		// attach keyup events to inputs
		inputs.forEach((input) => {
				input.addEventListener('keyup', (e) => {
								//console.log(patterns[e.target.attributes.name.value]);
							document.getElementById("reg").disabled = !validate(e.target, patterns[e.target.attributes.name.value]);
				});
		});

				const pswrd_1 = document.querySelector(".pswrd_1");
				const pswrd_2 = document.querySelector(".pswrd_2");
				const errorText = document.querySelector(".error-text");
				const btn = document.querySelector("button");

				pswrd_2.addEventListener('keyup', (e) => {
                            //console.log(patterns[e.target.attributes.name.value]);
					if(pswrd_1.value !== pswrd_2.value){
						errorText.style.display = "block";
						errorText.classList.remove("matched");
						errorText.textContent = "Mật khẩu không khớp!"; 
						document.getElementById('reg').disabled = true;
           }
           else {
            errorText.style.display = "none";
						document.getElementById('reg').disabled = false;
           }
        });
	</script>

<?php
require_once "includes/footer.php";
?>