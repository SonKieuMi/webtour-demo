<?php
session_start();

$total = 0;
require_once "includes/header-logined.php";
require "includes/contentHandler.php";
require_once "mail/mailHandler.php";
?>
<?php
if(isset($_SESSION['tendangnhap'])){
    if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
    {      
    }
    else{
       header ("Location: admin/quanlytour.php");
    }
}
else {
    echo(" <script>location.href = 'home.php';</script>");
}
date_default_timezone_set("Asia/Ho_Chi_Minh");
$cth = new contentHandler();
$id = htmlspecialchars($_GET["id"]);
$result = $cth->tourDetail($id);
$row =  $result->fetch_assoc();
$_SESSION['name_tour'] = $row['name_tour'];
?>
<?php
$quantity = 1;
?>
    <!-- Start-Content-->
    <div class="order-set">
        <form action="vnpay/vnpay_create_payment.php" id="create_form" method="post">    
        <!-- <form action="book-tour.php?id=$id" method="POST"> -->
            <article class="order-main">
                <div class="order-top">
                    <header class=order-header>
                        <span class="order-header-title">Bước 1: Điền thông tin</span>
                    </header>
                    <div class="slide-down-box">
                        <div class="order-tips">
                            <div class="order-fill-tip">
                                <div class="tip-warning">
                                    <p class="tip-message">Hãy điền thông tin chính xác. Một khi đã gửi thông
                                        tin, bạn sẽ không thay đổi được</p>
                                </div>
                            </div>
                        </div>
                        <section class="section-order">
                            <h2 class="section-title">Thông tin đơn hàng
                                <div class="section-tips"></div>
                            </h2>
                            <div class="section-main">
                                <div class="traveler-info-standard">
                                    <div class="traveler-info-standard-main">
                                        <div class="traveler-info-standard-head">
                                            <img src="<?php echo $row['image'] ?>" alt="">
                                            <div class="head-content">
                                                <p class="head-content-activity-name"><?php echo $row['name_tour']; ?></p>
                                                <div class="type-money-order">
                                                    <div class="total-type-money-order">
                                                        <div class="name-type-order">Số tiền:</div>
                                                        <div class="type-price-order"><?php 
                                                        $price = $row['price'];
                                                        echo number_format($price); ?> VND</div>
                                                        <div class="multi-sign-order">x </div>
                                                        <div class="amount-order"><?php 
                                                        if(isset($_POST["quantity"])) { 
                                                            $quantity = $_POST["quantity"];
                                                            echo $quantity;
                                                        } 
                                                        else {                                                           
                                                            echo $quantity;
                                                        }?></div>   
                                                        <input type="hidden" name="quantity" value="<?php  echo $quantity; ?>" />                                                    
                                                    </div>
                                                </div>                                                
                                                <div class="type-money-order">
                                                    <div class="total-type-money-order">
                                                        <div class="name-type-order">Tổng số tiền:</div>
                                                        <div class="total-money-order total-type-price-order"><?php 
                                                        $total = $price*$quantity;
                                                        echo number_format($total);
                                                        ?> VND
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="section-contact">
                            <h2 class="section-title">Thông tin liên lạc:
                                <div class="section-tips"></div>
                            </h2>
                            <span class="section-tips1">Chúng tôi sẽ thông báo mọi thay đổi về đơn hàng cho bạn</span>
                            <input id="tour_id" name="tour_id" type="hidden" value="<?php echo $id ?>"/>
                            <input id="order_id" name="order_id" type="hidden" value="<?php echo date("YmdHis") ?>"/>
                            <input type="hidden" name="order_type" id="order_type" value="billpayment">
                            <input type="hidden" name="order_desc" id="order_desc" value="Thanh toan Tour">
                            <div class="section-main">
                                <div class="contact-info-standard">
                                    <div>
                                        <div class="standard-form-module">
                                            <div class="dynamic-form-wrap">
                                            <div class="dynamic-form-module">
                                                <p class="dynamic-form-title">
                                                    Họ và Tên
                                                    <span class="isRequired">*</span>
                                                </p>
                                                <div class="klk-form-item">
                                                    <div class="form-item-content">
                                                        <div class="dynamic-form-input">
                                                            <div class="klk-input">
                                                                <div class="klk-input-inner">
                                                                    <input type="text" placeholder="Vd: Nguyen Van" name="fullname" spellcheck="false">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dynamic-form-wrap">
                                            <div class="dynamic-form-module">
                                                <p class="dynamic-form-title">
                                                    Số Điện Thoại
                                                    <span class="isRequired">*</span>
                                                </p>
                                                <div class="klk-form-item">
                                                    <div class="form-item-content">
                                                        <div class="dynamic-form-input">
                                                            <div class="klk-input">
                                                                <div class="klk-input-inner">
                                                                    <input type="tel" placeholder="Vd: 0123456789" name="phone" id="phone" spellcheck="false">
                                                                    <span>Điện thoại phải là số điện thoại hợp lệ của Việt Nam (10 chữ số)</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dynamic-form-wrap">
                                            <div class="dynamic-form-module">
                                                <p class="dynamic-form-title">
                                                    Email
                                                    <span class="isRequired">*</span>
                                                </p>
                                                <div class="klk-form-item">
                                                    <div class="form-item-content">
                                                        <div class="dynamic-form-input">
                                                            <div class="klk-input">
                                                                <div class="klk-input-inner">
                                                                    <input type="email" placeholder="Vd: NguyenVa@gmail.com" name="email" id="email" spellcheck="false">
							                                        <span>Email phải là một địa chỉ hợp lệ, ví dụ: me@mydomain.com</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </article>
            <article class="order-main-pay">
                <div class="order-top">
                    <header class="order-header">
                        <span class="order-header-title">Bước 2: Thanh Toán</span>
                    </header>
                    <input type="hidden" name="bank_code" id="bank_code" value="">
                    <input type="hidden" name="language" id="language" value="vn">
                    <div class="slide-down-box">
                        <section class="section-order">
                            <div class="type-money">
                                <div class="total-type-money">
                                    <div class="name-type">Tổng thanh toán:</div>
                                    <div class="total-money total-type-price"><?php  echo number_format($total) ?> VND</div>
                                    <input type="hidden" class="total-money total-type-price" id="total" name="total" value="<?php  echo $total; ?>" />
                                </div>
                            </div>
                            <div class="book-tour">
                                <div class="button-submit-book">
                                    <button class="btn-submit-book" type="submit" name="booktour" id="booktour">Đặt Tour</button>
                                </div>
                        </div>
                        </section>
                    </div>
                </div>
            </article>
        </form>
    </div>
    <!-- End-Content-->
<script>
    	const inputs = document.querySelectorAll('input');
// regex patterns
		const patterns = {
			phone: /^(086|096|097|098|032|033|034|035|036|037|038|039|088|091|094|083|084|085|081|082|070|076|077|078|079|089|090|093|093|056|058|099|059)\d{7}$/,
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
					document.getElementById("book").disabled = !validate(e.target, patterns[e.target.attributes.name.value]);
				});
		});
</script>
<?php
require_once "includes/footer.php";
?>