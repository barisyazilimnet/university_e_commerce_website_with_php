<?php
    if($S_query_users["user_authority"] < 3){
        ?>
        <!-- Main content -->
        <section class="content container-fluid">
          <?php
            $slider_id = $_GET["slider_id"];
			$query=mysqli_fetch_array(mysqli_query($con, "SELECT * FROM slider WHERE slider_id='$slider_id'"));
			unlink("uploads/slider/".$query["slider_photo"]);
			unlink("uploads/slider/".$query["slider_price_photo"]);
			$query_delete =mysqli_query($con, "DELETE FROM slider WHERE slider_id ='$slider_id'");
			if($query_delete){
				$description =$slider_id." id'li slider silindi";
				$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Slider Silindi', do_transactions='$S_user_name'");
				message("success","check","Başarılı","Seçilen slider başarıyla silinmiştir. Lütfen bekleyiniz");
				header("Refresh:1; url = http://localhost/admin/administrator.php?do=slider_settings", true, 303);
			}else{
				message("warning","warning","Dikkat!","Seçilen slider silinememiştir.");
				header("Refresh:1; url = http://localhost/admin/administrator.php?do=slider_settings", true, 303);
			}
            ?>
        </section>
        <!-- /.content -->  
    <?php
    }else{
		message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfaya yönlendirliyorsunuz");
		header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
    }
?>