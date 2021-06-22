<!DOCTYPE html>
<?php
    require_once "../system/settings.php";
    require_once "../system/system.php";
    if($_SESSION["user_name"]==""){
        header("location: index.php");
    }else{
        if(isset($_SESSION["user_name"])){
            header("Refresh:5401",true);
            if(time() - $_SESSION["login_time"] > 5400){ //salise üzerinden 60 yazdıgın zaman 1 dk olur
                session_destroy();
                $user_update=mysqli_query($con,"UPDATE users SET user_active_status='' WHERE user_id='$S_user_id'");
                header("location: index.php");
            }
        }
        $S_user_name=$_SESSION["user_name"];
        $S_user_id=$_SESSION["user_id"];
        $S_query_users=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE user_id='$S_user_id'"));
        @$do = $_GET["do"];
        $query_not_reading=mysqli_num_rows(mysqli_query($con, "SELECT reading FROM mails WHERE reading='' AND mail_receiver='$S_user_name'"));
        $query_not_reading_limit=mysqli_query($con, "SELECT * FROM mails WHERE reading='' AND mail_receiver='$S_user_name' ORDER BY mail_id DESC LIMIT 3");
        $query_notifications=mysqli_query($con, "SELECT * FROM users WHERE user_status=2");
        $query_notifications_number=mysqli_num_rows($query_notifications);
		$hata=1;
        ?>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Admin Paneli | <?php echo $query_settings["site_title"]; ?></title>
                <link rel="shortcut icon" href="uploads/site_title_icon/<?php echo $query_settings['site_title_icon']; ?>" type="image/x-icon"> 
                <!-- Tell the browser to be responsive to screen width -->
                <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
                <!-- Font Awesome -->
                <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
                <!-- Ionicons -->
                <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
                <!-- Theme style -->
                <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
                <!-- AdminLTE Skins. We have chosen the skin-blue for this starter page. However, you can choose any other skin. 
                    Make sure you apply the skin class to the body tag so the changes take effect. -->
                <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
                <!-- bootstrap wysihtml5 - text editor -->
                <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                <!-- Select2 -->
                <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
                <!-- Google Font -->
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                <style>
                    .btn-display{
                        display: none;
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
				<script src="https://kit.fontawesome.com/03561be234.js" crossorigin="anonymous"></script>
            </head>
            <!--
            BODY TAG OPTIONS:
            =================
            Apply one or more of the following classes to get the
            desired effect
            |---------------------------------------------------------|
            | SKINS         | skin-blue                               |
            |               | skin-black                              |
            |               | skin-purple                             |
            |               | skin-yellow                             |
            |               | skin-red                                |
            |               | skin-green                              |
            |---------------------------------------------------------|
            |LAYOUT OPTIONS | fixed                                   |
            |               | layout-boxed                            |
            |               | layout-top-nav                          |
            |               | sidebar-collapse                        |
            |               | sidebar-mini                            |
            |---------------------------------------------------------|
            -->
            <body class="hold-transition skin-red sidebar-mini">
                <div class="wrapper">
                    <!--Main Header-->
                    <header class="main-header">
                        <!-- Logo -->
                        <a href="https://www.barisyazilim.net" class="logo">
                            <!-- mini logo for sidebar mini 50x50 pixels -->
                            <span class="logo-mini"><b>Barış</b></span>
                            <!-- logo for regular state and mobile devices -->
                            <span class="logo-lg"><b>Barış</b> Yazılım</span>
                        </a>
                        <!-- Header Navbar -->
                        <nav class="navbar navbar-static-top" role="navigation">
                            <!-- Sidebar toggle button-->
                            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle navigation</span></a>
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav">
                                    <!-- Messages: style can be found in dropdown.less-->
                                    <li class="dropdown messages-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><?php if($query_not_reading!=0){ echo'<span class="label label-success">New</span>'; } ?></a>
                                        <ul class="dropdown-menu">
                                            <?php if($query_not_reading!=0){ echo'<li class="header">'.$query_not_reading.' yeni mesajınız var</li>'; }else{ echo'<li class="header">Yeni mesajınız yok</li>'; } ?>
                                            <li>
                                                <!-- inner menu: contains the actual data -->
                                                <ul class="menu">
                                                    <?php 
                                                        while($query_not_reading_limit_1= mysqli_fetch_array($query_not_reading_limit)){
                                                            $photo_name=$query_not_reading_limit_1["mail_sender"];
                                                            $sender_photo=mysqli_fetch_array(mysqli_query($con,"SELECT user_profile_photo FROM users WHERE user_name='$photo_name'"));
                                                            ?>
                                                            <!-- start message -->
                                                            <li>
                                                                <a href="administrator.php?do=mail_inbox&mail=mail_read&mail_id=<?php echo $query_not_reading_limit_1['mail_id']; ?>&page=inbox">
                                                                    <div class="pull-left"><img src="uploads/user_profile_photos/<?php echo $sender_photo['user_profile_photo']; ?>" class="img-circle" alt="User Image"></div>
                                                                    <h4>
                                                                        <?php echo $query_not_reading_limit_1["mail_sender"]; ?>
                                                                        <small><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo $query_not_reading_limit_1['mail_date']; ?></small>
                                                                    </h4>
                                                                    <p><?php echo strip_tags(substr($query_not_reading_limit_1["mail_content"],0,30))."..."; ?></p>
                                                                </a>
                                                            </li>
                                                            <!-- end message -->
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <li class="footer"><a href="administrator.php?do=mail_inbox">Bütün mesajları göster</a></li>
                                        </ul>
                                    </li>
                                    <!-- Notifications: style can be found in dropdown.less -->
                                    <li class="dropdown messages-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bell-o"></i>
                                            <?php if($query_notifications_number!=0){ echo'<span class="label label-warning">'.$query_notifications_number.'</span>'; } ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php if($query_notifications_number!=0){ echo'<li class="header">'.$query_notifications_number.' yeni bildiriminiz var</li>'; }else{ echo'<li class="header">Yeni bildiriminiz yok</li>'; } ?>
                                            <li>
                                                <!-- inner menu: contains the actual data -->
                                                <ul class="menu">
                                                    <?php while($query_notifications_array= mysqli_fetch_array($query_notifications)){ ?>
                                                        <!-- start notifications -->
                                                        <li>
                                                            <a href="administrator.php?do=user_edit&user_id=<?php echo $query_notifications_array['user_id']; ?>">
                                                                <div class="pull-left"><img src="uploads/user_profile_photos/<?php echo $query_notifications_array['user_profile_photo']; ?>" class="img-circle" alt="User Image"></div>
                                                                <h4>
                                                                    <?php echo $query_notifications_array["user_name"]; ?>
                                                                    <small><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo $query_notifications_array['user_registration_date']; ?></small>
                                                                </h4>
                                                                <p>Onaylanmayı bekleyen yeni üye<br />Üyeyi onaylamak için veya silmek için tıkla</p>
                                                            </a>
                                                        </li>
                                                        <!-- end notifications -->
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- User Account: style can be found in dropdown.less -->
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="uploads/user_profile_photos/<?php echo $S_query_users['user_profile_photo']; ?>" class="user-image" alt="User Image">
                                            <span class="hidden-xs"><?php echo $S_query_users["user_name"]; ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- User image -->
                                            <li class="user-header">
                                                <img src="uploads/user_profile_photos/<?php echo $S_query_users['user_profile_photo']; ?>" class="img-circle" alt="User Image">
                                                <p><?php echo $S_query_users["user_name"]; ?><small><?php echo $S_query_users["user_registration_date"]; ?></small></p>
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer"><a href="administrator.php?do=profile" class="btn btn-default btn-flat">Profil</a></li>
                                        </ul>
                                    </li>
                                    <!-- Control Sidebar Toggle Button -->
                                    <li><a href="administrator.php?do=sign_out"><i class="glyphicon glyphicon-off"></i></a></li>
                                </ul>
                            </div>
                            <!--/.navbar-custom-menu -->
                        </nav>
                    </header>
                    <aside class="main-sidebar">
                        <!-- sidebar: style can be found in sidebar.less -->
                        <section class="sidebar">
                            <!-- Sidebar user panel (optional) -->
                            <div class="user-panel">
                                <div class="pull-left image">
                                    <img style="max-height: 60px !important; max-width: 60px" class="img-circle" src="uploads/user_profile_photos/<?php echo $S_query_users["user_profile_photo"]; ?>" alt="User Image">
                                </div>
                                <div class="pull-left info" style="margin-left: 5px !important;">
                                    <p><?php echo $S_query_users["user_name"]; ?></p>
                                    <!-- Status -->
                                    <a href="#"><i class="fa fa-circle text-success"></i> Çevrimiçi</a>
                                </div>
                                <!--/.pull-left .info -->
                            </div>
                            <!-- /.user-panel -->
                            <!-- Sidebar Menu -->
                            <ul class="sidebar-menu" data-widget="tree" style="margin-top: 25px;">
                                <li class="header"><b>İŞLEMLER</b></li>
                                <li class="<?php if($do==''){ echo 'active'; } ?>"><a href="administrator.php"><i class="fa fa-home"></i> <span>Anasayfa</span></a></li>
                                <li class="treeview <?php if($do=='mail_inbox'){ echo 'active'; } ?>">
                                    <a href="#">
                                        <i class="fa fa-envelope"></i> <span>E-Posta</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                            <?php 
                                                if($query_not_reading!=0){
                                                    echo'<small class="label pull-right bg-primary">'.$query_not_reading.'</small>';
                                                }
                                            ?>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="administrator.php?do=mail_inbox" style="margin-left: 10px;"><i class="glyphicon glyphicon-inbox"></i> Gelen kutusu
                                                <?php 
                                                    if($query_not_reading!=0){
                                                        echo'<span class="pull-right-container label label-primary">'.$query_not_reading.'</span>';
                                                    }
                                                ?>
                                            </a>
                                        </li>
                                        <li><a href="administrator.php?do=mail_inbox&mail=sent_box" style="margin-left: 10px;"><i class="glyphicon glyphicon-share"></i> Gönderilen</a></li>
                                       <li><a href="administrator.php?do=mail_inbox&mail=mail_compose" style="margin-left: 10px;">Yeni E-Posta oluştur</a></li>
                                    </ul>
                                </li>
                                <?php if($_SESSION["user_authority"] < 2){ ?>
                                        <li class="treeview <?php if($do=='admin_user_registration' or $do=='user_transactions' or $do=='user_edit' or $do=='user_delete'){ echo 'active'; } ?>">
                                            <a href="#"><i class="fa fa-users"></i> <span>Üyeler</span>
                                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li>
                                                    <a href="administrator.php?do=admin_user_registration" style="margin-left: 10px;"><i class="fa fa-user-plus"></i> Yeni üye ekle</a>
                                                </li>
                                                <li><a href="administrator.php?do=user_transactions" style="margin-left: 10px;"><i class="fa fa-cogs"></i> Üye İşlemleri</a></li>
                                            </ul>
                                            <!-- /.treeview-menu -->
                                        </li>
                                        <!-- /.treeview -->
								<?php } if($_SESSION["user_authority"] < 3){ ?>
										<li class="treeview <?php if($do=='slider_add' or $do=='slider_settings' or $do=='slider_edit' or $do=='slider_delete'){ echo 'active'; } ?>">
                                            <a href="#"><i class="fa fa-sliders"></i> <span>Slider</span>
                                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li>
                                                    <a href="administrator.php?do=slider_add" style="margin-left: 10px;"><i class="fa fa-plus"></i> Slider ekle</a>
                                                </li>
                                                <li><a href="administrator.php?do=slider_settings" style="margin-left: 10px;"><i class="fa fa-cogs"></i> Slider İşlemleri</a></li>
                                            </ul>
                                            <!-- /.treeview-menu -->
                                        </li>
                                        <!-- /.treeview -->
										<li class="treeview <?php if($do=='category_add' or $do=='category_settings' or $do=='category_edit' or $do=='category_delete'){ echo 'active'; } ?>">
                                            <a href="#"><i class="fa fa-list"></i> <span>Kategoriler</span>
                                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li>
                                                    <a href="administrator.php?do=category_add" style="margin-left: 10px;"><i class="fa fa-plus"></i> Kategori ekle</a>
                                                </li>
                                                <li><a href="administrator.php?do=category_settings" style="margin-left: 10px;"><i class="fa fa-cogs"></i> Kategori İşlemleri</a></li>
                                            </ul>
                                            <!-- /.treeview-menu -->
                                        </li>
                                        <!-- /.treeview -->
								<?php } ?>
								<li class="treeview <?php if($do=='product_add' or $do=='product_transactions' or $do=='product_edit' or $do=='product_delete'){ echo 'active'; } ?>">
									<a href="#"><i class="fab fa-product-hunt"></i>&nbsp;&nbsp;&nbsp;<span>Ürünler</span>
										<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
									</a>
									<ul class="treeview-menu">
										<li>
											<a href="administrator.php?do=product_add" style="margin-left: 10px;"><i class="fa fa-plus"></i> Ürün ekle</a>
										</li>
										<li><a href="administrator.php?do=product_transactions" style="margin-left: 10px;"><i class="fa fa-cogs"></i> Ürün İşlemleri</a></li>
									</ul>
									<!-- /.treeview-menu -->
								</li>
								<!-- /.treeview -->
								<?php if($_SESSION["user_authority"] < 2){ ?>
                                        <li class="<?php if($do=='system_archives'){ echo 'active'; } ?>"><a href="administrator.php?do=system_archives"><i class="fa fa-archive"></i> <span>Sistem Kayıtları</span></a></li>
                                        <li class="<?php if($do=='site_settings'){ echo 'active'; } ?>"><a href="administrator.php?do=site_settings"><i class="fa fa-wrench"></i> <span>Site Ayarları</span></a></li>
                                <?php } ?>
                                <li class="treeview <?php if($do=='profile' or $do=='profile_password_update'){ echo 'active'; } ?>">
                                    <a href="#"><i class="fa fa-user"></i> <span>Profil</span>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="administrator.php?do=profile" style="margin-left: 10px;"><i class="glyphicon glyphicon-edit"></i> Bilgileri güncelle</a>
                                        </li>
                                        <li><a href="administrator.php?do=profile_password_update" style="margin-left: 10px;"><i class="fa fa-cogs"></i> Şifre güncelle</a></li>
                                    </ul>
                                    <!-- /.treeview-menu -->
                                </li>
                                <!-- /.treeview -->
                                <li class="<?php if($do=='sign_out'){ echo 'active'; } ?>"><a href="administrator.php?do=sign_out"><i class="fa fa-sign-out"></i> <span>Çıkış yap</span></a></li>
                            </ul>
                            <!-- /.sidebar-menu -->
                        </section>
                    </aside>

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Main content -->
                        <section class="content container-fluid">
                            <?php
                                if(file_exists("{$do}.php")){ //bu sayfa varmı?
                                    require("{$do}.php"); //sayfayı getir
                                }else{
                                    require("home_page.php");
                                }
                            ?>
                        </section>
                    </div>
                    <!-- /.content-wrapper -->
                    <!-- Main Footer -->
                    <footer class="main-footer">
                        <div class="pull-right">Tüm hakları saklıdır.</div>
                        <!-- Default to the left -->
                        <strong>Copyright &copy; 2020 <a href="https://www.barisyazilim.net">Baris Yazılım</a></strong>
                    </footer>
                </div>
                <!-- ./wrapper -->
                <!-- REQUIRED JS SCRIPTS -->
                <!-- jQuery 3 -->
                <script src="bower_components/jquery/dist/jquery.min.js"></script>
                <!-- Bootstrap 3.3.7 -->
                <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                <!-- AdminLTE App -->
                <script src="dist/js/adminlte.min.js"></script>
                <!-- Bootstrap WYSIHTML5 -->
                <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
                <!-- InputMask -->
                <script src="plugins/input-mask/jquery.inputmask.js"></script>
                <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
                <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
                <!-- Select2 -->
                <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
                <script type="text/javascript">
					$(".alert").delay(5000).slideUp(500, function() { //slideup hızı-- delay süresi
						$(this).alert('close');
					});
                    function del(){
                        var agree=confirm("Bu içeriği silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
                        if(agree){ 
                            return true; 
                        } else{ 
                            return false;
                        } 
                    }
                    // Page Script
                    $(function () {
                        //Add text editor
                        $("#compose-textarea").wysihtml5();
                      });
                  $(function () {
                        $('[data-mask]').inputmask()
                      });
                    $('.select2').select2()
                </script>
            </body>
        </html>
<?php } ?>