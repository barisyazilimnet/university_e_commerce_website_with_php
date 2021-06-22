<?php if($S_query_users["user_authority"] < 2){ ?>
        <!-- Content Header (Page header) -->
        <section class="content-header"><h1>Site ayarları</h1></section>
        <!-- Main content -->
        <section class="content container-fluid">
            <?php
                $query=mysqli_fetch_array(mysqli_query($con, "SELECT * FROM settings"));
                if($_POST){
                    $site_url=$_POST["site_url"];
                    $site_title=$_POST["site_title"];
                    $site_keywords=$_POST["site_keywords"];
                    $site_description=$_POST["site_description"];
                    $site_status=$_POST["site_status"];
                    $site_theme=$_POST["site_theme"];
                    $site_phone_number=$_POST["site_phone_number"];
                    $site_email=$_POST["site_email"];
                    $site_facebook=$_POST["site_facebook"];
                    $site_twitter=$_POST["site_twitter"];
                    $site_linkedin=$_POST["site_linkedin"];
                    $site_instagram=$_POST["site_instagram"];
                    $site_pinterest=$_POST["site_pinterest"];
                    $password=md5($_POST["password"]);
                    if(is_uploaded_file($_FILES["site_logo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
                        $site_logo=pathinfo($_FILES["site_logo"]["name"]); // fotografın yolunu gösterir
                        $site_logo_extension=$site_logo["extension"]; //fotografın uzantsını alır
                        if($site_logo_extension=="png" or $site_logo_extension=="PNG" or $site_logo_extension=="jpg" or $site_logo_extension=="JPG" or $site_logo_extension=="jpeg" or $site_logo_extension=="JPEG"){
                            $site_logo_file_name="site_logo_".uniqid(True); // resime ekstra karakterler ekleyecek
                            $site_logo_new_adress="uploads/site_logo/".$site_logo_file_name.".".$site_logo_extension;
                            if(move_uploaded_file($_FILES["site_logo"]["tmp_name"],$site_logo_new_adress)){
								if($query["site_logo"]){
									unlink("uploads/site_logo/".$query["site_logo"]);
								}
                                $site_logo=$site_logo_file_name.".".$site_logo_extension;
                            }else{
								$hata=0;
								message("warning","warning","Dikkat!","Site logo fotoğrafı yüklenemedi.");
                            }
                        }else{
							$hata=0;
							message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun site logo fotoğrafı ekleyiniz.");
                        }
                    }else{
                        $site_logo=$query["site_logo"];
                    }
					if($hata){
						if(is_uploaded_file($_FILES["site_title_icon"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
							$site_title_icon=pathinfo($_FILES["site_title_icon"]["name"]); // fotografın yolunu gösterir
							$site_title_icon_extension=$site_title_icon["extension"]; //fotografın uzantsını alır
							if($site_title_icon_extension=="png" or $site_title_icon_extension=="PNG" or $site_title_icon_extension=="jpg" or $site_title_icon_extension=="JPG" or $site_title_icon_extension=="jpeg" or                           $site_title_icon_extension=="JPEG"){
								$site_title_icon_file_name="site_title_icon_".uniqid(True); // resime ekstra karakterler ekleyecek
								$site_title_icon_new_adress="uploads/site_title_icon/".$site_title_icon_file_name.".".$site_title_icon_extension;
								if(move_uploaded_file($_FILES["site_title_icon"]["tmp_name"],$site_title_icon_new_adress)){
									if($query["site_title_icon"]){
										unlink("uploads/site_title_icon/".$query["site_title_icon"]);
									}
									$site_title_icon=$site_title_icon_file_name.".".$site_title_icon_extension;
								}else{
									$hata=0;
									message("warning","warning","Dikkat!","Site icon fotoğrafı yüklenemedi.");
								}
							}else{
								$hata=0;
								message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun site icon fotoğrafı ekleyiniz.");
							}
						}else{
							$site_title_icon=$query["site_title_icon"];
						}
						if($hata){
							if($password == $S_query_users["user_password"]){
								$query_1=mysqli_query($con, "UPDATE settings SET site_url='$site_url', site_title='$site_title', site_keywords='$site_keywords', site_description='$site_description', site_status='$site_status',                                                      site_theme='$site_theme', site_phone_number='$site_phone_number', site_email='$site_email', site_facebook='$site_facebook', site_twitter='$site_twitter',                                                              site_linkedin='$site_linkedin', site_instagram='$site_instagram', site_pinterest='$site_pinterest', site_logo='$site_logo',                                                                                  site_title_icon='$site_title_icon'");
								if($query_1){
									$description ="Site ayarları güncellendi";
									$query_2 =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Site Ayarları Güncellendi', do_transactions ='$S_user_name'");
									message("success","check","Başarılı","Site ayarları başarılı bir şekilde güncellendi");
									header("Refresh:1; url = http://localhost/admin/administrator.php?do=site_settings", true, 303);
								}else{
									message("warning","warning","Dikkat!","Güncelleme yapılamadı. Lütfen tekrar deneyiniz");
								}
							}else{
								$pass_result=0;
								message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
							}
						}
					}
                }
            ?>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Site ayarları güncelleme işlemi</h3><a type="button" class="btn btn-danger pull-right" href="administrator.php"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
                            <div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
                        </div>
                        <!-- form start -->
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group col-md-6">
                                    <label>Site URL<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_url" value="<?php echo $query['site_url']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Başlığı<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_title" value="<?php echo $query['site_title']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Anahatar Kelimeler<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_keywords" value="<?php echo $query['site_keywords']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Açıklama<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_description" value="<?php echo $query['site_description']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Durum</label>
                                    <select name="site_status" class="form-control">
                                        <option value="0" <?php if($query["site_status"]==0){ echo"selected";} ?> >Kapalı</option>
                                        <option value="1" <?php if($query["site_status"]==1){ echo"selected";} ?> >Açık</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Tema</label>
                                    <select name="site_theme" class="form-control">
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site İletişim Numarası<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_phone_number" value="<?php echo $query['site_phone_number']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site E-Posta Adresi<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="site_email" value="<?php echo $query['site_email']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Facebook Adresi</label>
                                    <input type="text" class="form-control" name="site_facebook" value="<?php echo $query['site_facebook']; ?>" placeholder="Site Facebook Adresi...">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Twitter Adresi</label>
                                    <input type="text" class="form-control" name="site_twitter" value="<?php echo $query['site_twitter']; ?>" placeholder="Site Twitter Adresi...">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Linkedin Adresi</label>
                                    <input type="text" class="form-control" name="site_linkedin" value="<?php echo $query['site_linkedin']; ?>" placeholder="Site Linkedin Adresi...">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site İnstagram Adresi</label>
                                    <input type="text" class="form-control" name="site_instagram" value="<?php echo $query['site_instagram']; ?>" placeholder="Site İnstagram Adresi...">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Site Pinterest Adresi</label>
                                    <input type="text" class="form-control" name="site_pinterest" value="<?php echo $query['site_pinterest']; ?>" placeholder="Site Pinterest Adresi...">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Site logosu ekleyiniz</label><br />
                                    <div class="btn btn-default btn-file">
                                        <i class="fa  fa-file-photo-o"></i> Site logosu
                                        <input type="file" name="site_logo">
                                    </div>
                                    <p class="help-block">Yalnızca png, jpg, jpeg yükleyiniz</p>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Site başlık iconu ekleyiniz</label><br />
                                    <div class="btn btn-default btn-file">
                                        <i class="fa  fa-file-photo-o"></i> Site başlık iconu
                                        <input type="file" name="site_title_icon">
                                    </div>
                                    <p class="help-block">Yalnızca png, jpg, jpeg yükleyiniz</p>
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
			message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfaya yönlendirliyorsunuz");
			header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
    	}
?>
