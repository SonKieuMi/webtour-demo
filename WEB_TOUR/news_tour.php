<?php
session_start();
$page = 'news_tour';
require "includes/contentHandler.php";

if(isset( $_SESSION['tendangnhap']))
{
    if(isset( $_SESSION['userrole'] )&& $_SESSION['userrole']=="ROLE_USER")
    {
        require "includes/header-logined.php";       
    }
    else{
       header ("Location: admin/quanlytour.php");
    }
}
else{
    require_once "includes/header.php";
}
?>
  <!-- Start-News-->
  <div class="container n3-list-tour mg-bot40">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="list-tour">
                    <div class="list">
                        <div class="row">

                            <!--Title-News-->
                            <div class="col-md-12 text-center" style="padding-bottom:25px;padding-top:20px;width:100%">
                                <h2 class="title title-news" style="text-shadow:none;">Tin tức du lịch</h2>
                            </div>
                            <!--Title-News-->
                            <!-- Start-List-News -->
                            <div>
                                <?php
                                $cth = new contentHandler();
                                $page = 1;
                                if (!isset($_GET["page"])) {
                                    $_GET["page"] = 1;
                                }
                                $page = htmlspecialchars($_GET["page"]);

                                $pagingResult = $cth->newsPaging('', $page);
                                ?>
                                <?php                              
                               $result = $cth->loadNews($page);
                               foreach ($result as $row) {
                                echo '<div class="col-lg-11 col-md-11 col-sm-12 item-news">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 item-img">
                                            <div class="pos-relative">
                                                <a href="news-detail.php?id=' .  ($row['id']) . '" title="' . ($row['title']). '">
                                                    <img src="' . ($row['image']) . '" class="img-responsive pic-lt"
                                                        alt="' . ($row['title']). '">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 info-news">
                                            <div class="frame-news">
                                                <div class="frame-top">
                                                    <h2 class="news-title-l">
                                                        <a href="news-detail.php?id=' .  ($row['id']) . '" title="' . ($row['title']). '" class="dot-dot cut-name"
                                                            style="overflow-wrap: break-word;">' . ($row['title']). '</a>
                                                    </h2>
                                                </div>
                                                <div class="frame-bot">
                                                    <div class="des-content dot-dot cut-content" style="overflow-wrap: break-word;">
                                                    ' . substr($row['description_1'], 0, 250) . '...
                                                    </div>                                                    
                                                    <div class="text-right">
                                                        <a href="news-detail.php?id=' .  ($row['id']) . '" class="view_more"
                                                            title="T' . ($row['title']). '">Xem thêm &#10132;<i
                                                                class="fas fa-long-arrow-alt-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                echo $pagingResult;
                                ?>                               

                            </div>
                            <!-- End-List-News -->
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- End-News-->
   
    <!-- end-pagination-->
<?php
require_once "includes/footer.php";
?>