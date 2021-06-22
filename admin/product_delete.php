<?php
    if($S_query_users["user_authority"] < 2){
        ?>
        <!-- Main content -->
        <section class="content container-fluid">
          <?php
            $user_id = $_GET["user_id"];
			$query=mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'"));
			if($S_query_users["user_authority"] >= $query["user_authority"]){
				message("danger","ban","Başarısız!","Bu kullanıcı silinemez.");
                header("Refresh:1; url =http://localhost/admin/administrator.php?do=user_transactions", true, 303);
            }else{
				if($query["user_profile_photo"]!="Mr_profile_photo.png" and $query["user_profile_photo"]!="Mrs_profile_photo.png"){
					unlink("uploads/user_profile_photos/".$query["user_profile_photo"]);
				}
                $query_delete =mysqli_query($con, "DELETE FROM users WHERE user_id ='$user_id'");
                if($query_delete){
                    $description =$query["user_name"]." adlı kullanıcının kaydı silindi";
                    $query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Üye Silindi', do_transactions='$S_user_name'");
					message("success","check","Başarılı","Seçilen kullanıcı başarıyla silinmiştir. Lütfen bekleyiniz");
                    header("Refresh:1; url = http://localhost/admin/administrator.php?do=user_transactions", true, 303);
                }else{
					message("warning","warning","Dikkat!","Seçilen kullanıcı silinememiştir.");
                    header("Refresh:1; url = http://localhost/admin/administrator.php?do=user_transactions", true, 303);
                }
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