<div class="item <?php if($sayi==1){ echo'active'; } ?>">
	<div class="col-sm-6">
		<h1><span><?php echo $slider_top_header; ?></h1>
		<h2><?php echo $slider_bottom_header; ?></h2>
		<p><?php echo $slider_description; ?></p>
		<a href="<?php echo $slider_buy_link ?>"><button type="button" class="btn btn-default get">Şimdi satın al</button></a>
	</div>
	<div class="col-sm-6">
		<img src="../../admin/uploads/slider/<?php echo $slider_photo; ?>" class="girl img-responsive" alt="" />
		<img src="../../admin/uploads/slider/<?php echo $slider_price_photo; ?>"  class="pricing" alt="" />
	</div>
</div>