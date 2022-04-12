<?php
require_once "includes/header.php";
require_once "includes/userHandler.php";
require_once "mail/mailHandler.php";
session_start();
if(isset($_POST["forgot"]) && $_POST['email']){
     $send = new mailHandler();
	 $code = (int)((mt_rand(0, mt_getrandmax())/mt_getrandmax())*1000000); // đây là code 6 số ramdom. 123456 644846
	 // tìm cách lưu  $code lại chuyển qua màn hình nhập code. Sau đó so sánh code nhập với $code đúng thì cho đặt lại mật khẩu.
	 $content='<div style="margin:0;padding:0;line-height:20px;color:#333;background:#f5f5f5">
	 <div style="background:#f5f5f5;padding-top:16px">
				<div style="width:600px;margin:0 auto 0;background:#fff">
						<table align="center" cellspacing="0" cellpadding="0" style="padding:40px 50px 34px;color:#424242">
								<tbody><tr>
										<td>
												<p style="margin:0;margin-bottom:20px;font-weight:bold">Chào Người dùng,</p>
												<p style="margin:0;margin-bottom:10px;line-height:1.64;font-size:14px;color:#333">Có vẻ như bạn đã quên mật khẩu tài khoản. Không phải lo lắng, chỉ cần làm nhập code này để tạo một mật khẩu mới:</p>
												<p style="font-size: 30px;text-align:center;margin:15px;">'. $code .'</p>
										</td>
								</tr>
								<tr>
										<td>
												<p style="width:500px;font-size:14px;line-height:1.64;color:#333333;margin-bottom:26px">
													 Để đảm bảo tính bảo mật cho tài khoản của bạn, code chỉ có hiệu lực trong 24 giờ. Nếu code đã hết hạn, vui lòng gửi lại yêu cầu quên mật khẩu. Nếu bạn không quên mật khẩu của mình và thông báo này đã được gửi sai, chỉ cần bỏ qua email này.
												</p>
										</td>
								</tr>
								<tr>
										<td>
												<p style="margin:0;font-size:14px;line-height:1.5;color:#4a4a4a">Cám ơn,<br>
														Nhóm phát triển Website Du Lịch</p>
												<p style="padding-bottom:12px;border-bottom:1px solid #f5f5f5;margin:0"></p>
										</td>
								</tr>
						</tbody>
						</table>
						<div style="background-color:#f5f5f5">
								<div style="text-align:center">
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#f5f5f5;border-collapse:collapse;margin-top:30px;margin-bottom:30px;font-size:14px;border-radius:6px">
												<tbody><tr style="font-size:12px;line-height:18px;color:#999">
															 <td style="width:500px;text-align:center;padding-bottom:16px;padding-top:16px">
																	 <p style="margin:0">Bạn có thắc mắc? Hãy liên lạc với chúng tôi!</p>          
															 </td>
														 </tr>
														 <tr>
															 <td style="height:1px;background-color:#ddd"></td>
														 </tr>
														 <tr style="font-size:12px;line-height:18px;color:#999">
																 <td style="text-align:center;padding-top:16px">
																		 <p style="margin:0">Nếu bạn nhận được thông báo này do nhầm lẫn, vui lòng không chuyển tiếp nội dung thông báo này, thông báo cho người gửi và xóa bất kỳ tài liệu đính kèm nào. Thông điệp này có thể chứa thông tin bí mật và được đặc quyền hợp pháp. Nếu không phải là người nhận, bạn không được sử dụng, sao chép hoặc tiết lộ cho bất cứ nội dung nào trong thông báo này.</p>
																		 <p style="margin:0;margin-top:30px;font-size:12px;line-height:1.5;text-align:center;color:#999">©2021 Travel Technology Limited. All Rights Reserved.</p>
																 </td>
														 </tr>
											 </tbody>
										</table>
								</div>
						</div>
				</div>
		</div>
 </div>';
	 if($send->sendMail('Quên Mật Khẩu',$content,' ',$_POST['email'])){
		$_SESSION['code'] =  $code;	
		$_SESSION['timeOut'] = time();
		$_SESSION['emailUser']=$_POST['email'];
		if(isset($_SESSION['emailUser'])){
			$email=$_SESSION['emailUser'];
			$uhd = new userHandler();
			$checkemail = $uhd->checkEmail($email);
			$resultCheck = mysqli_fetch_row($checkemail);
			if($resultCheck){
				echo("    
				<script>
				alert('Gửi mail thành công');
				location.href = 'check_code.php';
				</script>");
			}else{
				echo("    
						<script>
								alert('Email không tồn tại');
								location.href = 'login.php';
						</script>");
			}

		}
	 }
       
 }
?>

<!-- Start Login -->
<section class="login-form">
		<div class="overlay">
			<div class="wrapper">
				<div class="form-section">
					<h3 class="reset_pd">Đặt Lại Mật Khẩu </h3>	
					<form action="forgot_pwd.php" method="post" class="signin-form">
						<div class="form-input">
							<p class="notice">Nhập địa chỉ email sử dụng để tạo tài khoản Klook và chúng tôi sẽ gửi link để đặt lại tài khoản đến bạn</p>
							<input type="text" name="email" placeholder="Email" required="" autofocus />
							<span>Email phải là một địa chỉ hợp lệ, ví dụ: me@mydomain.com</span>
						</div>
						<button id = "btnForgot" type="submit" disabled class="btn-primary theme-button mt-4" name="forgot">Tiếp Tục</button>						
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
			document.getElementById("btnForgot").disabled=!validate(e.target, patterns[e.target.attributes.name.value]);
			});
	});
	</script>
    <!-- End Forgot -->
<?php
require_once "includes/footer.php";
?>