<div class="col-md-10">
  <div class="box box-info">
    <?php 
        $mailid=$_GET["mail_id"];
        $page=$_GET["page"];
        if($page=="inbox"){
            $query=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM mails WHERE mail_id='$mailid' AND mail_receiver='$S_user_name'"));
            $query_read=mysqli_query($con, "UPDATE mails SET reading='Okundu' WHERE mail_id='$mailid' AND mail_receiver='$S_user_name'");
        }else if($page=="sent_box"){
            $query=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM mails WHERE mail_id='$mailid' AND mail_sender='$S_user_name'"));
        }
    ?>
    <div class="box-body no-padding">
      <div class="mailbox-read-info">
        <h3><?php echo $query["mail_subject"]; ?></h3><h5>Gönderen: <?php echo $query["mail_sender"]; ?><span class="mailbox-read-time pull-right"><?php echo $query["mail_date"]; ?></span></h5>
      </div>
      <!-- /.mailbox-read-info -->
      <div class="mailbox-read-message">
        <?php echo $query["mail_content"]; ?>
      </div>
      <!-- /.mailbox-read-message -->
    </div>
    <!-- /.box-body -->
   <div class="box-footer">
      <div class="pull-right">
        <button type="button" class="btn btn-default"><a style="color: initial;" href="administrator.php?do=mail_inbox&mail=mail_compose&id=<?php echo $mailid; ?>&button=answer"><i class="fa fa-reply"></i> Cevapla</a></button>
        <button type="button" class="btn btn-default"><a style="color: initial;" href="administrator.php?do=mail_inbox&mail=mail_compose&id=<?php echo $mailid; ?>&button=forward"><i class="fa fa-share"></i> İlet</a></button>
      </div>
    </div>
    <!-- /.box-footer -->
  </div>
  <!-- /. box -->
</div>
<!-- /.col -->