<?php
if($S_query_users["user_authority"] < 2){
    $user_id = $_GET['user_id'];
    $query =mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE user_id ='$user_id'"));
    if($S_query_users["user_authority"] >= $query["user_authority"]){
		message("danger","ban","Dikkat!","Bu kullanıcı düzenlenemez. Lütfen beklyiniz");
        header("Refresh:1; url =http://localhost/admin/administrator.php?do=user_transactions");
    }else{
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header"><h1>Üye düzenle</h1></section>
        <!-- Main content -->
        <section class="content container-fluid">
            <?php
                $name_surname=explode(" ",$query["user_name_surname"]); // veritabanından gelen adı ve soyadını parçalara ayırır ve dizi şeklimnde degişkene atar
                $surname=array_reverse($name_surname)[0]; //diziyi ters çevirir ve ilk elemanını degişkene atar
                array_pop($name_surname); //dizinin son elemanını siler
                $name=implode(" ",$name_surname); //dizideki kalan elemanları aralarında boşluk olucak şekilde birleştirerek degişkene atar
                if($_POST){
                    $user_Name=trim(mb_convert_case($_POST["user_Name"], MB_CASE_TITLE, "utf-8"));
                    $user_Surname=trim(case_converter($_POST["user_Surname"]));
                    $user_name_surname=$user_Name." ".$user_Surname;
                    $user_name=trim($_POST["user_name"]);
                    $user_birthday=$_POST["user_birthday"];
                    $user_email=trim($_POST["user_email"]);
                    $user_phone_number=$_POST["user_phone_number"];
                    $user_web_site=$_POST["user_web_site"];
                    $user_facebook=$_POST["user_facebook"];
                    $user_instagram=$_POST["user_instagram"];
                    $user_twitter=$_POST["user_twitter"];
                    $user_linkedin=$_POST["user_linkedin"];
                    $user_pinterest=$_POST["user_pinterest"];
                    $user_gender=$_POST["user_gender"];
                    $user_status = $_POST["user_status"];
                    $user_authority = $_POST["user_authority"];
                    $password=md5(trim($_POST["password"]));
                    $turkish_characters=array("ğ", "Ğ", "ç", "Ç", "ş", "Ş", "ü", "Ü", "ö", "Ö", "ı", "İ");
                    foreach($turkish_characters as $value){
                        $turkish=strstr($user_name, $value);
                    }
                    if($turkish==False){
                        if(is_uploaded_file($_FILES["profile_photo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
                            $profile_photo=pathinfo($_FILES["profile_photo"]["name"]); // fotografın yolunu gösterir
                            $profile_photo_extension=$profile_photo["extension"]; //fotografın uzantsını alır
                            if($profile_photo_extension=="png" or $profile_photo_extension=="PNG" or $profile_photo_extension=="jpg" or $profile_photo_extension=="JPG" or $profile_photo_extension=="jpeg" or                  $profile_photo_extension=="JPEG"){
                                $profile_file_name=$user_name."_".uniqid(True); // resime ekstra karakterler ekleyecek
                                $photo_new_adress="uploads/user_profile_photos/".$profile_file_name.".".$profile_photo_extension;
                                if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"],$photo_new_adress)){
									if($query["user_profile_photo"]!="Mrs_profile_photo.png" or $query["user_profile_photo"]!="Mr_profile_photo.png"){
										unlink("uploads/user_profile_photos/".$query["user_profile_photo"]);
									}
                                    $new_adress=$profile_file_name.".".$profile_photo_extension;
                                }else{
									$hata=0;
									message("warning","warning","Dikkat!","Profil fotoğrafı yüklenemedi");
                                }
                            }else{
								$hata=0;
								message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun fotoğraf ekleyiniz");
                            }
                        }else{
                            $new_adress=$query["user_profile_photo"];
                        }
						if($hata){
							if($password == $S_query_users["user_password"]){
								$query_update =mysqli_query($con, "UPDATE users SET user_name_surname='$user_name_surname', user_name='$user_name', user_birthday='$user_birthday', user_email='$user_email',                                                                                   user_phone_number='$user_phone_number', user_web_site='$user_web_site', user_facebook='$user_facebook', user_instagram='$user_instagram',                                                                           user_twitter='$user_twitter', user_linkedin='$user_linkedin', user_pinterest='$user_pinterest', user_gender='$user_gender', user_status='$user_status',                                                             user_authority = '$user_authority', user_profile_photo='$new_adress' WHERE user_id ='$user_id'");
								if($query_update){
									$descripton =$query['user_name']." adlı kullancının kaydı güncellendi";
									$qeury_1 =mysqli_query($con, "INSERT INTO system_archives SET description ='$descripton', made_transaction ='Üye Güncellendi', do_transactions ='$S_user_name'");
									message("success","check","Başarılı","Kullanıcı başarılı bir şekilde güncellendi");
									header("Refresh:1; url = http://localhost/admin/administrator.php?do=user_transactions", true, 303);
								}else{
									message("warning","warning","Dikkat!","Güncelleme yapılamadı. Lütfen tekrar deneyiniz");
								}
							}else{
								$pass_result=0;
								message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
							}
						}
                    }else{
						message("warning","warning","Dikkat!","Lütfen kullanıcı adında türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız");
                    }
                }
            ?>
            <div class="row">
                <!-- left column -->
                <div class="col-md-2">
                    <!-- Profile Image -->
                    <div class="box box-info">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" style="max-width: initial; width: 200px; height: 200px" src="uploads/user_profile_photos/<?php echo $query["user_profile_photo"] ?>" alt="User profile picture">
                            <h3 class="profile-username text-center"><?php echo $query["user_name"]; ?></h3>
                            <h5 class="text-center"><?php echo $query["user_name_surname"]; ?></h5>
                            <p class="text-muted text-center"><?php if($query["user_birthday"]=="0000-00-00"){ }else{ echo date_format(date_create($query["user_birthday"]),'d.m.Y'); } ?></p>
                            <p class="text-muted text-center"><?php echo $query["user_phone_number"]; ?></p>
                            <p class="text-muted text-center"><?php echo $query["user_email"]; ?></p>
                            <p class="text-center" 
                               <?php if(empty($query["user_web_site"]) and empty($query["user_facebook"]) and empty($query["user_instagram"]) and empty($query["user_twitter"]) and empty($query["user_linkedin"]) and                                  empty($query["user_pinterest"])){ echo"hidden"; } ?>>
                                <a target="_blank" href="<?php echo $query['user_web_site']; ?>" <?php if(empty($query["user_web_site"])){ echo"hidden"; } ?>><i class="fa fa-globe"></i></a>&nbsp;
                                <a target="_blank" href="<?php echo $query['user_facebook']; ?>" <?php if(empty($query["user_facebook"])){ echo"hidden"; } ?>><i class="fa fa-facebook"></i></a>&nbsp;
                                <a target="_blank" href="<?php echo $query['user_instagram']; ?>" <?php if(empty($query["user_instagram"])){ echo"hidden"; } ?>><i class="fa fa-instagram"></i></a>&nbsp;
                                <a target="_blank" href="<?php echo $query['user_twitter']; ?>" <?php if(empty($query["user_twitter"])){ echo"hidden"; } ?>><i class="fa fa-twitter"></i></a>&nbsp;
                                <a target="_blank" href="<?php echo $query['user_linkedin']; ?>" <?php if(empty($query["user_linkedin"])){ echo"hidden"; } ?>><i class="fa fa-linkedin"></i></a>&nbsp;
                                <a target="_blank" href="<?php echo $query['user_pinterest']; ?>" <?php if(empty($query["user_pinterest"])){ echo"hidden"; } ?>><i class="fa fa-pinterest"></i></a>
                            </p>
                            <p class="text-center">
                                <?php
                                    if($query["user_gender"] == 0){
                                        echo"<span class='label label-info' style='margin-right:5px;'>Bay</span>";
                                    }else{
                                        echo"<span class='label label-danger' style='margin-right:5px;'>Bayan</span>";
                                    }
                                    if($query["user_authority"] == 0){
                                        echo"<span class='label label-info'>Kurucu</span>";
                                    }else if($query["user_authority"] == 1){
                                        echo"<span class='label label-primary'>Site yöneticisi</span>";
                                    }else if($query["user_authority"] == 2){
                                        echo"<span class='label label-success'>Editör</span>";
                                    }else if($query["user_authority"] == 3){
                                        echo"<span class='label label-danger'>Yazar</span>";
                                    }
                                    if($query["user_status"] == 1){
                                        echo"<span class='label label-success' style='margin-left:5px;'>Onaylı</span>";
                                    }else{
                                        echo"<span class='label label-danger' style='margin-left:5px;'>Onaylı değil</span>";
                                    }
                                ?>
                            </p>
                            <p class="text-muted text-center"><?php echo $query["user_registration_date"]; ?></p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- left column -->
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Üye Güncelleme İşlemi</h3>
                            <a type="button" class="btn btn-danger pull-right" style="margin-left: 1%;" href="administrator.php?do=user_transactions"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
                            <a type="button" class="btn btn-warning pull-right" onClick="return del();" href="administrator.php?do=user_delete&user_id=<?php echo $query['user_id']; ?>&user_name=<?php echo $query['user_name']; ?>&user_authority=<?php echo $query['user_authority']; ?>"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Üyeyi sil</a>
                            <div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
                        </div>
                        <!-- form start -->
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group col-md-6">
                                    <label>Üye adı<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="user_Name" value="<?php echo $name; ?>" placeholder="Üye adı..." required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye soyadı<i style="color:#f00;">*</i></label>
                                    <input type="text" class="form-control" name="user_Surname" value="<?php echo $surname; ?>" placeholder="Üye soyadı..." required>
                                </div>
                                <div class="form-group col-md-6 <?php if($_POST){ if($turkish){ echo'has-warning'; }} ?>">
                                    <label>Üye kullanıcı adı<i style="color:#f00;">*</i></label>
                                    <span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız.</span>
                                    <input type="text" class="form-control" id="inputWarning" name="user_name" value ="<?php echo $query['user_name']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye doğum tarihi</label>
                                    <input type="date" class="form-control" name="user_birthday" value="<?php echo $query["user_birthday"]; ?>" placeholder="Üye doğum tarihi...">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye e-posta adresi<i style="color:#f00;">*</i></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="user_email" value ="<?php echo $query['user_email']; ?>" placeholder="Üye e-posta adresi..." required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye telefon numarası<i style="color:#f00;">*</i></label>
                                    <span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen numaranızı (123 456 78 90) şeklinde başında 0 olmadan giriniz.</span>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="user_phone_number" data-inputmask='"mask": "999 999 99 99"' data-mask pattern="[1-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" value="<?php echo $query['user_phone_number']; ?>" placeholder="Üye telefon numarası..." required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye web sitesi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                        <input type="url" class="form-control" name="user_web_site" value="<?php echo $query['user_web_site']; ?>" placeholder="Üye web sitesi...">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye facebook adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                        <input type="url" class="form-control" name="user_facebook" value="<?php echo $query['user_facebook']; ?>" placeholder="Üye facebook adresi...">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye instagram adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                        <input type="url" class="form-control" name="user_instagram" value="<?php echo $query['user_instagram']; ?>" placeholder="Üye instagram adresi...">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye twitter adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                        <input type="url" class="form-control" name="user_twitter" value="<?php echo $query['user_twitter']; ?>" placeholder="Üye twitter adresi...">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye linkedin adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                        <input type="url" class="form-control" name="user_linkedin" value="<?php echo $query['user_linkedin']; ?>" placeholder="Üye linkedin adresi...">
                                    </div>
                                </div><div class="form-group col-md-6">
                                    <label>Üye pinterest adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
                                        <input type="url" class="form-control" name="user_pinterest" value="<?php echo $query['user_pinterest']; ?>" placeholder="Üye pinterest adresi...">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye cinsiyeti</label>
                                    <select name="user_gender" class="form-control">
                                        <option value="0" <?php if($query['user_gender'] == 0){echo "selected"; } ?>>Bay</option>
                                        <option value="1" <?php if($query['user_gender'] == 1){echo "selected"; } ?>>Bayan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye Durum</label>
                                    <select name="user_status" id="user_status" class="form-control">
                                        <option value="1" <?php if($query['user_status'] == 1){echo 'selected';} ?>>Onaylı</option>
                                        <option value="0" <?php if($query['user_status'] == 0 or $query['user_status'] == 2){echo 'selected';} ?>>Onaylı değil</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Üye Yetki</label>
                                        <select name="user_authority" id="user_authority" class="form-control">
                                        <option value="0" <?php if($S_query_users['user_authority'] == 0){ if($query['user_authority'] == 0){echo 'selected';}} else{echo'hidden';} ?>>Kurucu</option>
                                        <option value="1" <?php if($query['user_authority'] == 1){echo 'selected';} ?>>Site Yöneticisi</option>
                                        <option value="2" <?php if($query['user_authority'] == 2){echo 'selected';} ?>>Editör</option>
                                        <option value="3" <?php if($query['user_authority'] == 3){echo 'selected';} ?>>Yazar</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Profil fotoğrafı ekleyiniz</label><br />
                                    <div class="btn btn-default btn-file">
                                        <i class="fa  fa-file-photo-o"></i> Profil fotoğrafı
                                        <input type="file" name="profile_photo">
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
            }
        }else{
			message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfasya yönlendirliyorsunuz");
            header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
        }
?>
