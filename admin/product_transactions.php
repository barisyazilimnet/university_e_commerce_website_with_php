<?php
if($S_query_users["user_authority"] < 2){
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
    $limit=20;
    $start_from = ($page-1) * $limit; 
    if(isset($_POST)){
        if(@$_POST["search"] ==""){
			$query = mysqli_query($con, "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.category_id LIMIT $start_from, $limit");
        }else{
            $search =$_POST["search"];
            $field =$_POST["field"];
			$query = mysqli_query($con, "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.category_id WHERE $field LIKE '%$search%' LIMIT $start_from, $limit");
        }
    }
    $query_product_number = mysqli_num_rows($query);
	$query_number_records =  mysqli_num_rows(mysqli_query($con, "SELECT * FROM products"));
    $total_pages = ceil(($query_number_records-1) / $limit);
    if($page==1){
        $baslangic=1;
        if($limit>($query_number_records-1)){
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
            if($limit>=($query_product_number-1)){
                $end=$query_number_records;
            }
        }else{
            if($limit>($query_number_records-1)){
                $end=$query_number_records;
            }else{
                $end=$page*$limit;
            }
        }
    }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header"><h1>Ürün İşlemleri</h1></section>
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
                                <th>İd</th>
                                <th>Kategori adı</th>
                                <th>Adı</th>
                                <th>Fotograf</th>
                                <th>Stok bilgisi</th>
                                <th>Fiyatı</th>
                                <th>İşlemler</th>
                            </tr>
                            <tr>
                                <?php 
                                    while($query_products = mysqli_fetch_array($query)){
                                            ?>
                                            <tr>
                                                <td><?php echo $query_products["id"]; ?></td>
                                                <td><?php echo $query_products["category_name"]; ?></td>
                                                <td><?php echo $query_products["name"]; ?></td>
                                                <td><?php echo $query_products["photo"]; ?></td>
                                                <td><?php echo $query_products["stock_information"]; ?></td>
                                                <td><?php echo $query_products["price"]; ?></td>
												<td>
													<div class="btn-group dropdown" style="margin-right: 50px;">
                                                        <button type="button" class="btn btn-info">İşlemler</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="administrator.php?do=product_edit&id=<?php echo $query_products["id"]; ?>"><i class="fa fa-pencil"> Düzenle</i></a></li>
                                                            <li><a onclick="return del();" href="administrator.php?do=user_delete&user_id=<?php echo $query_users['user_id']; ?>&user_name=<?php echo $query_users['user_name']; ?>&user_authority=<?php echo $query_users['user_authority']; ?>"><i class="fa fa-trash-o"> Sil</i></a></li>
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
