<!DOCTYPE html>
<?php
    require_once "../system/settings.php";
    require_once "../system/system.php";
	if(@$_SESSION["user_name"] != ""){
		header("location: administrator.php");
    }
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
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
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
        <div class="login-box box box-info">
            <div class="login-logo"><a href="#"><b>Admin</b></a></div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <?php
                    @$giris=$_GET["giris"];
                    if($_POST){
                        $user_name_email=trim($_POST["user_name_email"]);
                        $user_password =md5(trim($_POST["user_password"]));
                        $response=$_POST["g-recaptcha-response"];  // Yanıt 
                        $secret="6LenqvMZAAAAAG8Nr6OHdW9oEU8gBu28cdkpsGxR"; // Gizli Anahtar KOdu
                        $remoteip=$_SERVER["REMOTE_ADDR"]; // Kullanıcının İp Adresini Alma
                        $captcha=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip"); 
                        // yukarıdaki değişkenleri file get methodu ile gönderiyoruz
                        $result=json_decode($captcha); // Gönderdiğimiz dosya json değerler olduğu için json decode işlemi yapıyoruz ve değişkene aktarıyoruz 
                        if($result->success==1){ 
                            // json decode işleminden sonra succes değeri eğer 1 ise yani true işlem başarılı mesajı veriyoruz eğer değeri 0 ise yani false ise hata mesjaı veriyoruz
                            $query_user=mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE (user_name='$user_name_email' OR user_email='$user_name_email') AND user_password='$user_password'"));
                            if($query_user == 1){
                                $query = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE (user_name='$user_name_email' OR user_email='$user_name_email') AND user_password='$user_password'"));
                                if($query["user_status"] == 1){
                                    $_SESSION["user_id"] = $query["user_id"];
                                    $_SESSION["user_name"] = $query["user_name"];
                                    $_SESSION["user_authority"] = $query["user_authority"];
                                    $id=$query["user_id"];
                                    $user_update=mysqli_query($con,"UPDATE users SET user_active_status='çevrimiçi' WHERE user_id='$id'");
									message("success","check","Başarılı","Kullanıcı giriş başarıyla gerçekleşti. Lütfen bekleyiniz yönlendiriliyorsunuz...");                                    
                                    $_SESSION["login_time"] = time();
                                    header("Refresh:1; url = http://localhost/admin/administrator.php", true, 303);
                                }else{
									message("warning","warning","Dikkat!","Site yönetici tarafından hesabınız onaylanmamıştır. Lütfen hesabınızın onaylanmasını bekleyiniz.");                                    
                                } 
                            }else{
								message("danger","ban","Başarısız!!!","Kullanıcı adı veya şifreniz hatalı...");                                    
                            }
                        }else{
							message("danger","ban","Başarısız!!!","Lütfen güvenligi dogrulayınız.");                                    
                        }
                    }
                ?>
                <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
                    <div class="form-group has-feedback <?php if($_POST){ if($query_user==0){ echo 'has-error';}} ?> ">
                        <input type="text" class="form-control" id="inputError" name="user_name_email" value="<?php echo $giris; ?>" placeholder="Kullanıcı Adınız veya E-Posta adresiniz..." required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback <?php if($_POST){ if($query_user==0){ echo 'has-error';}} ?> ">
                        <input type="password" class="form-control" id="inputError" name="user_password" placeholder="Şifreniz..." required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div style="margin-bottom: 10px; margin-left: 8px; width:305px; height: 78px; <?php if($_POST){ if($result->success==0){ echo 'border:thin solid #f00;';}} ?>" class="g-recaptcha" data-sitekey="6LenqvMZAAAAAGMV-XadyqQ9jLi1ghwYZsN5LGiC"></div><!-- Onay Kutusu  -->
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label><input type="checkbox"> Beni Hatırla</label>
                            </div>
                            <!-- /.checkbox .icheck -->
                        </div>
                        <!-- /.col-xs-8 -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-info btn-block">Giriş yap</button>
                        </div>
                        <!-- /.col-xs-4 -->
                    </div>
                    <!-- /.row -->
                </form>
                <a href="#">Şifremi unuttum</a><br>
                <a href="register.php" class="text-center">Kayıt ol</a>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
