<?php
	# html en üstünde kullanılır
	session_start();
    ob_start();
	//error_reporting(0);
    
	$h="localhost";
	$n="root";
	$p="";
	$db="goksun_myo";
	$con= mysqli_connect($h,$n,$p,$db) or die(mysql_error());
    $con -> Set_charset("utf8");
	//mysqli_set_charset($baglan,"UTF-8");
	$query_settings = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM settings"));
	
	if($query_settings["site_theme"]==0){
		$site_theme="default";
	}
	
	define("THEME_URL", $query_settings["site_url"]."/theme/".$site_theme."/");
	define("SİTE_URL", $query_settings["site_url"]."/");
?>