<?php
 header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
$con = @mysqli_connect("localhost","root","","phpmember");
if(isset($_POST["action"])&&($_POST["action"]=="join")){
  //找尋帳號是否已經註冊
  $query_RecFindUser = "SELECT `m_username` FROM `memberdata` WHERE `m_username`='".$_POST["m_username"]."'";
  $RecFindUser=mysqli_query($con,$query_RecFindUser);
  if (mysqli_num_rows($RecFindUser)>0){
    header("Location: member_join.php?errMsg=1&username=".$_POST["m_username"]);
  }else{
  //若沒有執行新增的動作  
    $query_insert = "INSERT INTO `memberdata` (`m_name` ,`m_username` ,`m_passwd` ,`m_email`,`m_jointime`) VALUES (";
    $query_insert .= "'".$_POST["m_name"]."',";
    $query_insert .= "'".$_POST["m_username"]."',";
    $query_insert .= "'".md5($_POST["m_passwd"])."',";
    $query_insert .= "'".$_POST["m_email"]."',";
    $query_insert .= "NOW())";
    mysqli_query($con,$query_insert);
    header("Location: member_join.php?loginStats=1");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SYSTEM | SIGN UP</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../AdminLTE-cn-master/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/plugins/iCheck/square/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script language="javascript">
function checkForm(){
  if(document.formJoin.m_username.value==""){   
    alert("請填寫帳號!");
    document.formJoin.m_username.focus();
    return false;
  }else{
    uid=document.formJoin.m_username.value;
    if(uid.length<5 || uid.length>12){
      alert( "您的帳號長度只能5至12個字元!" );
      document.formJoin.m_username.focus();
      return false;
    }
    if(!(uid.charAt(0)>='a' && uid.charAt(0)<='z')){
      alert("您的帳號第一字元只能為小寫字母!" );
      document.formJoin.m_username.focus();
      return false;
    }
    for(idx=0;idx<uid.length;idx++){
      if(uid.charAt(idx)>='A'&&uid.charAt(idx)<='Z'){
        alert("帳號不可以含有大寫字元!" );
        document.formJoin.m_username.focus();
        return false;
      }
      if(!(( uid.charAt(idx)>='a'&&uid.charAt(idx)<='z')||(uid.charAt(idx)>='0'&& uid.charAt(idx)<='9')||( uid.charAt(idx)=='_'))){
        alert( "您的帳號只能是數字,英文字母及「_」等符號,其他的符號都不能使用!" );
        document.formJoin.m_username.focus();
        return false;
      }
      if(uid.charAt(idx)=='_'&&uid.charAt(idx-1)=='_'){
        alert( "「_」符號不可相連 !\n" );
        document.formJoin.m_username.focus();
        return false;       
      }
    }
  }
  if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
    document.formJoin.m_passwd.focus();
    return false;
  } 
  if(document.formJoin.m_name.value==""){
    alert("請填寫姓名!");
    document.formJoin.m_name.focus();
    return false;
  }
  if(document.formJoin.m_email.value==""){
    alert("請填寫電子郵件!");
    document.formJoin.m_email.focus();
    return false;
  }
  if(!checkmail(document.formJoin.m_email)){
    document.formJoin.m_email.focus();
    return false;
  }
  return confirm('確定送出嗎？');
}
function check_passwd(m_passwd,m_passwdrecheck){
  if(m_passwd==''){
    alert("密碼不可以空白!");
    return false;
  }
  for(var idx=0;idx<m_passwd.length;idx++){
    if(m_passwd.charAt(idx) == ' ' || m_passwd.charAt(idx) == '\"'){
      alert("密碼不可以含有空白或雙引號 !\n");
      return false;
    }
    if(m_passwd.length<5 || m_passwd.length>10){
      alert( "密碼長度只能5到10個字母 !\n" );
      return false;
    }
    if(m_passwd!= m_passwdrecheck){
      alert("密碼二次輸入不一樣,請重新輸入 !\n");
      return false;
    }
  }
  return true;
}
function checkmail(myEmail) {
  var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(filter.test(myEmail.value)){
    return true;
  }
  alert("電子郵件格式不正確");
  return false;
}
</script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Fgu</b>FINAL</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">請填寫表單</p>
    <form action="" name="formJoin" id="formJoin" method="POST" onsubmit="return checkForm();">
      <div class="form-group has-feedback">
        <input name="m_username" id="m_username" type="text" class="form-control" placeholder="全名">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" id="m_email" class="form-control" placeholder="信箱">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name ="m_passwd" id="m_passwd" type="password" class="form-control" placeholder="密碼">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name = "m_passwdrecheck" id="m_passwdrecheck" type="password" class="form-control" placeholder="再次輸入密碼">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="check"> 我同意使用規章</a>
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
        </div>
      </div>
    </form>
    <a href="login.php" class="text-center">我已經有一個帳號</a>
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
