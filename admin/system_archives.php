<?php
    if($S_query_users["user_authority"] < 2){
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
            $limit=20;
            $start_from = ($page-1) * $limit;
            if(isset($_POST)){
                if(@$_POST["search"] ==""){
                    $query = mysqli_query($con, "SELECT * FROM system_archives LIMIT $start_from, $limit");
                }else{
                    $search =$_POST["search"];
                    $field =$_POST["field"];
                    $query = mysqli_query($con, "SELECT * FROM system_archives WHERE $field LIKE '%$search%' LIMIT $start_from, $limit");
                }
            }
            $query_number = mysqli_affected_rows($con);
            $query_number_records = mysqli_num_rows(mysqli_query($con, "SELECT * FROM system_archives"));  //kayıt sayısı
            $total_pages = ceil($query_number_records / $limit);
            if($page==1){
                $baslangic=1;
                if($limit>$query_number_records){
                    $end=$query_number_records;
                }else{
                    $end=$limit;
                }
            }else{
                $baslangic=1;
                for($i=1; $i<$page; $i++){
                    $baslangic+=$limit;
                }
                if($page==$total_pages){
                    if($limit>=$query_number){
                        $end=$query_number_records;
                    }
                }else{
                    if($limit>$query_number_records){
                        $end=$query_number_records;
                    }else{
                        $end=$page*$limit;
                    }
                }
            }
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header"><h1>Sistem kayıtları</h1></section>
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header" style="height: 65px;">
                            <?php echo"<div style='margin-top:35px; font-size:15px;'>"."$baslangic - $end / $query_number_records"." gösteriliyor</div>"; ?>
                            <div class="box-tools" style="width: 525px;">
                                <form method="post">
                                    <select name="field" id="field" style="width: 200px; height: 45px;">
                                        <option value="made_transaction">Yapılan İşlem</option>
                                        <option value="do_transactions">Yapan Kişi</option>
                                        <option value="description">Açıklama</option>
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
                            <table class="table table-hover">
                                <tr>
                                    <th>Kayıt id</th>
                                    <th>Açıklama</th>
                                    <th>Yapılan İşlem</th>
                                    <th>Yapan Kişi</th>
                                    <th>Yapılan zaman</th>
                                </tr>
                                <?php while($query_archives = mysqli_fetch_array($query)){ ?>
                                        <tr>
                                            <td><?php echo $query_archives["id"]; ?></td>
                                            <td><?php echo $query_archives["description"]; ?></td>
                                            <td>
                                                <?php 
                                                    if($query_archives["made_transaction"]=="Üye Eklendi"){
                                                        echo"<span class='label label-success'>Üye Eklendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Üye Silindi"){
                                                        echo"<span class='label label-danger'>Üye Silindi</span>";
                                                    }else if($query_archives["made_transaction"]=="Site Ayarları Güncellendi"){
                                                        echo"<span class='label label-info'>Site Ayarları Güncellendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Üye Güncellendi"){
                                                        echo"<span class='label label-info'>Üye Güncellendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Slider Eklendi"){
                                                        echo"<span class='label label-success'>Slider Eklendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Slider Güncellendi"){
                                                        echo"<span class='label label-info'>Slider Güncellendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Slider Silindi"){
                                                        echo"<span class='label label-danger'>Slider Silindi</span>";
                                                    }else if($query_archives["made_transaction"]=="Kategori Eklendi"){
                                                        echo"<span class='label label-success'>Kategori Eklendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Kategori Silindi"){
                                                        echo"<span class='label label-danger'>Kategori Silindi</span>";
                                                    }else if($query_archives["made_transaction"]=="Kategori Güncellendi"){
                                                        echo"<span class='label label-info'>Kategori Güncellendi</span>";
                                                    }else if($query_archives["made_transaction"]=="Ürün Eklendi"){
                                                        echo"<span class='label label-success'>Ürün Eklendi</span>";
                                                    } 
                                                ?>
                                            </td>
                                            <td><?php echo $query_archives["do_transactions"]; ?></td>
                                            <td><?php echo $query_archives["transaction_date"]; ?></td>
                                        </tr>
                                <?php } ?>
                            </table>
                            <div class="btn-group" style="margin: 5px 40%;">
                                <?php   if($page==1){
                                            echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=system_archives&page=1"><i class="fa fa-fast-backward"></i></a>';
                                        }else{
                                            echo'<a type="button" class="btn btn-info" href="administrator.php?do=system_archives&page=1"><i class="fa fa-fast-backward"></i></a>';
                                        }
                                        for ($i=1; $i<=$total_pages; $i++){
                                            echo'<a type="button" class="btn btn-info" href="administrator.php?do=system_archives&page='.$i.'">'.$i.'</a>';
                                        }
                                        if($page==$total_pages){
                                            echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=system_archives&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
                                        }else{
                                            echo'<a type="button" class="btn btn-info" href="administrator.php?do=system_archives&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
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
			message("danger","ban","Dikkat!","Buraya girmeye yetkiniz yoktur. Lütfen bekleyiniz ana sayfaya yönlendirliyorsunuz...");
			header("Refresh:3; url = http://localhost/admin/administrator.php", true, 303);
    	}
?>