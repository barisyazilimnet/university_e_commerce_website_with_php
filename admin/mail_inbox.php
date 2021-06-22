<?php 
    $query_receiver = mysqli_query($con, "SELECT * FROM mails WHERE mail_receiver='$S_user_name' ORDER BY mail_id DESC");
    $query_receiver_number=mysqli_affected_rows($con);
    $query_sender = mysqli_query($con, "SELECT * FROM mails WHERE mail_sender='$S_user_name' ORDER BY mail_id DESC"); 
    @$mail=$_GET["mail"];
?>
<!-- Content Header (Page header) -->
<section class="content-header"><h1>E-Posta</h1></section>
<!-- Main content -->
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-2">
            <a href="administrator.php?do=mail_inbox&mail=mail_compose" class="btn btn-info btn-block margin-bottom"><i class="fa fa-plus"></i>&nbsp;&nbsp;Oluştur</a>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Klasörler</h3>
                    <div class="box-tools"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?php if($mail==''){ echo 'active' ;} ?>"><a href="administrator.php?do=mail_inbox"><i class="fa fa-inbox"></i> Gelen kutusu 
                            <?php if($query_not_reading!=0){ ?> <span class="label label-primary pull-right"> <?php echo $query_not_reading; ?></span> <?php } ?></a></li>
                        <li class="<?php if($mail=='mail_sent_box'){ echo 'active' ;} ?>"><a href="administrator.php?do=mail_inbox&mail=mail_sent_box"><i class="fa fa-envelope-o"></i> Gönderilen</a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <?php 
            if(file_exists("{$mail}.php")){ //bu sayfa varmı?
                require("{$mail}.php"); //sayfayı getir
            }else{
        ?>
                <div class="col-md-10">
                    <div class="box box-info">
                        <div class="box-header with-border"><h3 class="box-title">Gelen Kutusu</h3></div>
                        <div class="box-body no-padding">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <?php while($query_mails= mysqli_fetch_array($query_receiver)){ ?>
                                                <tr>
                                                    <td class="mailbox-name"><a href="administrator.php?do=mail_inbox&mail=mail_read&mail_id=<?php echo $query_mails['mail_id']; ?>&page=inbox"><?php echo $query_mails["mail_sender"]; ?></a></td>
                                                    <td class="mailbox-subject">
														<a style="color: initial;" href="administrator.php?do=mail_inbox&mail=mail_read&mail_id=<?php echo $query_mails['mail_id']; ?>&page=inbox">
															<b><?php echo $query_mails["mail_subject"]; ?></b> - <?php echo strip_tags(substr($query_mails["mail_content"],0,100))."..."; ?>
														</a>
													</td>
                                                    <td><?php if($query_mails["reading"]==""){ echo "Okunmadı"; } ?></td>
                                                    <td class="mailbox-date"><?php echo $query_mails["mail_date"]; ?></td>
                                                </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
        <?php } ?>
    </div>
    <!-- /.row -->
</section>
<!-- /.content .container-fluid -->