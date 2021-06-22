<?php if($S_query_users["user_authority"] < 3){  ?>
		<!-- Content Header (Page header) -->
		<section class="content-header"><h1>Kategori ekleme</h1></section>
		<!-- Main content -->
		<section class="content container-fluid">
			<?php
				if($_POST){
					$category_name=trim(mb_convert_case($_POST["category_name"], MB_CASE_TITLE, "utf-8"));
					$category_order=trim($_POST["category_order"]);
					$category_visibility=trim($_POST["category_visibility"]);
					$password=md5(trim($_POST["password"]));
					if($password == $S_query_users["user_password"]){
						$query=mysqli_query($con,"INSERT INTO categories SET category_order='$category_order', category_name='$category_name', category_visibility='$category_visibility', adding='$S_user_name'");
						if($query == 1){
							$description ="Kategori eklendi";
							$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Kategori Eklendi', do_transactions ='$S_user_name'");
							message("success","check","Başarılı","Kategori başarılı bir şekilde eklendi. Lütfen bekleyiniz.");
							header("Refresh:3; url = http://localhost/admin/administrator.php?do=category_settings", true, 303);
						}else{
							message("warning","warning","Dikkat!","Kategori eklenememiştir.");
						}
					}else{
						$pass_result=0;
						message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
					}
				}
			?>
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Kategori ekle</h3>
							<a type="button" class="btn btn-danger pull-right" href="administrator.php?do=slider_transactions"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
							<div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
						</div>
						<!-- form start -->
						<form role="form" method="post" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group col-md-12">
									<label>Kategori sırası<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="category_order" value="<?php if($_POST){ echo $category_order; } ?>" placeholder="Kategori sırası..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Kategori adı<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="category_name" value="<?php if($_POST){ echo $category_name; } ?>" placeholder="Kategori adı..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Kategori Görünürlüğü</label>
									<select name="category_visibility" id="category_visibility" class="form-control">
										<option value="0" <?php if($_POST){ if($category_visibility == 0){echo "selected"; }} ?>>Hayır</option>
										<option value="1" <?php if($_POST){ if($category_visibility == 1){echo "selected"; }}else{ echo "selected"; } ?>>Evet</option>
									</select>
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