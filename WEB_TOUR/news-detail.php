<?php 
session_start();
$page = 'news_tour';
require "includes/contentHandler.php";

if(isset( $_SESSION['tendangnhap'] ) )
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
<?php
$userid = 0;
$cth = new contentHandler();
$id = htmlspecialchars($_GET["id"]);
$result = $cth->getNewsDetails($id);
$row = $result->fetch_assoc();
$_SESSION['id_post'] = $row["id"];
?>
 <!-- Start-News-Detail -->
 <div class="site-content">
        <div class="l-gird">
            <div class="details details-story">          
                <h1 class="details-headline"><?php echo ($row['title']); ?></h1>
                <div class="date_post">
                    <div class="f-left l">
                        <img src="assets/img/i-date.png" alt="date">
                    </div>
                    <?php
                    if(isset($_SESSION["id_user"])) { 
                        $userid =  $_SESSION["id_user"];                 
                    }
                    ?>
                    <div class="f-left r">
                        <span class="font500"><?php echo ($row['date_post']); ?></span>
                    </div>
                  
                </div>
                <div class="l-content">
                    <div class="details-content">
                        <div class="clearfix">
                            <div class="cms-body detail">
                                <div>
                                    <div>
                                        <?php echo ($row['description_1']); ?>
                                    </div>
                                    <div class="pswp-content-wrapimage">
                                        <figure>
                                            <img src="<?php echo ($row['image']); ?>">
                                        </figure>
                                    </div>
                                    <div>
                                    <?php echo ($row['description_2']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php                       
                    if (isset($_POST['postcomment'])) {                                             
                        $postid = htmlspecialchars($_GET["id"]);
                        $comment = $_POST['commentt'];
                        if ($comment == '') {
                           
                        } else {
                            $cth->insertComment($userid, $postid, $comment);
                        }
                    }
                    ?>
                    <section class="zone zone-comment" id="comment">
                        <div class="zone-content">                           
                            <header class="zone-heading">
                                <h3>Bình luận</h3>
                            </header>
                            <div class="zone-comment-area">
                                <div class="comment">
                                    <form action="news-detail.php?id=<?php echo htmlspecialchars($_GET["id"]); ?>&page=<?php if (!isset($_GET["page"])) {
                                                                                                                $_GET["page"] = 1;
                                                                                                            }
                                                                                                            echo htmlspecialchars($_GET["page"]); ?>" method="POST">
                                    <textarea class="form-control" placeholder="Ý kiến của bạn?" name="commentt"></textarea>  
                                    <?php
                                        if(isset( $_SESSION['tendangnhap'] ) )
                                        {       
                                            echo'<button type="submit" class="btn-comment" name="postcomment">Gửi bình luận</button>';
                                        }
                                        else{
                                            echo '<a href="login.php" class="btn-comment"">
                                                    <span>Gửi bình luận</span>
                                                    </a>';
                                        }
                                        ?>                            
                                    </form>
                                    
                                </div>
                                <?php 
                                    if(isset( $_SESSION['tendangnhap'] ) )
                                    {                          
                                        echo '<div class="login-signup" id="cmtLoginNote" style="display: none;"></div>';
                                    }
                                    else{
                                        echo '<div class="login-signup" id="cmtLoginNote">
                                        <a href="login.php;" class="login-link" rel="login">Đăng nhập</a>
                                        hoặc
                                        <a href="signup.php" class="register-link" rel="register">Đăng ký</a>
                                        </div>';
                                    }
                                    ?>                                                               
                            </div>
                            <?php
                            $id = htmlspecialchars($_GET["id"]);
                            $page = 1;
                            if (!isset($_GET["page"])) {
                                $_GET["page"] = 1;
                            }
                            $page = htmlspecialchars($_GET["page"]);
                            $pagingResult = $cth->commentPaging($id, '', $page);
                            ?>
                            <?php
                            $result = $cth->loadComment($id, $page);
                            foreach($result as $row) {
                            echo '<div class="zone-comment-tabs" id="commentcontainer">
                                <div class="tab-content">
                                    <div class="usercomment" rel="">
                                        <div class="primary-comment">
                                            <figure class="ava">
                                                <img data-src="" alt="' . $row['full_name'] . '" class="loaded" src="assets/img/avatar.png">
                                            </figure>
                                            <div class="data">
                                                <div class="user_id">
                                                    <h4>' . $row['full_name'] . '</h4>                                                    
                                                </div>
                                                <div class="comment">
                                                    ' . $row['comment'] . '
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
                    </section>
                </div>
            </div>
        </div>

        <div class="news-side-r">
            <div class="frame-news-r">
                <div class="news-mini">
                    <div class="title-news-side"><a href="news_tour.php">Tin mới</a></div>
                    <div id="divNewsLastest">
                        <ul class="list-tinkhac">
                            <?php
                            $cth = new contentHandler();
                            $result = $cth->tinMoiNhat();
                            // $tinmoi = tinmoinhat();
                            while ($row = $result->fetch_array() ) {                              
                            ?>
                                <?php
                                echo '<li class="dot-dot cut-name" style="overflow-wrap: break-word;">
                                <a href="news-detail.php?id=' .  ($row['id']) . '" title="'. ($row['title']) .'">' . substr($row['title'], 0, 35) . '...</a>
                                </li>';
                                
                                ?>
                            <?php
                                }
                            ?>                          
                        </ul>
                    </div>
                </div>
                <div class="news-mini">
                    <div class="title-news-side"><a href="news_tour.php">Tin ngẫu nhiên</a></div>
                    <div id="divNewsRandom">
                    <ul class="list-tinkhac">
                            <?php
                            $cth = new contentHandler();
                            $result = $cth->tinNgauNhien();                           
                            while ($row = $result->fetch_array() ) {                              
                            ?>
                                <?php
                                echo '<li class="dot-dot cut-name" style="overflow-wrap: break-word;">
                                <a href="news-detail.php?id=' .  ($row['id']) . '" title="'. ($row['title']) .'">' . substr($row['title'], 0, 35) . '...</a>
                                </li>';
                                
                                ?>
                            <?php
                                }
                                $result->free();
                            ?>                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="clear"> </div>
    </div>

    <!-- End-News-Detail -->
<?php 
require_once "includes/footer.php";
?>
