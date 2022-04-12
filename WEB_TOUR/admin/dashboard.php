<?php
$page = 'dashboard';
require_once "sideleft.php";
?>
<?php
session_start();
//Hàm session_start () được sử dụng để bắt đầu một phiên mới hoặc tiếp tục một phiên hiện có.
if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_ADMIN")
{
    
}
else{
   header ("Location: /WEB_TOUR/home.php");
}
?>
	<section class="dashboard-area dashboard-main">
		<div class="dashboard-content-wrap">
			<div class="dashboard-bread">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-6">
							<div class="breadcrumb-content">
								<div class="section-heading">
									<h2 class="sec__title font-size-30 text-white">Thống Kê Doanh Thu</h2>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-1 responsive-column-m">
							<div class="icon-box icon-layout-2 dashboard-icon-box">
								<div class="d-flex">
									<div class="info-content">
										<p class="info__desc">Số lượng đặt tour</p>
										<h4 class="info__title">44</h4>
									</div><!-- end info-content -->
								</div>
							</div>
						</div><!-- end col-lg-1 -->
						<div class="col-lg-1 responsive-column-m">
							<div class="icon-box icon-layout-2 dashboard-icon-box">
								<div class="d-flex">
									<div class="info-content">
										<p class="info__desc">Doanh thu</p>
										<h4 class="info__title">15</h4>
									</div><!-- end info-content -->
								</div>
							</div>
						</div><!-- end col-lg-1 -->
					</div><!-- end row -->
				</div>
			</div>
			<div class="dashboard-main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-6 responsive-column--m">
							<div class="form-box">
								<div class="form-title-wrap">
									<h3 class="title">Doanh thu theo tháng</h3>
								</div>
								<div class="form-content">
									<div class="chartjs-size-monitor">
										<div class="chartjs-size-monitor-expand">
											<div class=""></div>
										</div>
										<div class="chartjs-size-monitor-shrink">
											<div class=""></div>
										</div>
									</div>
									<canvas id="bar-chart" width="641" height="320" class="chartjs-render-monitor"
										style="display: block; height: 256px; width: 513px;"></canvas>
								</div>
							</div><!-- end form-box -->
						</div>
						<div class="col-lg-6 responsive-column--m">
							<div class="form-box">
								<div class="form-title-wrap">
									<h3 class="title">Doanh thu theo quý</h3>
								</div>
								<div class="form-content">
									<div class="chartjs-size-monitor">
										<div class="chartjs-size-monitor-expand">
											<div class=""></div>
										</div>
										<div class="chartjs-size-monitor-shrink">
											<div class=""></div>
										</div>
									</div>
									<canvas id="bar-chart" width="641" height="320" class="chartjs-render-monitor"
										style="display: block; height: 256px; width: 513px;"></canvas>
								</div>
							</div><!-- end form-box -->
						</div>
						<div class="col-lg-6 responsive-column--m">
							<div class="form-box">
								<div class="form-title-wrap">
									<h3 class="title">Doanh thu theo năm</h3>
								</div>
								<div class="form-content">
									<div class="chartjs-size-monitor">
										<div class="chartjs-size-monitor-expand">
											<div class=""></div>
										</div>
										<div class="chartjs-size-monitor-shrink">
											<div class=""></div>
										</div>
									</div>
									<canvas id="bar-chart" width="641" height="320" class="chartjs-render-monitor"
										style="display: block; height: 256px; width: 513px;"></canvas>
								</div>
							</div><!-- end form-box -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

</html>