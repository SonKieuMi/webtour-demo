<?php
require_once "includes/userHandler.php";
session_start();
if(isset($_POST["login"])){
    if($_POST["username"]==null){
        echo("chua nhap ussername");
    }
    if($_POST["password"]==null){
        echo("chua nhap password");
    }
    if($_POST["username"]!=null&&$_POST["password"]!=null){
        $username =$_POST["username"];
        $password = $_POST["password"];
        $uhd = new userHandler();
        $result = $uhd->login($username,$password);
        $user = mysqli_fetch_array($result);
				if($user) {		
					$_SESSION["id_user"] = $user["id"];
					$_SESSION["tendangnhap"] = $user["username"];
					$_SESSION["userrole"] = $user["user_role"];				
					if( $_SESSION['userrole'] == "ROLE_ADMIN" )
          {
              echo(" <script>alert('Đăng nhập thành công');
                location.href = 'quanlytour.php';
                </script>");
          }
					if(!empty($_POST["remember"])) {
						setcookie ("member_login",$_POST["username"],time() + 86400*30);
						setcookie ("member_password",$_POST["password"],time() + 86400*30);
					} else {
						if(isset($_COOKIE["member_login"])) {
							setcookie ("member_login","",time() - 86400*30);
						}
						if(isset($_COOKIE["member_password"])) {
							setcookie ("member_password","",time() - 86400*30);
						}
					}
				}else {
					$message = "Mật khẩu hoặc tài khoản bị sai!";
				}
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập quản trị viên</title>
  <link rel="stylesheet" href="css_dashboard/style-rtl.css">
</head>
<body>
<section class="login-form">
		<div class="overlay">
			<div class="wrapper">
				<div class="form-section">
					<h3>Chào mừng đến với trang đăng nhập của quản trị viên</h3>	
					<form action="login.php" method="post" class="signin-form">
						<div class="form-input">
							<input type="text" name="username" placeholder="Tên tài khoản" required="" autofocus value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>"/>
							<span>Tên tài khoản phải là chữ và số, và có 5 - 12 ký tự</span>
						</div>
						<div class="form-input">
							<input type="password" name="password" placeholder="Mật khẩu" required="" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>"/>
							<span>Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số, một chữ hoa và chữ thường</span>
						</div>
            <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>
						<div class="check-remain">
							<input type="checkbox" name="remember" class="checkbox" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
							<label class="remember">Nhớ mật khẩu</label>
						</div>
						<button type="submit" class="btn-primary theme-button mt-4"name="login">Đăng Nhập</button>
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
  username: /^[a-z0-9].{4,11}$/,
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

</script>
</body>
</html>