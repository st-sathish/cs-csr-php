<?php
session_start();
include '../db/db_conn.php';
include '../models/Item.php';
// class CategoryController {
	$action = $_REQUEST['action'];

	if ($action == 'add_item') {
		$itemName = $_POST['itemName'];
		$price = $_POST['price'];
		$barcode = $_POST["barCode"];
		$expirydate = $_POST["expiryDate"];
		$category = $_POST['category'];
		add_item($itemName, $barcode, $price, $expirydate, $category);
	}

	function add_item($itemName, $barcode, $price, $expirydate, $category) {
		$ca = new Item();
		$ca->save_item($itemName, $barcode, $price, $expirydate, $_SESSION['username'], $category);
		$_SESSION['msg'] = "Successfully Category Added";
		header("location:../views/item/items.php");
	}
// }