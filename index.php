<?php
    require_once("system/settings.php");
    require_once("system/system.php");
    if($query_settings["site_status"]=="1"){
        //header("Location: http://localhost/tema/index.php");
		require "theme/default/index.php";
    }else{
        echo"<img src='site_off.png'></img>";
    }
?>