<?php
session_start();
require "includes/userHandler.php";
require "includes/contentHandler.php";
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
{
    require "includes/header-logined.php";
}
else{
   header ("Location: admin/quanlytour.php");
}


?>
<?php
$id = 0;
if(isset($_SESSION["id_user"])){
    $id = $_SESSION["id_user"];
}
$cth = new userHandler();
$result = $cth->userAccount($id);
$row = $result->fetch_assoc();
?>
<?php
if(isset($_POST['update'])){ 
    $fullname = $_POST["fullName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    if(empty($_POST["oldpass"]) && !empty($_POST["newpass"])){
      echo("    
      <script>
       alert('Vui lòng nhập mật khẩu hiện tại!');
       location.href = 'manage_info.php';
      </script>");
    }
    if(!empty($_POST["oldpass"]) && !empty($_POST["newpass"])) {
        $oldpass = $_POST["oldpass"];
        $newpass = $_POST["newpass"];
        $change = $cth->changePass($id, $oldpass, $newpass);
        if($change){
            echo("    
            <script>
             alert('Cập nhật mật khẩu thành công');
            location.href = 'manage_info.php';
            </script>");
        }
        else{
            echo("
            <script>
            alert('Cập nhật mật khẩu thất bại');
            </script>");   
        }
    }
    else {
        $result = $cth->updateAccount($id, $fullname, $email, $phone);     
        if($result){
            echo("    
            <script>
            alert('Cập nhật thông tin thành công');
            location.href = 'manage_info.php';
            </script>");
        }
        else{
            echo("
            <script>
            alert('Cập nhật thông tin thất bại');
            </script>");
        }   
    }
    
    
}
?>

    <!-- Start-Manage-Profile -->
    <div id="app">
        <section class="g_main margin-top-0">
            <ul class="sidebar g_left j_side_menu">
                <li>
                    <div class="profile_box g_rel">
                        <div class="profile_avatar">
                            <label for="avatar">
                                <span class="klook-symbol t28 g_v_c_mid camera"><i class="fa-camera"
                                        aria-hidden="true"></i></span>
                            </label>
                            <input type="file" name="avatar" id="avatar" class="f_hidden"
                                accept="image/png, image/jpg, image/jpeg">
                            <img width="100" height="100" class="avatar_url" src="assets/img/avatar.png" alt="">
                            <div class="profile-loading f_hidden"><i></i></div>
                        </div>
                        <h3><?php echo $row['full_name']; ?></h3>
                    </div>
                    <div class="entrances_box">
                        <div class="entrances_box_hover">
                            <a href="manage_info.php">
                                <span class="active-profile">Quản lý thông tin</span>
                            </a>
                        </div>
                        <div class="entrances_box_hover">
                            <a href="order-all.php">
                                <span>Đơn hàng</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="content_box g_rel g_right">
                <div class="box_header content_header">
                    <h1 class="title">Thông tin tài khoản</h1>
                </div>
                <div class="box_body">
                    <form action="manage_info.php" method="POST">
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-login">
                                    <label>Tên đăng nhập</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-login-name">
                                        <div class="value-login"><?php echo $row['username']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-name">
                                    <label>Họ Và Tên</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="text" placeholder="" name="fullName" maxlength="255" value="<?php echo $row['full_name']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-login">
                                    <label>Email</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="email" placeholder="" name="email" maxlength="255" value="<?php echo $row['email']; ?>">
							                <span>Email phải là một địa chỉ hợp lệ, ví dụ: me@mydomain.com</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-login">
                                    <label>Số điện thoại</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="text" placeholder="" name="phone" maxlength="255" value="<?php echo $row['phone']; ?>">
							                <span>Điện thoại phải là số điện thoại hợp lệ của Việt Nam (10 chữ số)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-name">
                                    <label>Mật Khẩu Hiện Tại</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="password" name="oldpass" class="oldpass">
							                <span class="error-text-oldpass"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-name">
                                    <label>Mật Khẩu Mới</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="password" name="newpass" class="pswrd_1">
							                <span>Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số, một chữ hoa và chữ thường</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="area-info">
                            <div class="input-info">
                                <div class="label-name">
                                    <label>Xác Nhận Mật Khẩu</label>
                                </div>
                                <div class="area-input-info">
                                    <div class="input-with-validator-wrapper">
                                        <div class="input-with-validator">
                                            <input type="password" name="renewpass" class="pswrd_2">
							                <span class="error-text"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-save">
                            <button type="submit" name="update" class="btn-save" id="save">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- End-Manage-Profile -->
    <script>
        const inputs = document.querySelectorAll('input');
// regex patterns
		const patterns = {
				phone: /^(086|096|097|098|032|033|034|035|036|037|038|039|088|091|094|083|084|085|081|082|070|076|077|078|079|089|090|093|093|056|058|099|059)\d{7}$/,
				newpass: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/,
				email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/
		};

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
                document.getElementById('save').disabled = !validate(e.target, patterns[e.target.attributes.name.value]);
            });
        });
        const pswrd_1 = document.querySelector(".pswrd_1");
		const pswrd_2 = document.querySelector(".pswrd_2");
        const pswrd_3 = document.querySelector(".oldpass")
        const errorTextPass = document.querySelector(".error-text-oldpass");
		const errorText = document.querySelector(".error-text");
		const btn = document.querySelector("button");

        pswrd_2.addEventListener('keyup', (e) => {
            if(pswrd_1.value !== pswrd_2.value){
            errorText.style.display = "block";
            errorText.classList.remove("matched");
            errorText.textContent = "Mật khẩu không khớp!"; 
            document.getElementById('save').disabled = true;
           }
           else {
            errorText.style.display = "none";
            document.getElementById('save').disabled = false;
           }
        });
    </script>
<?php
require_once "includes/footer.php";
?>