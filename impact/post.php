<?php 
header("Content-Type: text/html; charset=utf-8");
session_start();  
$con = mysqli_connect("localhost","root","","phpmember");
require_once("connMysql.php");
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
    header("Location:login.php");
}
$user_display_name = 'Guest';
if (!empty($_SESSION['loginMember'] ?? '')) {
// 這裡讀資料庫
$con = @mysqli_connect("localhost","root","","phpmember");
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysqli_query($con,$query_RecMember);   
$row_RecMember=mysqli_fetch_assoc($RecMember);
$user_display_name = $row_RecMember["m_username"];
}
if(isset($_POST["action"])&&($_POST["action"]=="add")){
  $con = @mysqli_connect("localhost","root","","phpmember");
  $query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
  $RecMember = mysqli_query($con,$query_RecMember);   
  $row_RecMember=mysqli_fetch_assoc($RecMember);
	$query_insert = "INSERT INTO `board` (`boardname` ,`boardsex` ,`boardsubject` ,`boardtime` ,`boardmail` ,`boardweb` ,`boardcontent`) VALUES (";
	$query_insert .= "'".$row_RecMember["m_username"]."',";
	$query_insert .= "'".$_POST["boardsex"]."',";
	$query_insert .= "'".$_POST["boardsubject"]."',";
	$query_insert .= "NOW(),";
	$query_insert .= "'".$_POST["boardmail"]."',";
	$query_insert .= "'".$_POST["boardweb"]."',";	
	$query_insert .= "'".$_POST["boardcontent"]."')";
	mysqli_query($con,$query_insert);
	//重新導向回到主畫面
	header("Location: board.php");
}	
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
    <link rel="stylesheet" href="css/login.css">
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
   
<script language="javascript">
  function checkForm(){
	if(document.formPost.boardsubject.value==""){
		alert("請填寫標題!");
		document.formPost.boardsubject.focus();
		return false;
	}
	if(document.formPost.boardcontent.value==""){
		alert("請填寫留言內容!");
		document.formPost.boardcontent.focus();
		return false;
	}
		return confirm('確定送出嗎？');
}
</script>
</head>
<body>
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
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
        <tr>
          <td><img name="board_r1_c1" src="images/board_r1_c1.jpg" width="465" height="36" border="0" alt=""></td>
          <td width="15"><img name="board_r1_c8" src="images/board_r1_c8.jpg" width="15" height="36" border="0" alt=""></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td background="i"><div id="mainRegion" >
        <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();" style="padding-top: 200px;padding-left: 200px">
          <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0" > 
            <tr valign="center">
               <p valign="center">留言</p>
              <p>
                <textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea>
              </p>
            </tr>
            <tr valign="top" >
              <td colspan="3" align="center" valign="middle" style="padding-right:140px"><input name="action" type="hidden" id="action" value="add">
                <input type="submit" name="button" class="btn btn-success" id="button" value="送出留言">
                <input type="reset" name="button2" class="btn btn-warning" id="button2" value="重設資料">
                <input type="button" name="button3" class="btn btn-info" id="button3" value="回上一頁" onClick="window.history.back();"></td>
            </tr>
          </table>
        </form>     
      </div></td>
  </tr>
</table>
<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/init.js"></script>
</body>
</html>
