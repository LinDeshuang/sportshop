<?php
	date_default_timezone_set('PRC');
    session_start();
    if(!isset($_SESSION['admin'])){
    	header("Location:/admin/login_form.php");
    }
?>