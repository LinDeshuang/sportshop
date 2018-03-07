<?php
	require_once('include/public.php');
	unset($_SESSION['user']);
	setcookie(session_name(), session_id(), time() - 1, "/"); 
	header("Location:/admin/login_form.php");
?>