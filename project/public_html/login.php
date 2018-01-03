<?php
header("Content-Type: text/html; charset=utf8mb4_unicode_ci");
require_once("connMysql.php");
session_start();
//檢查是否經過登入，若有登入則重新導向
if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
	//若帳號等級為 member 則導向會員中心
	if($_SESSION["memberLevel"]=="member"){
		header("Location: member_center.php");
	//否則則導向管理中心
	}else{
		header("Location: member_admin.php");	
	}
}
$con = @mysqli_connect("localhost","root","","phpmember");
if(isset($_POST["username"]) && isset($_POST["passwd"])){		
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `memberdata` WHERE `m_username`='".$_POST["username"]."'";
	$RecLogin = mysqli_query($con,$query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysqli_fetch_assoc($RecLogin);
	$username = $row_RecLogin["m_username"];
	$passwd = $row_RecLogin["m_passwd"];
	$level = $row_RecLogin["m_level"];
	//比對密碼，若登入成功則呈現登入狀態
	if(md5($_POST["passwd"])==$passwd){
		//計算登入次數及更新登入時間
		$query_RecLoginUpdate = "UPDATE `memberdata` SET `m_login`=`m_login`+1, `m_logintime`=NOW() WHERE `m_username`='".$_POST["username"]."'";	
		mysqli_query($con,$query_RecLoginUpdate);
		//設定登入者的名稱及等級
		$_SESSION["loginMember"]=$username;
		$_SESSION["memberLevel"]=$level;
		//使用Cookie記錄登入資料
		if(isset($_POST["rememberme"])&&($_POST["rememberme"]=="true")){
			setcookie("remUser", $_POST["username"], time()+365*24*60);
			setcookie("remPass", $_POST["passwd"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remUser"])){
				setcookie("remUser", $_POST["username"], time()-100);
				setcookie("remPass", $_POST["passwd"], time()-100);
			}
		}
		//若帳號等級為 member 則導向會員中心
		if($_SESSION["memberLevel"]=="member"){
			header("Location: member_center.php");
		//否則則導向管理中心
		}else{
			header("Location: member_admin.php");	
		}
	}else{
		header("Location: index.php?errMsg=1");
	}
}
$user_display_name = 'Guest';
if (!empty($_SESSION['loginMember'] ?? '')) {
// 這裡讀資料庫
$con = @mysqli_connect("localhost","root","","phpmember");
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysqli_query($con,$query_RecMember);   
$row_RecMember=mysqli_fetch_assoc($RecMember);
$user_display_name = $row_RecMember["m_name"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SYSTEM | LOGIN</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../AdminLTE-cn-master/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/plugins/iCheck/square/blue.css">
</head>
<body class = "hold-transition login-page">
<div class = "login-box">
	<div class = "login-logo">
		<a href="index.php"><b>Fgu</b>FINAL</a>
	</div>
	<div class = "login-box-body">
		<p class = "login-box-msg">Sign in to start your mission</p>

		<form action = "" method = "post">
			<div class = "form-group has-feedback" >
				<input type = "text" name = "username" class = "form-control" placeholder = "帳號">
				<span class = "glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class = "form-group has-feedback" >
				<input type = "password" name = "passwd" class = "form-control" placeholder = "密碼">
				<span class = "glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class ="row">
				<div class = "col-xs-8">
					<div class = "checkbox icheck">
						<label>
							<input type="checkbox"> 記住我
						</label>
					</div>
				</div>
			
				<div class = "col-xs-4">
					<button type = "submit" class = "btn btn-primary btn-block btn-flat"> 登錄 </button>
				</div>

			</div>
		</form>

		<a href="register.php" class = "text-center">註冊帳號</a>

	</div>
</div>	
<script src="../AdminLTE-cn-master/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../AdminLTE-cn-master/bootstrap/js/bootstrap.min.js"></script>
<script src="../AdminLTE-cn-master/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>