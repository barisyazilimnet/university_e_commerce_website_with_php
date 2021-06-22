<?php
if($S_query_users["user_authority"] < 3){
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
    $limit=20;
    $start_from = ($page-1) * $limit; 
	$query = mysqli_query($con, "SELECT * FROM categories LIMIT $start_from, $limit");
    $query_user_number = mysqli_num_rows($query);
    $query_number_records =  mysqli_num_rows(mysqli_query($con, "SELECT * FROM categories"));
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
            if($limit>=$query_user_number){
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
    <section class="content-header"><h1>Kategori İşlemleri</h1></section>
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
                        <?php echo"<div style='margin-top:35px; font-size:15px;'>".$baslangic." - ".$end." / ".$query_number_records." gösteriliyor</div>"; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table  table-hover" style="margin-bottom: 20px !important;">
                            <tr>
                                <th>İd</th>
                                <th>Sırası</th>
                                <th>İsim</th>
                                <th>Görünürlük</th>
                                <th>Ekleyen</th>
                                <th>Tarih</th>
                            </tr>
                            <tr>
                                <?php 
                                    while($query_categories = mysqli_fetch_array($query)){
                                            ?>
                                            <tr>
                                                <td><?php echo $query_categories["category_id"]; ?></td>
                                                <td><?php echo $query_categories["category_order"]; ?></td>
                                                <td><?php echo $query_categories["category_name"]; ?></td>
                                                <td>
													<?php 
														if($query_categories["category_visibility"]==0){
                                                            echo"<span class='label label-danger'>Pasif</span>";
														}else{
                                                            echo"<span class='label label-success'>Aktif</span>";
														} 
													?>
												</td>
                                                <td><?php echo $query_categories["adding"]; ?></td>
                                                <td><?php echo $query_categories["date"]; ?></td>
											<td>
												<div class="btn-group dropdown" style="margin-right: 50px;">
													<button type="button" class="btn btn-info">İşlemler</button>
													<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
														<span class="sr-only">Toggle Dropdown</span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li><a href="administrator.php?do=category_edit&category_id=<?php echo $query_categories["category_id"]; ?>"><i class="fa fa-pencil"> Düzenle</i></a></li>
														<li><a onclick="return del();" href="administrator.php?do=category_delete&category_id=<?php echo $query_categories["category_id"]; ?>"><i class="fa fa-trash-o"> Sil</i></a></li>
													</ul>
												</div>
											</td>
										</tr>
                                <?php } ?>
                            </tr>
                        </table>
                        <div class="btn-group" style="margin: 5px 42%">
                            <?php   
                                if($page==1){
                                    echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=category_settings&page=1"><i class="fa fa-fast-backward"></i></a>';
                                }else{
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=category_settings&page=1"><i class="fa fa-fast-backward"></i></a>';
                                }
                                for ($i=1; $i<=$total_pages; $i++){
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=category_settings&page='.$i.'" >'.$i.'</a>';
                                }
                                if($page==$total_pages){
                                    echo'<a type="button" class="btn btn-info btn-display" href="administrator.php?do=category_settings&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
                                }else{
                                    echo'<a type="button" class="btn btn-info" href="administrator.php?do=category_settings&page='.$total_pages.'"><i class="fa fa-fast-forward"></i></a>';
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
