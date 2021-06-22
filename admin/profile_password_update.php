<!-- Content Header (Page header) -->
<section class="content-header"><h1>Profilim</h1></section>
<!-- Main content -->
<section class="content container-fluid">
    <?php
        if($_POST){
            $new_password = md5(trim($_POST["new_password"]));
            $new_password2 = md5(trim($_POST["new_password2"]));
            $old_password = md5(trim($_POST["old_password"]));
            if($new_password==$new_password2){
                if($S_query_users["user_password"]==$old_password){
                    $query_update =mysqli_query($con, "UPDATE users SET user_password='$new_password' WHERE user_id ='$S_user_id'");                
                    if($query_update){
						message("success","check","Başarılı","Şifreniz başarılı bir şekilde güncellendi");
                        header("Refresh:2; url = http://localhost/admin/administrator.php?do=profile", true, 303);
                    }else{
						message("warning","warning","Dikkat!","Güncelleme yapılamadı. Lütfen tekrar deneyiniz.");
                    }
                }else{
					message("warning","warning","Dikkat!","Eski şifrenizi yanlış girdiniz");
                }
            }else{
				message("warning","warning","Dikkat!","Yeni şifreleriniz uyuşmuyor.");
            }
        }
    ?>
    <div class="row"  style="padding: 10% 0 0 30%;">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Şifre Güncelleme</h3><a type="button" class="btn btn-danger pull-right" href="administrator.php?do=profile"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
                </div>
                <!-- form start -->
                <form role="form" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Yeni şifreniz</label>
                            <input type="password" class="form-control" name="new_password" placeholder="Yeni şifreniz..." required>
                        </div>
                        <div class="form-group">
                            <label>Yeni şifreniz (tekrar)</label>
                            <input type="password" class="form-control" name="new_password2" placeholder="Yeni şifreniz (tekrar)..." required>
                        </div>
                        <div class="form-group">
                            <label>Eski şifreniz</label>
                            <input type="password" class="form-control" name="old_password" placeholder="Eski şifreniz..." required>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer"><button type="submit" class="btn btn-info pull-right">Güncelle</button></div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->