<!DOCTYPE html>
<?php 
	require_once "../system/settings.php"; 
	require_once "../system/system.php"; 
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Paneli | <?php echo $query_settings["site_title"]; ?></title>
        <link rel="shortcut icon" href="uploads/site_title_icon/<?php echo $query_settings['site_title_icon']; ?>" type="image/x-icon"> 
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Sayafa Çalışması için gerekli javascipt kodu -->
        <style>
            html,body{
                height:initial !important;
            }
            button:active{
                outline: initial !important;
                outline-offset: initial !important;
                -webkit-focus-ring-color:initial !important;
                -webkit-box-shadow: initial !important;
            }
            button:focus{
                outline: initial !important;
                outline-offset: initial !important;
                -webkit-focus-ring-color:initial !important;
                -webkit-box-shadow: initial !important;
            }
            button:active:focus{
                outline: initial !important;
                outline-offset: initial !important;
                -webkit-focus-ring-color:initial !important;
                -webkit-box-shadow: initial !important;
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box box box-info" style="width: 75%;">
            <div class="login-logo"><a href="#"><b>Admin | Kayıt Ol</b></a></div>
            <div class="login-box-body">
                <?php
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
                        $user_password= md5(trim($_POST["user_password"]));
                        $response=$_POST["g-recaptcha-response"];  // Yanıt 
                        $secret="6LenqvMZAAAAAG8Nr6OHdW9oEU8gBu28cdkpsGxR"; // Gizli Anahtar KOdu
                        $remoteip=$_SERVER["REMOTE_ADDR"]; // Kullanıcının İp Adresini Alma
                        $captcha=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip"); 
                        // yukarıdaki değişkenleri file get methodu ile gönderiyoruz
                        $result=json_decode($captcha); // Gönderdiğimiz dosya json değerler olduğu için json decode işlemi yapıyoruz ve değişkene aktarıyoruz 
                        if($result->success==1){ 
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
                                                    $profile_file_name=$query["user_name"]."_".uniqid(True); // resime ekstra karakterler ekleyecek
                                                    $photo_new_adress="uploads/user_profile_photos/".$profile_file_name.".".$profile_photo_extension;
                                                    if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"],$photo_new_adress)){
                                                        $new_adress=$profile_file_name.".".$profile_photo_extension;
                                                    }else{
														message("warning","warning","Dikkat!","Profil fotoğrafı yüklenemedi.");
                                                    }
                                                }else{
													message("warning","warning","Dikkat!","Lütfen belirtilen uzantılara ( png, jpeg, jpg ) uygun fotoğraf ekleyiniz.");
                                                }
                                            }else{
                                                if($user_gender==0){
                                                    $new_adress="Mr_profile_photo.png";
                                                }else{
                                                    $new_adress="Mrs_profile_photo.png";
                                                }
                                            }
                                            if($user_password==md5(trim($_POST["user_password2"]))){
                                                $query=mysqli_query($con,"INSERT INTO users SET user_name_surname='$user_name_surname', user_name='$user_name', user_birthday='$user_birthday', user_email='$user_email',                                                               user_phone_number='$user_phone_number', user_web_site='$user_web_site', user_facebook='$user_facebook', user_instagram='$user_instagram',                                                       user_twitter='$user_twitter', user_linkedin='$user_linkedin', user_pinterest='$user_pinterest', user_gender='$user_gender',                                                                     user_password='$user_password', user_profile_photo='$new_adress', user_authority='$user_authority', user_status=2, user_active_status='çevrimdışı'");
                                                if($query == 1){
													message("success","check","Başarılı","Sevgili $user_name_surname kaydınız başarılı bir şekilde oluşturulmuştur. Lütfen sistem yöneticileri tarafından kaydınızı onaylamalarını bekleyiniz");
                                                    header("Refresh:3; url = http://localhost/admin", true, 303);
                                                }else{
													message("warning","warning","Dikkat!","Kaydınız oluşturulamamıştır.");
                                                }
                                            }else{
												message("warning","warning","Dikkat!","Girdiğiniz şifreler uyuşmuyor.");
                                            }
                                        }else{
											message("warning","warning","Dikkat!","$user_email e-posta adresini kullanan başka bir üyemiz mevcut. Lütfen başka bir e-posta ile deneyiniz veya <a href='http://localhost/admin/index.php?giris=$user_email'><button type='submit' class='btn btn-info'>Giriş yap</button></a> butona tıklayarak giriş yapınız.");
                                        }
                                    }else{
										message("warning","warning","Dikkat!","$user_name kullanıcı adını kullanan başka bir üyemiz mevcut. Lütfen başka bir kullanıcı adı ile deneyiniz veya <a href='http://localhost/admin/index.php?giris=$user_name'><button type='submit' class='btn btn-info'>Giriş yap</button></a> butona tıklayarak giriş yapınız.");
									}
                                }else{
									message("warning","warning","Dikkat!","Lütfen cinsiyetinizi ve almak istediğiniz yetkiyi seçiniz");
                                }
                            }else{
								message("warning","warning","Dikkat!","Lütfen kullanıcı adında türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız");
                            }
                        }else{
							message("danger","ban","Başarısız!","Lütfen güvenligi dogrulayınız.");
                        }
                    }
                ?>
                <div><i style="color: #f00; font-weight: 15px;">*</i> Zorunlu olarak doldurulmalıdır.</div>
				<a type="button" class="btn btn-danger pull-right" href="http://localhost/admin"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
                <form role="form" name="registration" id="registration" method="post" enctype="multipart/form-data"  action="<?php $_SERVER["PHP_SELF"];?>">
                    <div class="box-body">
                        <div class="form-group col-md-6">
                            <label>Adınız<i style="color:#f00;">*</i></label>
                            <input type="text" class="form-control" name="user_Name" value="<?php if($_POST){ echo $user_Name; } ?>" placeholder="Adınız..." required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Soyadınız<i style="color:#f00;">*</i></label>
                            <input type="text" class="form-control" name="user_Surname" value="<?php if($_POST){ echo $user_Surname; } ?>" placeholder="Soyadınız..." required>
                        </div>
                        <div class="form-group col-md-6 <?php if($_POST){ if(($query_user_name == 1 and isset($query_user_name)) or $turkish){ echo'has-warning'; }} ?>">
                            <label>Kullanıcı adınız<i style="color:#f00;">*</i></label>
                            <span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen türkçe karakterler ( ğ, Ğ, ç, Ç, ş, Ş, ü, Ü, ö, Ö, ı, İ ) kullanmayınız.</span>
                            <input type="text" class="form-control" name="user_name" id="inputWarning" value="<?php if($_POST){ echo $user_name; } ?>" placeholder="Kullanıcı adınız..." required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doğum tarihiniz<i style="color:#f00;">*</i></label>
                            <input type="date" class="form-control" name="user_birthday"  value="<?php if($_POST){ echo $user_birthday; } ?>" placeholder="Doğum tarihiniz..." required>
                        </div>
                        <div class="form-group col-md-6 <?php if($_POST){ if($query_user_email == 1 and isset($query_user_email)){ echo'has-warning'; }} ?>">
                            <label>E-Posta adresiniz<i style="color:#f00;">*</i></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="inputWarning" name="user_email" value="<?php if($_POST){ echo $user_email; } ?>" placeholder="E-Posta adresiniz..." required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefon numaranız<i style="color:#f00;">*</i></label>
                            <span style="color: #ffa500; font-size: 12px; float: right;"><i class="fa fa-bell"></i> Lütfen numaranızı (123 456 78 90) şeklinde başında 0 olmadan giriniz.</span>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" name="user_phone_number" data-inputmask='"mask": "999 999 99 99"' data-mask pattern="[1-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" value="<?php if($_POST){ echo $user_phone_number; } ?>" placeholder="Telefon numaranız..." required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Web sitesi adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <input type="url" class="form-control" name="user_web_site" value="<?php if($_POST){ echo $user_web_site; } ?>" placeholder="Web sitesi adresiniz...">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Facebook adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                <input type="url" class="form-control" name="user_facebook" value="<?php if($_POST){ echo $user_facebook; } ?>" placeholder="Facebook adresiniz...">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>İnstagram adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                <input type="url" class="form-control" name="user_instagram" value="<?php if($_POST){ echo $user_instagram; } ?>" placeholder="İnstagram adresiniz...">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Twitter adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                <input type="url" class="form-control" name="user_twitter" value="<?php if($_POST){ echo $user_twitter; } ?>" placeholder="Twitter adresiniz...">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Linkedin adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                <input type="url" class="form-control" name="user_linkedin" value="<?php if($_POST){ echo $user_linkedin; } ?>" placeholder="Linkedin adresiniz...">
                            </div>
                        </div><div class="form-group col-md-6">
                            <label>Pinterest adresiniz</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
                                <input type="url" class="form-control" name="user_pinterest" value="<?php if($_POST){ echo $user_pinterest; } ?>" placeholder="Pinterest adresiniz...">
                            </div>
                        </div>
                        <div class="form-group col-md-6 <?php if($_POST){ if($user_gender == "-1" and isset($user_gender)){ echo'has-warning'; }} ?>">
                            <label>Cinsiyetiniz<i style="color:#f00;">*</i></label>
                            <select name="user_gender" id="selectWarning" class="form-control">
                                <option value="-1" selected <?php if($_POST){ if($user_gender == "-1"){echo "selected"; }} ?>>Cinsiyetinizi seçiniz...</option>
                                <option value="0" <?php if($_POST){ if($user_gender == 0){echo "selected"; }} ?>>Bay</option>
                                <option value="1" <?php if($_POST){ if($user_gender == 1){echo "selected"; }} ?>>Bayan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 <?php if($_POST){ if($user_authority == "-1" and isset($user_authority)){ echo'has-warning'; }} ?>">
                            <label>Almak istediğiniz yetki<i style="color:#f00;">*</i></label>
                            <select name="user_authority" id="selectWarning" class="form-control">
                                <option value="-1" selected <?php if($_POST){ if($user_authority == "-1"){echo "selected"; }} ?>>Almak istediğiniz yetkiyi seçiniz...</option>
                                <option value="1" <?php if($_POST){ if($user_authority == 1){echo "selected"; }} ?>>Site yönetici</option>
                                <option value="2" <?php if($_POST){ if($user_authority == 2){echo "selected"; }} ?>>Editör</option>
                                <option value="3" <?php if($_POST){ if($user_authority == 3){echo "selected"; }} ?>>Yazar</option>
                            </select>
                        </div>
                         <div class="form-group col-md-6">
                            <label>Şifre<i style="color:#f00;">*</i></label>
                            <input type="password" class="form-control" name="user_password" placeholder="Şifre..." required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Şifre (Tekrar)<i style="color:#f00;">*</i></label>
                            <input type="password" class="form-control" name="user_password2" placeholder="Şifre (Tekrar)..." required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Profil fotoğrafı ekleyiniz</label><br />
                            <div class="btn btn-default btn-file">
                                <i class="fa  fa-file-photo-o"></i> Profil fotoğrafı
                                <input type="file" name="profile_photo">
                            </div>
                            <p class="help-block">Yalnızca png, jpg, jpeg yükleyiniz</p>
                        </div>
                        <div class="form-group col-md-6">
                            <div style="width:305px; height: 78px; <?php if($_POST){ if($result->success==0){ echo 'border:thin solid #f00;';}} ?>" class="g-recaptcha" data-sitekey="6LenqvMZAAAAAGMV-XadyqQ9jLi1ghwYZsN5LGiC"></div><!-- Onay Kutusu  -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer"><button type="submit" class="btn btn-info pull-right">Kayıt ol</button></div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- InputMask -->
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <script>
          $(function () {
            $('[data-mask]').inputmask()
          });
        </script>
    </body>
</html>
