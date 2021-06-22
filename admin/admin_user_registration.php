<?php if($S_query_users["user_authority"] < 2){ ?>
		<!-- Content Header (Page header) -->
		<section class="content-header"><h1>Admin | Üye ekleme</h1></section>
		<!-- Main content -->
		<section class="content container-fluid">
			<?php
				$create_rand_password=substr(md5(microtime()),rand(0,26),5);// karışık olarak rastgele sayı ve harf üretir
				$create_user_password = $create_rand_password;
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
					$user_authority = $_POST["user_authority"];
					$user_password= md5($_POST["user_password"]);
					$password=md5(trim($_POST["password"]));
					$turkish_characters=array("ğ", "Ğ", "ç", "Ç", "ş", "Ş", "ü", "Ü", "ö", "Ö", "ı", "İ");
					foreach($turkish_characters as $value){
						$turkish=strstr($user_name, $value);
					}
					if($turkish==False){
						if($user_gender!="-1" and $user_authority!="-1"){
							$query_user_name = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE user_name = '$user_name'"));
							if ($query_user_name == 0){
								$query_user_email= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE user_email='$user_email'"));
								if ($query_user_email == 0){
									if(is_uploaded_file($_FILES["profile_photo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
										$profile_photo=pathinfo($_FILES["profile_photo"]["name"]); // fotografın yolunu gösterir
										$profile_photo_extension=$profile_photo["extension"]; //fotografın uzantsını alır
										if($profile_photo_extension=="png" or $profile_photo_extension=="PNG" or $profile_photo_extension=="jpg" or $profile_photo_extension=="JPG" or $profile_photo_extension=="jpeg" or                  $profile_photo_extension=="JPEG"){
											$profile_file_name=$user_name."_".uniqid(True); // resime ekstra karakterler ekleyecek
											$photo_new_adress="uploads/user_profile_photos/".$profile_file_name.".".$profile_photo_extension;
											if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"],$photo_new_adress)){
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
										if($user_gender==0){
											$new_adress="Mr_profile_photo.png";
										}else{
											$new_adress="Mrs_profile_photo.png";
										}
									}
									if($hata){
										if($password == $S_query_users["user_password"]){
											$query=mysqli_query($con,"INSERT INTO users SET user_name_surname='$user_name_surname', user_name='$user_name', user_birthday='$user_birthday', user_email='$user_email',                                                           user_phone_number='$user_phone_number', user_web_site='$user_web_site', user_facebook='$user_facebook', user_instagram='$user_instagram',                                                       user_twitter='$user_twitter', user_linkedin='$user_linkedin', user_pinterest='$user_pinterest', user_gender='$user_gender', user_authority =                                                   '$user_authority', user_password='$user_password', user_profile_photo='$new_adress', user_status=1, user_active_status='çevrimdışı'");
											if($query == 1){
												$description =$user_name." adında yeni bir üye oluşturuldu";
												$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Üye Eklendi', do_transactions ='$S_user_name'");
												message("success","check","Başarılı","Yeni üyemiz başarılı bir şekilde eklendi. Lütfen bekleyiniz.");
												header("Refresh:3; url = http://localhost/admin/administrator.php?do=user_transactions", true, 303);
											}else{
												message("warning","warning","Dikkat!","Üye eklenememiştir.");
											}
										}
									}else{
										$pass_result=0;
										message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
									}
								}else{
									message("warning","warning","Dikkat!","$user_email e-postasını kullanan başka bir üyeniz mevcut. Lütfen başka bir e-posta deneyiniz.");
								}
							}else{
								message("warning","warning","Dikkat!","$user_name kullanıcı adını kullanan başka bir üyeniz mevcut. Lütfen başka bir kullanıcı adı deneyiniz.");
							}
						}else{
							message("warning","warning","Dikkat!","Lütfen üye cinsiyetini ve üye yetkisini seçiniz");
						}
					}else{
						message("warning","warning","Dikkat!","Lütfen kullanıcı adında türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız");
					}
				}
			?>
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Yeni üye ekleme</h3>
							<a type="button" class="btn btn-danger pull-right" href="administrator.php?do=user_transactions"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
							<div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
						</div>
						<!-- form start -->
						<form role="form" name="registration" id="registration" method="post" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group col-md-6">
									<label>Üye adı<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="user_Name" value="<?php if($_POST){ echo $user_Name; } ?>" placeholder="Üye adı..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Üye soyadı<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="user_Surname" value="<?php if($_POST){ echo $user_Surname; } ?>" placeholder="Üye soyadı..." required>
								</div>
								<div class="form-group col-md-6 <?php if($_POST){ if(($query_user_name == 1 and isset($query_user_name)) or $turkish){ echo'has-warning'; }} ?>">
									<label>Üye kullanıcı adı<i style="color:#f00;">*</i></label>
									<span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız.</span>
									<input type="text" class="form-control" name="user_name" id="inputWarning" value="<?php if($_POST){ echo $user_name; } ?>" placeholder="Üye kullanıcı adı..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Üye doğum tarihi<i style="color:#f00;">*</i></label>
									<input type="date" class="form-control" name="user_birthday" value="<?php if($_POST){ echo $user_birthday; } ?>" placeholder="Üye doğum tarihi..." required>
								</div>
								<div class="form-group col-md-6 <?php if($_POST){ if($query_user_email == 1 and isset($query_user_email)){ echo'has-warning'; }} ?>">
									<label>Üye e-posta adresi<i style="color:#f00;">*</i></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="email" class="form-control" id="inputWarning" name="user_email" value="<?php if($_POST){ echo $user_email; } ?>" placeholder="Üye e-posta adresi..." required>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye telefon numarası<i style="color:#f00;">*</i></label>
									<span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen numaranızı (123 456 78 90) şeklinde başında 0 olmadan giriniz.</span>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
										<input type="text" class="form-control" name="user_phone_number" data-inputmask='"mask": "999 999 99 99"' data-mask pattern="[1-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" value="<?php if($_POST){ echo $user_phone_number; } ?>" placeholder="Üye telefon numarası..." required>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye web sitesi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-globe"></i></span>
										<input type="url" class="form-control" name="user_web_site" value="<?php if($_POST){ echo $user_web_site; } ?>" placeholder="Üye web sitesi...">
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye facebook adresi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
										<input type="url" class="form-control" name="user_facebook" value="<?php if($_POST){ echo $user_facebook; } ?>" placeholder="Üye facebook adresi...">
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye instagram adresi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-instagram"></i></span>
										<input type="url" class="form-control" name="user_instagram" value="<?php if($_POST){ echo $user_instagram; } ?>" placeholder="Üye instagram adresi...">
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye twitter adresi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-twitter"></i></span>
										<input type="url" class="form-control" name="user_twitter" value="<?php if($_POST){ echo $user_twitter; } ?>" placeholder="Üye twitter adresi...">
									</div>
								</div>
								<div class="form-group col-md-6">
									<label>Üye linkedin adresi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
										<input type="url" class="form-control" name="user_linkedin" value="<?php if($_POST){ echo $user_linkedin; } ?>" placeholder="Üye linkedin adresi...">
									</div>
								</div><div class="form-group col-md-6">
									<label>Üye pinterest adresi</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
										<input type="url" class="form-control" name="user_pinterest" value="<?php if($_POST){ echo $user_pinterest; } ?>" placeholder="Üye pinterest adresi...">
									</div>
								</div>
								<div class="form-group col-md-6 <?php if($_POST){ if($user_gender == "-1" and isset($user_gender)){ echo'has-warning'; }} ?>">
									<label>Üye cinsiyeti<i style="color:#f00;">*</i></label>
									<select name="user_gender" id="selectWarning" class="form-control">
										<option value="-1" selected <?php if($_POST){ if($user_gender == "-1"){echo "selected"; }} ?>>Üye cinsiyetini seçiniz...</option>
										<option value="0" <?php if($_POST){ if($user_gender == 0){echo "selected"; }} ?>>Bay</option>
										<option value="1" <?php if($_POST){ if($user_gender == 1){echo "selected"; }} ?>>Bayan</option>
									</select>
								</div>
								<div class="form-group col-md-6 <?php if($_POST){ if($user_authority == "-1" and isset($user_authority)){ echo'has-warning'; }} ?>">
									<label>Üye yetkisi<i style="color:#f00;">*</i></label>
									<select name="user_authority" id="selectWarning" class="form-control">
										<option value="-1" selected <?php if($_POST){ if($user_authority == "-1"){echo "selected"; }} ?>>Üye yetkisi seçiniz...</option>
										<option value="0" <?php if($S_query_users['user_authority'] == 0){if($_POST and $user_authority == 0){echo 'selected';}} else{echo'hidden';} ?>>Kurucu</option>
										<option value="1" <?php if($_POST){ if($user_authority == 1){echo "selected"; }} ?>>Site yönetici</option>
										<option value="2" <?php if($_POST){ if($user_authority == 2){echo "selected"; }} ?>>Editör</option>
										<option value="3" <?php if($_POST){ if($user_authority == 3){echo "selected"; }} ?>>Yazar</option>
									</select>
								</div>
								 <div class="form-group col-md-6">
									<label>Üye şifre</label>
									<input type="text" class="form-control" name="user_password" value="<?php if($_POST){ echo $_POST["user_password"]; }else{ echo $create_user_password; } ?>" readonly>
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
							<div class="box-footer"><button type="submit" class="btn btn-info pull-right">Yeni üye ekle</button></div>
						</form>
					</div>
					<!-- /.box .box-info-->
				</div>
				<!-- /.col-md-12 -->
			</div>
			<!--/.row-->
		</section>
		<!-- /.content .container-fluid -->
<?php 
	}else{
		message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfaya yönlendirliyorsunuz...");
		header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
	}
?>