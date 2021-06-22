<?php
	function theme_content($con){
		@$do=$_GET["do"];
		switch($do){
			case "contact":
				require_once "theme/default/contact.php";
				break;
			case "product":
				require_once "theme/default/product.php";
				break;
			case "cart":
				require_once "theme/default/cart.php";
				break;
			default:
				require_once "theme/default/homepage.php";
				break;
		}
	}
	function theme_slider($con){
		$query=mysqli_query($con,"SELECT * FROM slider order by slider_id desc LIMIT 5");
		if(mysqli_affected_rows($con)){
			while($slider_query=mysqli_fetch_array($query)){
				@$sayi++;
                $slider_top_header=$slider_query["slider_top_header"];
                $slider_bottom_header=$slider_query["slider_bottom_header"];
                $slider_description=$slider_query["slider_description"];
                $slider_photo=$slider_query["slider_photo"];
                $slider_price_photo=$slider_query["slider_price_photo"];
				require "theme/default/slider.php";
			}
		}else{
			return false;
		}
	}
	function category($con){
		$query=mysqli_query($con, "SELECT * FROM categories WHERE category_visibility='1' ORDER BY category_order ASC");
		while($categories=mysqli_fetch_array($query)){
			echo'<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a href="index.php?do=product&category_name='.$categories["category_name"].'&category_id='.$categories["category_id"].'">'.$categories["category_name"].'</a></h4>
					</div>
				</div>';
		}
	}
	function case_converter( $keyword){ // bütün harfleri büyütür
		$low = array('a','b','c','ç','d','e','f','g','ğ','h','ı','i','j','k','l','m','n','o','ö','p','r','s','ş','t','u','ü','v','y','z','q','w','x');
		$upp = array('A','B','C','Ç','D','E','F','G','Ğ','H','I','İ','J','K','L','M','N','O','Ö','P','R','S','Ş','T','U','Ü','V','Y','Z','Q','W','X');
		$keyword = str_replace( $low, $upp, $keyword );
		$keyword = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $keyword ) : $keyword;
		return $keyword;
	}
	function message($message_pattern,$icon,$top_header_message,$message){ // mesaj şekilleri -> warning -- danger -- success
		echo'<div class="alert alert-'.$message_pattern.' alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa  fa-'.$icon.'"></i> '.$top_header_message.'</h4>
			'.$message.'
		</div>';
	}
?>