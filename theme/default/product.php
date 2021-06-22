<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".add-to-cart").click(function() {
			var url = "http://localhost/cart_transactions/cart_transactions.php";
			var data = {
				transactions: "Add",
				product_id: $(this).attr("product_id")
			};
			$.post(url, data, function(answer) {
				$(".cart_total_quantity").text("(" + answer + ")");
			});
		});
	});
</script>
<?php
$category_name = $_GET["category_name"];
$category_id = $_GET["category_id"];
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="left-sidebar">
					<h2>Category</h2>
					<div class="panel-group category-products" id="accordian">
						<!--category-productsr-->
						<?php category($con); ?>
					</div>
					<!--/category-productsr-->

					<div class="brands_products">
						<!--brands_products-->
						<h2>Brands</h2>
						<div class="brands-name">
							<ul class="nav nav-pills nav-stacked">
								<li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
								<li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
								<li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
								<li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
								<li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
								<li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
								<li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
							</ul>
						</div>
					</div>
					<!--/brands_products-->

					<div class="price-range">
						<!--price-range-->
						<h2>Price Range</h2>
						<div class="well">
							<input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
							<b>$ 0</b> <b class="pull-right">$ 600</b>
						</div>
					</div>
					<!--/price-range-->
					<div class="shipping text-center">
						<!--shipping-->
						<img src="<?php echo THEME_URL; ?>images/home/shipping.jpg" alt="" />
					</div>
					<!--/shipping-->

				</div>
			</div>
			<div class="col-sm-9 padding-right">
				<div class="features_items">
					<!--features_items-->
					<h2 class="title text-center"><?php echo $category_name; ?></h2>
					<?php
					$query = mysqli_query($con, "SELECT * FROM products WHERE category_id='$category_id'");
					if (mysqli_affected_rows($con)) {
						while ($products = mysqli_fetch_array($query)) {
					?>
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="../../admin/uploads/products/<?php echo $products["photo"]; ?>" alt="" />
											<h2>₺ <?php echo $products["price"]; ?></h2>
											<p><?php echo $products["name"]; ?></p>
											<button product_id="<?php echo $products["id"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Sepete ekle</button>
										</div>
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href=""><i class="fa fa-plus-square"></i>Favorilere ekle</a></li>
											<li><a href=""><i class="fa fa-plus-square"></i>Karşılaştır</a></li>
										</ul>
									</div>
								</div>
							</div>
						<?php }
					} else { ?>
						<div class="class-sm-12" style="margin-left: 30% !important;">Şuan için aradığınız kategoride ürün bulunmamaktadır.</div>
					<?php } ?>
				</div>
				<!--features_items-->
				<ul class="pagination class-sm-12" style="margin-left: 40% !important;">
					<li class="active"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">&raquo;</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>