<div class="col-md-10">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Gönderilmiş</h3></div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                    <tbody>
                        <?php while($query_mails = mysqli_fetch_array($query_sender)){ ?>
                                <tr>
                                    <td class="mailbox-name"><a href="administrator.php?do=mail_inbox&mail=mail_read&mail_id=<?php echo $query_mails['mail_id']; ?>&page=sent_box"><?php echo $query_mails["mail_receiver"]; ?></a></td>
                                    <td class="mailbox-subject">
										<a style="color: initial;" href="administrator.php?do=mail_inbox&mail=mail_read&mail_id=<?php echo $query_mails['mail_id']; ?>&page=sent_box">
											<b><?php echo $query_mails["mail_subject"]; ?></b> - <?php echo strip_tags(substr($query_mails["mail_content"],0,100))."..."; ?>
										</a>
									</td>
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
   