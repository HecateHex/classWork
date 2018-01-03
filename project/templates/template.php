<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $this->e($title)?>::SYSTEM</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../AdminLTE-cn-master/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../AdminLTE-cn-master/plugins/iCheck/square/blue.css">
</head>

<body class ="<?=$this->e($class) ?>">
	<?=$this->section('content')?>
		<script src="../AdminLTE-cn-master/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<script src="../AdminLTE-cn-master/bootstrap/js/bootstrap.min.js"></script>
		<script src="../AdminLTE-cn-master/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="../AdminLTE-cn-master/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="../AdminLTE-cn-master/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<script src="../AdminLTE-cn-master/plugins/fastclick/fastclick.js"></script>
		<script src="../AdminLTE-cn-master/dist/js/app.min.js"></script>
		<script src="../AdminLTE-cn-master/dist/js/demo.js"></script>
	<?=$this->section('footer')?>
</body>
</html>