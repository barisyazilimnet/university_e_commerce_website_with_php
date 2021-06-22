<?php
if($S_query_users["user_authority"] < 2){
    $id = $_GET['id'];
	$query_product=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM products"));
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header"><h1>Üye düzenle</h1></section>
        <!-- Main content -->
        <section class="content container-fluid">
            <?php
                if($_POST){
					$name=trim(mb_convert_case($_POST["name"], MB_CASE_TITLE, "utf-8"));
					$category_id=$_POST["category_id"];
					$stock_information=$_POST["stock_information"];
					$detail=$_POST["detail"];
					$price=$_POST["price"];
					$password=md5(trim($_POST["password"]));
					if(is_uploaded_file($_FILES["photo"]["tmp_name"])){ // fotograf yüklenip yüklenmedigini kontrol eder
						$photo=pathinfo($_FILES["photo"]["name"]); // fotografın yolunu gösterir
						$photo_extension=$photo["extension"]; //fotografın uzantsını alır
						if($photo_extension=="png" or $photo_extension=="PNG" or $photo_extension=="jpg" or $photo_extension=="JPG" or $photo_extension=="jpeg" or $photo_extension=="JPEG"){
							$photo_file_name=str_replace(" ","_",$_POST["name"])."_photo_".uniqid(True); // resime ekstra karakterler ekleyecek
							$photo_new_adress="../uploads/products/".$photo_file_name.".".$photo_extension;
							if(move_uploaded_file($_FILES["photo"]["tmp_name"],$photo_new_adress)){
								if($query_product["photo"]){
									unlink("../uploads/products/".$query_product["photo"]);
								}
								$photo=$photo_file_name.".".$photo_extension;
							}else{
								$hata=0;
								message("warning","warning","Dikkat!","Ürün fotografı yüklenemedi");
							}
						}else{
							$hata=0;
							message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun fotoğraf ekleyiniz");
						}
					}else{
						 $photo=$query_product["photo"];
					}														
					if($hata){
						if($password == $S_query_users["user_password"]){
							$query=mysqli_query($con,"UPDATE products SET name='$name', category_id='$category_id', stock_information='$stock_information', detail='$detail', price='$price', photo='$photo' WHERE id='$id'");
							if($query == 1){
								$description =$name." ürünü eklendi";
								$query =mysqli_query($con, "INSERT INTO system_archives SET description ='$description', made_transaction ='Ürün Eklendi', do_transactions ='$S_user_name'");
								message("success","check","Başarılı","Ürün başarılı bir şekilde eklendi. Lütfen bekleyiniz.");
								header("Refresh:3; url = http://localhost/admin/administrator.php?do=product_transactions", true, 303);
							}else{
								message("warning","warning","Dikkat!","Ürün eklenememiştir.");
							}
						}else{
							$pass_result=0;
							message("warning","warning","Dikkat!","Şifrenizi yanlış girdiniz.");
						}
					}
                }
            ?>
            <div class="row">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Üye Güncelleme İşlemi</h3>
                            <div style="margin-top: 10px;"><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
                        </div>
                        <!-- form start -->
						<form role="form" method="post" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group col-md-12">
									<label>Ürün kategorisi</label>
									<select class="form-control" name="category_id">
										<?php
											$query=mysqli_query($con,"SELECT * FROM categories");
											while($categories=mysqli_fetch_array($query)){ ?>
												<option value="<?php echo $categories["category_id"]; ?>" <?php if($_POST){ if($category_id==$categories["category_id"]){ echo"selected"; } }else{ if($categories["category_id"]==$query_product["category_id"]){ echo "selected"; } } ?>>
													<?php echo $categories["category_name"]; ?>
												</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-md-12">
									<label>Ürün adı<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="name" value="<?php if($_POST){ echo $name; }else{ echo $query_product["name"]; } ?>" placeholder="Ürün adı..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Ürün fiyatı<i style="color:#f00;">*</i></label>
									<input type="text" class="form-control" name="price" value="<?php if($_POST){ echo $price; }else{ echo $query_product["price"]; } ?>" placeholder="Ürün fiyatı..." required>
								</div>
								<div class="form-group col-md-12">
									<label>Ürün detayı<i style="color:#f00;">*</i></label>
									<textarea class="form-control" name="detail" rows="10"><?php if($_POST){ echo $detail; }else{ echo $query_product["detail"]; } ?></textarea>
								</div>
								<div class="form-group col-md-12">
									<label>Stok bilgisi</label>
									<select class="form-control" name="stock_information">
										<option value="1" <?php if($_POST){ if($category_id==1){ echo"selected"; } }else{ if($query_product["stock_information"]==1){ echo "selected"; } } ?>>Var</option>
										<option value="0" <?php if($_POST){ if($category_id==0){ echo"selected"; } }else{ if($query_product["stock_information"]==0){ echo "selected"; } } ?>>Tükendi</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label>Ürün fotoğrafı ekleyiniz</label><br>
									<div class="btn btn-default btn-file">
										<i class="fa  fa-file-photo-o"></i> Ürün fotoğrafı
										<input type="file" name="photo">
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
        </section>
        <!-- /.content -->
        <?php
        }else{
			message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfasya yönlendirliyorsunuz");
            header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
        }
?>
