<?php
require_once("../system/settings.php");
function add_to_cart($products_information)
{
	if (isset($_SESSION["shopping_cart"])) {
		$shopping_cart = $_SESSION["shopping_cart"];
		$products = $shopping_cart["products"];
	} else {
		$products = array();
	}
	if (array_key_exists($products_information->id, $products)) {
		$products[$products_information->id]->quantity++;
	} else {
		$products[$products_information->id] = $products_information;
	}
	$total_payment = 0;
	$total_quantity = 0;
	foreach ($products as $product) {
		$product->total_payment = $product->quantity * $product->price;
		$total_payment += $product->total_payment;
		$total_quantity += $product->quantity;
	}
	//echo $total_payment . "->" . $total_quantity;
	$order_summary["total_payment"] = $total_payment;
	$order_summary["total_quantity"] = $total_quantity;
	$_SESSION["shopping_cart"]["products"] = $products;
	$_SESSION["shopping_cart"]["order_summary"] = $order_summary;
	//print_r($products);
	return $total_quantity;
}
if (isset($_POST["transactions"])) {
	$transactions = $_POST["transactions"];
	if ($transactions == "Add") {
		$product_id = $_POST["product_id"];
		$product = mysqli_fetch_object(mysqli_query($con, "SELECT id,price FROM products WHERE id='$product_id'"));
		$product->quantity = 1;
		echo add_to_cart($product);
	} else if ($transactions == "Delete") {
	}
}
