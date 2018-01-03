<?php 
	$con = @mysqli_connect("localhost","root","","phpmember");
	if(!$con)
	{
		echo "Error" . mysqli_connect_error();
		exit();
	}
?>