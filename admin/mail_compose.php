<div class="col-md-10">
	<?php
    @$button=$_GET["button"];
    @$id=$_GET["id"];
    $forward_answer_query=mysqli_fetch_array(mysqli_query($con, "SELECT * FROM mails WHERE mail_id='$id'"));
    if($_POST){
        $mail_receiver=$_POST["mail_receiver"];
        $mail_subject=$_POST["mail_subject"];
        $mail_content=$_POST["mail_content"];
		if($mail_content){
			$query_submit=mysqli_query($con, "INSERT INTO mails SET mail_sender='$S_user_name', mail_receiver='$mail_receiver', mail_subject='$mail_subject', mail_content='$mail_content'");
			if($query_submit){
				message("success","check","Başarılı","Mailiniz başarılı bir şekilde gönderilmiştir.");
				header("Refresh:2; url = http://localhost/admin/administrator.php?do=mail_inbox", true, 303);
			}else{
				message("warning","warning","Dikkat!","Mailiniz gönderilememiştir. Lütfen tekrar deneyiniz.");
			}
		}else{
			message("warning","warning","Dikkat!","Mesajın içerik bölümünü boş bırakılamaz");
		}
      }
  ?>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Yeni E-Posta oluştur</h3><a type="button" class="btn btn-danger pull-right" href="administrator.php?do=mail_inbox"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;Vazgeç</a>
    </div>
    <form method="post">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
              <?php $query=mysqli_query($con, "SELECT * FROM users"); ?> 
              <select name="mail_receiver" class="select2 form-control " style="width: 100%;">
                  <?php 
                        while($query_1=mysqli_fetch_array($query)){
                            if($query_1['user_name']!=$S_query_users["user_name"]){
                                ?>
                                <option value="<?php echo $query_1['user_name']; ?>" <?php if($button=="answer"){ if($forward_answer_query["mail_sender"]==$query_1["user_name"]){ echo"selected"; }} ?>><?php echo $query_1["user_name"]."(".$query_1["user_email"].")"; ?></option>
                  <?php } } ?>
              </select>
          </div>
          <div class="form-group">
            <input  type="text" class="form-control" name="mail_subject" value="<?php if($_POST){ echo $mail_subject; }else if($button){ echo $forward_answer_query['mail_subject']; } ?>" placeholder="Konu:" required>
          </div>
          <div class="form-group">
                <textarea id="compose-textarea" class="form-control" name="mail_content" style="height: 300px">
                     <?php 
                        if($_POST){ echo $mail_content; } 
                        if($button){ echo $forward_answer_query['mail_content']; }  
                        if($button=='forward'){ 
                            echo '<br /><br /><br />
							<p>Gönderen :'.$forward_answer_query['mail_sender'].'</p>
							<p>Kime :'.$forward_answer_query['mail_receiver'].'</p>
							<p>Konu :'.$forward_answer_query['mail_subject'].'</p>
							<p>Gönderilen zaman :'.$forward_answer_query['mail_date'].'</p>'; 
                        } 
                     ?>
              </textarea>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"><div class="pull-right"><button type="submit" class="btn btn-info"><i class="fa fa-envelope-o"></i> Gönder</button></div></div>
    </form>
  </div>
  <!-- /. box -->
</div>
<!-- /.col -->