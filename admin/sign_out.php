<!-- Main content -->
<section class="content container-fluid">
    <?php
        session_destroy();
        header("Refresh:3; url = http://localhost/admin");
        $user_update=mysqli_query($con,"UPDATE users SET user_active_status='' WHERE user_id='$S_user_id'");
		message("success","check","Başarılı","Başarılı bir şekilde çıkış yaptınız. Lütfen bekleyiniz yönlendiriliyorsunuz.");
	?>
</section>
<!-- /.content -->