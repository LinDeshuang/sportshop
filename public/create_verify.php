<?php 
	require_once('./class/function.php');
	header('content-type:image/png');
	session_start();
	$verify_code = createVerify(4);
	$_SESSION['verify_code']=$verify_code;
 ?>