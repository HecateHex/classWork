<?php 
	$con = @mysqli_connect("localhost","root","","phpmember");
	if(!$con)
	{
		echo "Error" . mysqli_connect_error();
		exit();
	}
	mysqli_query($con,'SET NAMES utf8');
?>