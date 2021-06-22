<?php if($S_query_users["user_authority"] < 3){ ?>
		<!-- Content Header (Page header) -->
		<section class="content-header"><h1>Slider ekleme</h1></section>
		<!-- Main content -->
		<section class="content container-fluid">
			<?php
				if($_POST){
					$slider_top_header=trim(case_converter($_POST["slider_top_header"]));
					$slider_bottom_header=trim(mb_convert_case($_POST["slider_bottom_header"], MB_CASE_TITLE, "utf-8"));
					$slider_description=trim($_POST["slider_description"]);
					$slider_buy_link=trim($_POST["slider_buy_link"]);
					$password=md5(trim($_POST["password"]));
					if(is_uploaded_file($_FILES["slider_photo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
						$slider_photo=pathinfo($_FILES["slider_photo"]["name"]); // fotografın yolunu gösterir
						$slider_photo_extension=$slider_photo["extension"]; //fotografın uzantsını alır
						if($slider_photo_extension=="png" or $slider_photo_extension=="PNG" or $slider_photo_extension=="jpg" or $slider_photo_extension=="JPG" or $slider_photo_extension=="jpeg" or                  $slider_photo_extension=="JPEG"){
							$slider_photo_file_name="slider_photo_".uniqid(True); // resime ekstra karakterler ekleyecek
							$slider_photo_new_adress="uploads/slider/".$slider_photo_file_name.".".$slider_photo_extension;
							if(move_uploaded_file($_FILES["slider_photo"]["tmp_name"],$slider_photo_new_adress)){
								$slider_photo=$slider_photo_file_name.".".$slider_photo_extension;
							}else{
								$hata=0;
								message("warning","warning","Dikkat!","Ürün fotoğrafı yüklenemedi");
							}
						}else{
							$hata=0;
							message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun fotoğraf ekleyiniz");
						}
					}else{
						$hata=0;
						message("warning","warning","Dikkat!","Ürün fotoğrafı yüklemediniz");
					}														
					if($hata){
						if(is_uploaded_file($_FILES["slider_price_photo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
							$slider_price_photo=pathinfo($_FILES["slider_price_photo"]["name"]); // fotografın yolunu gösterir
							$slider_price_photo_extension=$slider_price_photo["extension"]; //fotografın uzantsını alır
							if($slider_price_photo_extension=="png" or $slider_price_photo_extension=="PNG" or $slider_price_photo_extension=="jpg" or $slider_price_photo_extension=="JPG" or $slider_price_photo_extension=="jpeg" or                  $slider_price_photo_extension=="JPEG"){
								$slider_price_photo_file_name="slider_price_photo_".uniqid(True); // resime ekstra karakterler ekleyecek
								$slider_price_photo_new_adress="uploads/slider/".$slider_price_photo_file_name.".".$slider_price_photo_extension;
								if(move_uploaded_file($_FILES["slider_price_photo"]["tmp_name"],$slider_price_photo_new_adress)){
									$slider_price_photo=$slider_price_photo_file_name.".".$slider_price_photo_extension;
								}else{
									$hata=0;
									message("warning","warning","Dikkat!","Ürün fiyat fotoğrafı yüklenemedi");
								}
							}else{
								$hata=0;
								message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun fotoğraf ekleyiniz");
							}
						}else{
							$hata=0;
							message("warning","warning","Dikkat!","Ürün fiyat fotoğrafı yüklemediniz");
						}
						if($hata){
							if($password == $S_query_users["user_password"]){
								$query=mysqli_query($con,"INSERT INTO slider SET slider_top_header='$slider_top_header', slider_bottom_header='$slider_bottom_header', slider_description='$slider_description', slider_buy_link='$slider_buy_link', slider_photo='$slider_photo', slider_price_photo='$slider_price_photo', slider_adding='$S_user_name'");
								if($query == 1){
									$description ="Slider eklendi";
									$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Slider Eklendi', do_transactions ='$S_user_name'");
									message("success","check","Başarılı","Slider başarılı bir şekilde eklendi. Lütfen bekleyiniz.");
									header("Refresh:3; url = http://localhost/admin/administrator.php?do=slider_settings", true, 303);
								}else{
									message("warning","warning","Dikkat!","Slider eklenememiştir.");
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
							<h3 class="box-title">Slider ekle</h3>
							<a type="button" class="btn btn-danger pull-right" href="administrator.php?do=slider_settings"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
							<div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
						</div>
						<!-- form start -->
						<form role="form" method="post" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group col-md-12">
									<label>Üst başlık<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="slider_top_header" value="<?php if($_POST){ echo $slider_top_header; } ?>" placeholder="Üst başlık..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Alt başlık<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="slider_bottom_header" value="<?php if($_POST){ echo $slider_bottom_header; } ?>" placeholder="Alt başlık..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Açıklama<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="slider_description" value="<?php if($_POST){ echo $slider_description; } ?>" placeholder="Açıklama..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Stın alma linki<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="slider_buy_link" value="<?php if($_POST){ echo $slider_description; } ?>" placeholder="Satın alma linki..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Ürün fotoğrafı ekleyiniz</label>      <b>(Genişlik : 484 X Yükseklik : 441)</b><br />
									<div class="btn btn-default btn-file">
										<i class="fa  fa-file-photo-o"></i> Ürün fotoğrafı
										<input type="file" name="slider_photo">
									</div>
									<p class="help-block">Yalnızca png, jpg, jpeg yükleyiniz</p>
								</div>
								<div class="form-group col-md-6">
									<label>Ürün fiyat fotoğrafı ekleyiniz</label><br />
									<div class="btn btn-default btn-file">
										<i class="fa  fa-file-photo-o"></i> Ürün fiyat fotoğrafı
										<input type="file" name="slider_price_photo">
									</div>
									<p class="help-block">Yalnızca png, jpg, jpeg yükleyiniz</p>
								</div>
								<div class="form-group col-md-12 <?php if($_POST){ if($pass_result == 0 and isset($pass_result)){ echo'has-warning'; }} ?>" style="text-align: center;">
									<label>Şifreniz <span style="font-weight: 15px;">( İşlemi tamamlamak için kendi şifrenizi giriniz )</span><i style="color:#f00;">*</i></label>
									<input type="password" class="form-control" id="inputWarning" name="password" placeholder="Şifreniz..." required>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer"><button type="submit" class="btn btn-info pull-right">Slider ekle</button></div>
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