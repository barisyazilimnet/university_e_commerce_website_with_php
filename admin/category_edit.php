<?php
if($S_query_users["user_authority"] < 3){
    $category_id = $_GET['category_id'];
    $query =mysqli_fetch_array(mysqli_query($con, "SELECT * FROM categories WHERE category_id ='$category_id'"));
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header"><h1>Kategori düzenle</h1></section>
        <!-- Main content -->
        <section class="content container-fluid">
            <?php
                if($_POST){
					$category_name=trim(mb_convert_case($_POST["category_name"], MB_CASE_TITLE, "utf-8"));
					$category_order=trim($_POST["category_order"]);
					$category_visibility=trim($_POST["category_visibility"]);
					$password=md5(trim($_POST["password"]));
					if($password == $S_query_users["user_password"]){
						$query_update =mysqli_query($con, "UPDATE categories SET category_order='$category_order', category_name='$category_name', category_visibility='$category_visibility' WHERE category_id ='$category_id'");
						if($query_update){
							$descripton =$category_id." id'li kategori güncellendi";
							$qeury_1 =mysqli_query($con, "INSERT INTO system_archives SET description ='$descripton', made_transaction ='Kategori Güncellendi', do_transactions ='$S_user_name'");
							message("success","check","Başarılı","Kategori başarılı bir şekilde güncellendi");
							header("Refresh:1; url = http://localhost/admin/administrator.php?do=category_settings", true, 303);
						}else{
							message("warning","warning","Dikkat!","Güncelleme yapılamadı. Lütfen tekrar deneyiniz");
						}
					}else{
						$pass_result=0;
						message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
					}
                }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Kategori Güncelleme İşlemi</h3>
                            <a type="button" class="btn btn-danger pull-right" style="margin-left: 1%;" href="administrator.php?do=category_settings"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
                            <a type="button" class="btn btn-warning pull-right" onClick="return del();" href="administrator.php?do=category_delete&category_id=<?php echo $query['category_id']; ?>"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Üyeyi sil</a>
                            <div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
                        </div>
                        <!-- form start -->
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group col-md-12">
                                    <label>Kategori sırası<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="category_order" value="<?php echo $query['category_order']; ?>" placeholder="Kategori sırası..." required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Kategori adı<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $query['category_name']; ?>" placeholder="Kategori adı..." required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Kategori görünürlüğü</label>
                                    <select name="category_visibility" class="form-control">
                                        <option value="0" <?php if($query['category_visibility'] == 0){echo "selected"; } ?>>Hayır</option>
                                        <option value="1" <?php if($query['category_visibility'] == 1){echo "selected"; } ?>>Evet</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 <?php if($_POST){ if($pass_result == 0 and isset($pass_result)){ echo'has-warning'; }} ?>" style="text-align: center;">
                                    <label>Şifreniz <span style="font-weight: 15px;">( İşlemi tamamlamak için kendi şifrenizi giriniz )</span><i style="color:#f00;">*</i></label>
                                    <input type="password" class="form-control" id="inputWarning" name="password" placeholder="Şifreniz..." required>
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
	<?php
        }else{
			message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfasya yönlendirliyorsunuz...");
            header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
        }
?>
