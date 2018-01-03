<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
session_start();
//檢查是否經過登入
$user_display_name = 'Guest';
if (!empty($_SESSION['loginMember'] ?? '')) {
// 這裡讀資料庫
$con = @mysqli_connect("localhost","root","","phpmember");
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysqli_query($con,$query_RecMember);   
$row_RecMember=mysqli_fetch_assoc($RecMember);
$user_display_name = $row_RecMember["m_username"];
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
    unset($_SESSION["loginMember"]);
    unset($_SESSION["memberLevel"]);
    header("Location: index-coming-soon.php");
}
$con = mysqli_connect("localhost","root","","phpmember");
//預設每頁筆數
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$query_RecBoard = "SELECT * FROM `board` ORDER BY `boardtime` DESC";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecBoard = $query_RecBoard." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$RecBoard = mysqli_query($con,$query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$all_RecBoard = mysqli_query($con,$query_RecBoard);
//計算總筆數
$total_records = mysqli_num_rows($all_RecBoard);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Coming Soon </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/pe-icons.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/member_admin.css">
    <script src="js/jquery.js"></script>
    <script src="js/member_admin.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/ico/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/ico/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/ico/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" href="images/ico/apple-touch-icon-57x57.png">
    <script type="text/javascript">
    jQuery(document).ready(function($){
    'use strict';
        jQuery('body').backstretch([
            "images/bg/bg1.jpg",
            "images/bg/bg1.jpg",
            "images/bg/bg1.jpg"
        ], {duration: 5000, fade: 500});
    });
    </script>
</head><!--/head-->
<body>
<div id="preloader"></div>
    <header class="navbar navbar-inverse navbar-fixed-top opaqued" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
                 <a class="navbar-brand" href="index-coming-soon.php"><h1><span class="pe-7s-gleam bounce-in"></span><?php echo $user_display_name;?></h1></a>
            </div>
            <div class="collapse navbar-collapse">
                 <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="index-coming-soon.php">Home</a></li>                    
                    <li><a href="board.php">BOARD</a></li>
                    <li><a href="404.php">GOODS</a></li>
                    <li><a href="404.php">Contact</a></li>
                    <li><a href="join.php">SIGN UP </a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->

    <section id="main-slider" class="no-margin">
        <div class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content center centered">
                                    <p class="boxed animation animated-item-2 fade-up">留言板 </p>
                                    <div class="tbl-header" style="padding-top:100">
                                    </div>
                                        <div class="tbl-content">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                        <?php while($row_RecBoard=mysqli_fetch_assoc($RecBoard)){ ?>
                                            <tody>
                                                <tr>
                                                    <td ><?php echo $row_RecBoard["boardname"];?><td>
                                                    <td ><?php echo $row_RecBoard["boardcontent"];?></td>
                                                </tr>
                                            </tody> 
                                        <?php }?>
                                        </table>
                                        <table width="100%" border="0"  cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="col-sm-7" align="center"><p>
                                                <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
                                                <a href="?page=1" class="btn btn-md animation bounce-in" >First</a>  <a href="?page=<?php echo $num_pages-1;?>" class="btn btn-md animation bounce-in" >prev</a> 
                                              <?php }?>
                                                <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
                                                <a href="?page=<?php echo $num_pages+1;?>" class="btn btn-md animation bounce-in">next</a>  <a href="?page=<?php echo $total_pages;?>" class="btn btn-md animation bounce-in">last</a>
                                                <?php }?>
                                            </p></td>
                                            <td align="right"><p>total：<?php echo $total_records;?></p></td>
                                          </tr>
                                        </table>
                                      </div>
                                    <a class="btn btn-md animation bounce-in" href="index-coming-soon.php">BACK</a>         
                                    <a class="btn btn-md animation bounce-in" href="post.php">POST</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
    </section><!--/#main-slider-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/init.js"></script>
</body>
</html>