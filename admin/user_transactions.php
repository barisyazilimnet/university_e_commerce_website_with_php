<?php
if($S_query_users["user_authority"] < 2){
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
    $limit=20;
    $start_from = ($page-1) * $limit; 
    if(isset($_POST)){
        if(@$_POST["search"] ==""){
            if($S_query_users["user_authority"]==0){
                $query = mysqli_query($con, "SELECT * FROM users LIMIT $start_from, $limit");
            }else{
                $query = mysqli_query($con, "SELECT * FROM users WHERE user_authority >0 LIMIT $start_from, $limit");
            }
        }else{
            $search =$_POST["search"];
            $field =$_POST["field"];
            if($S_query_users["user_authority"]==0){
                $query = mysqli_query($con, "SELECT * FROM users WHERE $field LIKE '%$search%' LIMIT $start_from, $limit");
            }else{
                $query = mysqli_query($con, "SELECT * FROM users WHERE user_authority >0 AND $field LIKE '%$search%' LIMIT $start_from, $limit");
            }
        }
    }
    $query_user_number = mysqli_num_rows($query);
    if($S_query_users["user_authority"]==0){
        $query_number_records =  mysqli_num_rows(mysqli_query($con, "SELECT * FROM users"));
    }else{
        $query_number_records = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE user_authority >0"));
    }
    $total_pages = ceil(($query_number_records-1) / $limit);
    if($page==1){
        $baslangic=1;
        if($limit>($query_number_records-1)){
            $end=($query_number_records-1);
        }else{
            $end=$limit;
        }
    }else{
        $baslangic=1;
        for($i=1; $i<$page; $i++){
            $baslangic+=$limit;
        }
        if($page==$total_pages){
            if($limit>=($query_user_number-1)){
                $end=($query_number_records-1);
            }
        }else{
            if($limit>($query_number_records-1)){
                $end=($query_number_records-1);
            }else{
                $end=$page*$limit;
            }
        }
    }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header"><h1>Üye İşlemleri</h1></section>
    <!-- Main content -->
    <section class="content container-fluid">
        <style>
            th, td{
                text-align: center;
            }
        </style>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">   
                    <div class="box-header" style="height: 65px;">
                        <?php echo"<div style='margin-top:35px; font-size:15px;'>".$baslangic." - ".$end." / ".($query_number_records-1)." gösteriliyor</div>"; ?>
                        <div class="box-tools" style="width: 525px;">
                            <form method="post">
                                <select name="field" id="field" style="width: 200px; height: 45px;">
                                    <option value="user_name">Kullanıcı adı</option>
                                    <option value="user_email">E-Posta</option>
                                    <option value="user_name_surname">Adı Soyadı</option>
                                    <option value="user_phone_number">Telefon numarası</option>
                                </select>
                                <div class="input-group input-group-md" style="width: 300px; float: right;" >
                                    <input type="text" name="search" class="form-control pull-right" style="height: 45px !important;" placeholder="Ara..." >
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-info btn-flat" 
                                                style="height: 45px !important; width: 50px !important; -webkit-border-bottom-right-radius:5px !important; 
                                                       -moz-border-bottom-right-radius:5px !important; -o-border-bottom-right-radius:5px !important; -ms-border-bottom-right-radius:5px !important; border-bottom-right-radius:5px !important ; -webkit-border-top-right-radius:5px !important; -moz-border-top-right-radius:5px !important; -o-border-top-right-radius:5px !important; -ms-border-top-right-radius:5px !important; border-top-right-radius:5px !important;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <!--/.input-group-btn -->
                                </div>
                                <!--/.input-group .input-group-md -->
                            </form> 
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table  table-hover" style="margin-bottom: 20px !important;">
                            <tr>
                                <th>Sıra no</th>
                                <th>Üye çevrimiçi <br />durumu</th>
                                <th>Üye id</th>
                                <th>Üye <br>fotoğraf</th>
                                <th>Üye adı soyadı</th>
                                <th>Kullanıcı Adı</th>
                                <th>Üye e-posta</th>
                                <th>Üye telefon numarası</th>
                                <th>Üye web site ve <br>sosyal medya hesapları</th>
                                <th>Üye doğum <br>tarihi</th>
                                <th>Üye <br>cinsiyet</th>
                                <th>Üye <br>durum</th>
                                <th>Üye yetki</th>
                                <th>Üye kayıt zamanı</th>
                                <th>İşlemler</th>
                            </tr>
                            <tr>
                                <?php 
                                    while($query_users = mysqli_fetch_array($query)){
                                        if($query_users["user_id"]!=$S_user_id){
                                            @$i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php if($query_users["user_active_status"]=="çevrimiçi"){ echo '<i class="fa fa-circle text-success"></i> Çevrimiçi'; }else{ echo '<i class="fa fa-circle text-danger"></i> Çevrimdışı'; } ?></td>
                                                <td><?php echo $query_users["user_id"]; ?></td>
                                                <td><img class="profile-user-img img-circle" style="max-width: initial; width: 40px; height: 40px;" src="uploads/user_profile_photos/<?php echo $query_users['user_profile_photo']; ?>"></td>
                                                <td><?php echo $query_users["user_name_surname"]; ?></td>
                                                <td><?php echo $query_users["user_name"]; ?></td>
                                                <td><?php echo $query_users["user_email"]; ?></td>
                                                <td><?php echo $query_users["user_phone_number"]; ?></td>
                                                <td>
                                                    <a target="_blank" href="<?php echo $query_users['user_web_site']; ?>" <?php if(empty($query_users["user_web_site"])){ echo"hidden"; } ?>><i class="fa fa-globe"></i></a>&nbsp;
                                                    <a target="_blank" href="<?php echo $query_users['user_facebook']; ?>" <?php if(empty($query_users["user_facebook"])){ echo"hidden"; } ?>><i class="fa fa-facebook"></i></a>&nbsp;
                                                    <a target="_blank" href="<?php echo $query_users['user_instagram']; ?>" <?php if(empty($query_users["user_instagram"])){ echo"hidden"; } ?>><i class="fa fa-instagram"></i></a>&nbsp;
                                                    <a target="_blank" href="<?php echo $query_users['user_twitter']; ?>" <?php if(empty($query_users["user_twitter"])){ echo"hidden"; } ?>><i class="fa fa-twitter"></i></a>&nbsp;
                                                    <a target="_blank" href="<?php echo $query_users['user_linkedin']; ?>" <?php if(empty($query_users["user_linkedin"])){ echo"hidden"; } ?>><i class="fa fa-linkedin"></i></a>&nbsp;
                                                    <a target="_blank" href="<?php echo $query_users['user_pinterest']; ?>" <?php if(empty($query_users["user_pinterest"])){ echo"hidden"; } ?>><i class="fa fa-pinterest"></i></a>
                                                </td>
                                                <td><?php if($query_users["user_birthday"]=="0000-00-00"){ }else{ echo date_format(date_create($query_users["user_birthday"]),'d.m.Y'); } ?></td>
                                                <td>
                                                    <?php 
                                                        if($query_users["user_gender"] == 0){
                                                            echo"<span class='label label-info'>Bay</span";
                                                        }else{
                                                            echo"<span class='label label-danger'>Bayan</span";
                                                        }
                                                    ?>
                                                </td><td>
                                                    <?php 
                                                        if($query_users["user_status"] == 1){
                                                            echo"<span class='label label-success'>Onaylı</span";
                                                        }else{
                                                            echo"<span class='label label-danger'>Onaylı değil</span";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if($query_users["user_authority"] == 0){
                                                            echo"<span class='label label-info'>Kurucu</span>";
                                                        }else if($query_users["user_authority"] == 1){
                                                            echo"<span class='label label-primary'>Site yöneticisi</span>";
                                                        }else if($query_users["user_authority"] == 2){
                                                            echo"<span class='label label-success'>Editör</span>";
                                                        }else if($query_users["user_authority"] == 3){
                                                            echo"<span class='label label-danger'>Yazar</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $query_users["user_registration_date"]; ?></td>
                                                <td>
                                                    <div class="btn-group dropdown" style="margin-right: 50px;">
                                                        <button type="button" class="btn btn-info">İşlemler</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="administrator.php?do=user_edit&user_id=<?php echo $query_users["user_id"]; ?>"><i class="fa fa-pencil"> Düzenle</i></a></li>
                                                            <li><a onclick="return del();" href="administrator.php?do=user_delete&user_id=<?php echo $query_users['user_id']; ?>&user_name=<?php echo $query_users['user_name']; ?>&user_authority=<?php echo $query_users['user_authority']; ?>"><i class="fa fa-trash-o"> Sil</i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php } } ?>
                            </tr>
                        </table>
                        <div class="btn-group" style="margin: 5px 42%">
                            <?php   
                                if($page==1){
                                    echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=user_transactions&page=1"><i class="fa fa-fast-backward"></i></a>';
                                }else{
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=user_transactions&page=1"><i class="fa fa-fast-backward"></i></a>';
                                }
                                for ($i=1; $i<=$total_pages; $i++){
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=user_transactions&page='.$i.'" >'.$i.'</a>';
                                }
                                if($page==$total_pages){
                                    echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=user_transactions&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
                                }else{
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=user_transactions&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
                                }
                            ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
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
