<?php
    if($S_query_users["user_authority"] < 3){
        ?>
        <!-- Main content -->
        <section class="content container-fluid">
          <?php
            $category_id = $_GET["category_id"];
			$query_delete =mysqli_query($con, "DELETE FROM categories WHERE category_id ='$category_id'");
			if($query_delete){
				$description =$category_id." id'li kategori silindi";
				$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Kategori Silindi', do_transactions='$S_user_name'");
				message("success","check","Başarılı","Seçilen kategori başarıyla silinmiştir. Lütfen bekleyiniz");
				header("Refresh:1; url = http://localhost/admin/administrator.php?do=category_settings", true, 303);
			}else{
				message("warning","warning","Dikkat!","Seçilen kategori silinememiştir.");
				header("Refresh:1; url = http://localhost/admin/administrator.php?do=category_settings", true, 303);
			}
            ?>
        </section>
        <!-- /.content -->  
    <?php
    }else{
		message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfaya yönlendirliyorsunuz...");
		header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
    }
?>