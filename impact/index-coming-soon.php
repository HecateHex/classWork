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
    <script src="js/jquery.js"></script>
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

		$("#mapwrapper").gMap({ controls: false,
         	scrollwheel: false,
         	markers: [{ 	
              	latitude:40.7566,
				longitude: -73.9863,
          	icon: { image: "images/marker.png",
              	iconsize: [44,44],
          		iconanchor: [12,46],
          		infowindowanchor: [12, 0] } }],
          	icon: { 
              	image: "images/marker.png", 
             	iconsize: [26, 46],
              	iconanchor: [12, 46],
              	infowindowanchor: [12, 0] },
         	latitude:25.0430627,
         	longitude: 121.527096,
          	zoom: 14 });

        // set the date we're counting down to
        var target_date = new Date('Dec, 31, 2017').getTime();
        var days, hours, minutes, seconds;
        var countdown = document.getElementById('countdown');
        setInterval(function () {
             var current_date = new Date().getTime();
             var seconds_left = (target_date - current_date) / 1000;
             days = parseInt(seconds_left / 86400);
             seconds_left = seconds_left % 86400;
             hours = parseInt(seconds_left / 3600);
             seconds_left = seconds_left % 3600;
             minutes = parseInt(seconds_left / 60);
             seconds = parseInt(seconds_left % 60);
             countdown.innerHTML = '<span class="days">' + days +  ' <b>Days</b></span> <span class="hours">' + hours + ' <b>Hours</b></span> <span class="minutes">'
            + minutes + ' <b>Minutes</b></span> <span class="seconds">' + seconds + ' <b>Seconds</b></span>';
        }, 1000);
    });
    </script>
</head><!--/head-->
<body>
<div id="preloader"></div>
    <header class="navbar navbar-inverse navbar-fixed-top opaqued" role="banner">
    <div id="search-wrapper">
        <div class="container">
            <input id="search-box" placeholder="Search">
        </div>
    </div>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#"><h1><span class="pe-7s-gleam bounce-in"></span><?php echo $user_display_name;?></h1></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="index-coming-soon.php">Home</a></li>                    
                    <li><a href="board.php">BOARD</a></li>
                    <li><a href="404.php">GOODS</a></li>
                    <li><a href="404.php">Contact</a></li>
                    <li><a href="404.php">SIGN UP </a></li>
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
                                	<div id="countdown" class="boxed animation fade-down"></div><!-- /#Countdown Div -->
                                    <br>
                                    <h2 class="boxed animation fade-down">waiting  for  complete</h2>
                                    <br>
                                    <a href= "login.php" class="btn btn-md animation bounce-in" ><?php if($user_display_name =="Guest"){ echo"login" ;}else{ echo"homepage";}?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
    </section><!--/#main-slider-->

    <div id="content-wrapper">
        <section id="services" class="white">
            <div class="container">
            <div class="gap"></div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="center gap fade-down section-heading">
                            <h2 class="main-title">Support operating system</h2>
                            <hr>
                            <p></p>
                        </div>                
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5 col-sm-6">
                        <div class="service-block">
                            <div class="pull-left bounce-in">
                                <i class="fa fa-windows fa fa-md"></i>
                            </div>
                            <div class="media-body fade-up">
                                <br>
                                <h3 class="media-heading">Windows</h3>
                                <p></p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                    <div class="col-md-4 col-sm-6">
                        <div class="service-block">
                            <div class="pull-left bounce-in">
                                <i class="fa fa-android fa fa-md"></i>
                            </div>
                            <div class="media-body fade-up">
                                <br>
                                <h3 class="media-heading">android</h3>
                                <p></p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                </div><!--/.row-->
                <div class="gap"></div>
                <div class="row">
                    <div class = "col-md-3">
                    </div>
                    <div class="col-md-5 col-sm-6">
                        <div class="service-block">
                            <div class="pull-left bounce-in">
                                <i class="fa fa-linux fa fa-md"></i>
                            </div>
                            <div class="media-body fade-up">
                                <br>
                                <h3 class="media-heading">Linux</h3>
                                <p></p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                    <div class="col-md-4 col-sm-6">
                        <div class="service-block">
                            <div class="pull-left bounce-in">
                                <i class="fa fa-apple fa fa-md"></i>
                            </div>
                            <div class="media-body fade-up">
                                <br>
                                <h3 class="media-heading">iOS</h3>
                                <p></p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                </div><!--/.row-->
            </div>
        </section>

        <section id="stats" class="divider-section">
            <div class="gap"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="center bounce-in">
                            <span class="stat-icon"><span class="pe-7s-timer bounce-in"></span></span>
                            <h1><span class="counter">40</span></h1>
                            <h3>HOURS</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="center bounce-in">
                            <span class="stat-icon"><span class="pe-7s-light bounce-in"></span></span>
                            <h1><span class="counter">100</span></h1>
                            <h3>tasty</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="center bounce-in">
                            <span class="stat-icon"><span class="pe-7s-graph1 bounce-in"></span></span>
                            <h1><span class="counter">1000</span></h1>
                            <h3>HUGE PROFIT</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="center bounce-in">
                            <span class="stat-icon"><span class="pe-7s-box2 bounce-in"></span></span>
                            <h1><span class="counter">5621</span></h1>
                            <h3>THINGS IN BOXES</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div> 
        </section>

        <section id="portfolio" class="white">
       		<div class="container">
	        	<div class="gap"></div> 
		        	<div class="center gap fade-down section-heading">
		                <h2 class="main-title">GOODS</h2>
		                <hr>
		                <p></p>
		            </div> 
	                <ul class="portfolio-filter fade-down center">
	                    <li><a class="btn btn-outlined btn-primary active" href="#" data-filter="*">All</a></li>
	                    <li><a class="btn btn-outlined btn-primary" href="#" data-filter=".apps">A</a></li>
	                    <li><a class="btn btn-outlined btn-primary" href="#" data-filter=".nature">B</a></li>
	                    <li><a class="btn btn-outlined btn-primary" href="#" data-filter=".design">C</a></li>
	                </ul><!--/#portfolio-filter-->

	                <ul class="portfolio-items col-3 isotope fade-up">
	                    <li class="portfolio-item apps isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>             
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item joomla nature isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>              
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item bootstrap design isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>        
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item joomla design apps isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>          
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item joomla apps isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>          
	                            </div>    
	                        </div>       
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item wordpress nature isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>           
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item joomla design apps isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>          
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item joomla nature isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>          
	                            </div>    
	                        </div>       
	                    </li><!--/.portfolio-item-->
	                    <li class="portfolio-item wordpress design isotope-item">
	                        <div class="item-inner">
	                            <img src="http://placehold.it/800x600" alt="">
	                            <h5>Lorem ipsum dolor sit amet</h5>
	                            <div class="overlay">
	                                <a class="preview btn btn-outlined btn-primary" href="http://placehold.it/800x600" rel="prettyPhoto"><i class="fa fa-eye"></i></a>           
	                            </div>           
	                        </div>           
	                    </li><!--/.portfolio-item-->
	                </ul>
                </div>
            </section>

            <section id="testimonial-carousel" class="divider-section">
            <div class="gap"></div>
	            <div class="container">
	                <div class="row">
                    	<div class="center gap fade-down section-heading">
                            <h2 class="main-title">restaurant</h2>
                            <hr>
                            <p>You can taste in these restaurant </p>
                            <div class="gap"></div>
                        </div>                         
	                    <div class='col-md-offset-2 col-md-8 fade-up'>
	                        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
	                            <!-- Bottom Carousel Indicators -->
	                            <ol class="carousel-indicators">
	                                <li data-target="#quote-carousel" data-slide-to="0" class="active"></li>
	                                <li data-target="#quote-carousel" data-slide-to="1"></li>
	                                <li data-target="#quote-carousel" data-slide-to="2"></li>
	                            </ol>                                
	                            <!-- Carousel Slides / Quotes -->
	                            <div class="carousel-inner">                                
	                              <!-- Quote 1 -->
	                                <div class="item active">
	                                    <blockquote>
	                                        <div class="row">
	                                            <div class="col-sm-3 text-center">
	                                                <img class="img-responsive" src="http://placehold.it/400x400" style="width: 100px;height:100px;">
	                                            </div>
	                                            <div class="col-sm-9">
	                                                <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
	                                                <small>Someone famous</small>
	                                            </div>
	                                        </div>
	                                    </blockquote>
	                                </div>
	                                <!-- Quote 2 -->
	                                <div class="item">
	                                    <blockquote>
	                                        <div class="row">
	                                            <div class="col-sm-3 text-center">
	                                                <img class="img-responsive" src="http://placehold.it/400x400" style="width: 100px;height:100px;">
	                                            </div>
	                                            <div class="col-sm-9">
	                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor nec lacus ut tempor. Mauris.</p>
	                                                <small>Someone famous</small>
	                                            </div>
	                                        </div>
	                                    </blockquote>
	                                </div>
	                                <!-- Quote 3 -->
	                                <div class="item">
	                                    <blockquote>
	                                        <div class="row">
	                                            <div class="col-sm-3 text-center">
	                                                <img class="img-responsive" src="http://placehold.it/400x400" style="width: 100px;height:100px;">
	                                            </div>
	                                            <div class="col-sm-9">
	                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum elit in arcu blandit, eget pretium nisl accumsan. Sed ultricies commodo tortor, eu pretium mauris.</p>
	                                                <small>Someone famous</small>
	                                            </div>
	                                        </div>
	                                    </blockquote>
	                                </div>
	                            </div>                                     
	                        </div> 
	                    </div>
	                </div>
	                <div class="gap"></div>
	      		</div>
      		</section>

			<div id="mapwrapper">
				<div id="map"></div>
			</div>

            <section id="contact" class="white">
                <div class="container">
                	<div class="gap"></div>
                    <div class="center gap fade-down section-heading">
                        <h2 class="main-title">HOW TO CONTANT</h2>
                        <hr>
                        <p>CONTANT INFORMATION</p>
                    </div>    
                    <div class="gap"></div>
                    <div class="row">
                        <div class="col-md-4 fade-up">
                            <h3>Contact Information</h3>
                            <p><span class="icon icon-home"></span>Time Square, Taiwan<br/>
                                <span class="icon icon-phone"></span>########<br/>
                                <span class="icon icon-mobile"></span>+886 935 176435<br/>
                                <span class="icon icon-envelop"></span> <a href="mailto:hex.wang@kanpai.com.tw">mail to me</a> <br/>
                                <span class="icon icon-twitter"></span> <a href="#">twitter</a> <br/>
                                <span class="icon icon-facebook"></span> <a href="#">facebook</a> <br/>
                            </p>
                        </div><!-- col -->
                    
                        <div class="col-md-8 fade-up">
                            <h3>Drop Us A Message</h3>
                            <br>
                            <br>
                            <div id="message"></div>
                            <form method="post" action="sendemail.php" id="contactform">
                                <input type="text" name="name" id="name" placeholder="Name" />
                                <input type="text" name="email" id="email" placeholder="Email" />
                                <input type="text" name="website" id="website" placeholder="Website" />
                                <textarea name="comments" id="comments" placeholder="Comments"></textarea>
                                <input class="btn btn-outlined btn-primary" type="submit" name="submit" value="Submit" />
                            </form>
                        </div><!-- col -->
                    </div><!-- row -->  
                    <div class="gap"></div>         
                </div>
            </section>
        </div>

    <div id="footer-wrapper">
        <section id="bottom" class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 about-us-widget">
                        <h4>Global Coverage</h4>
                        <p>Was drawing natural fat respect husband. An as noisy an offer drawn blush place. These tried for way joy wrote witty. In mr began music weeks after at begin.</p>
                    </div><!--/.col-md-3-->

                    <div class="col-md-3 col-sm-6">
                        <h4>Company</h4>
                        <div>
                            <ul class="arrow">
                                <li><a href="#">Company Overview</a></li>
                                <li><a href="#">Meet The Team</a></li>
                                <li><a href="#">Our Awesome Partners</a></li>
                                <li><a href="#">Our Services</a></li>
                            </ul>
                        </div>
                    </div><!--/.col-md-3-->

                    <div class="col-md-3 col-sm-6">
                        <!--暫時<h4>Latest Articles</h4>
                        <div>
                            <div class="media">
                                <div class="pull-left">
                                    <img class="widget-img" src="http://placehold.it/800x600" alt="">
                                </div>
                                <div class="media-body">
                                    <span class="media-heading"><a href="#">Blog Post A</a></span>
                                    <small class="muted">Posted 14 April 2014</small>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img class="widget-img" src="http://placehold.it/800x600" alt="">
                                </div>
                                <div class="media-body">
                                    <span class="media-heading"><a href="#">Blog Post B</a></span>
                                    <small class="muted">Posted 14 April 2014</small>
                                </div>
                            </div>
                        </div>  -->
                    </div><!--/.col-md-3-->

                    <div class="col-md-3 col-sm-6">
                        <h4>Come See Us</h4>
                        <address>
                            <strong>welcome</strong><br>
                            Taipei<br>
                            Taipei , 24224<br>
                            <abbr title="Phone"><i class="fa fa-phone"></i></abbr> ########
                        </address>
                    </div> <!--/.col-md-3-->
                </div>
            </div>
        </section><!--/#bottom-->

        <footer id="footer" class="">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        &copy; 2017 <a target="_blank" href="#" title="Premium Themes and Templates">Fgu project</a>. All Rights Reserved.
                    </div>
                    <div class="col-sm-6">
                        <ul class="pull-right">
                            <li><a id="gototop" class="gototop" href="#"><i class="fa fa-chevron-up"></i></a></li><!--#gototop-->
                        </ul>
                    </div>
                </div>
            </div>
        </footer><!--/#footer-->
    </div>


    <script src="js/plugins.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>   
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWDPCiH080dNCTYC-uprmLOn2mt2BMSUk&amp;sensor=true"></script> 
    <script src="js/init.js"></script>
</body>
</html>