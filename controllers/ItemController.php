<?php
session_start();
include '../db/db_conn.php';
include '../models/Item.php';
// class CategoryController {
	$action = $_REQUEST['action'];

	if ($action == 'add_item') {
		parse("ADD", $_POST);
	}
	else if ($action == 'edit_item') {
		parse("MODIFY", $_POST);
	}

	function parse($action, $post) {
		$itemName = $post['itemName'];
		$price = $post['price'];
		$barcode = $post["barCode"];
		$expirydate = $post["expiryDate"];
		$category = $post['category'];
		if ($action == "ADD") {
			add_item($itemName, $barcode, $price, $expirydate, $category);
		}
		else if ($action == "MODIFY") {
			$itemId = $post['itemId'];
			update_item($itemId, $itemName, $barcode, $price, $expirydate, $category);
		}
	}

	function add_item($itemName, $barcode, $price, $expirydate, $category) {
		$ca = new Item();
		$ca->save_item($itemName, $barcode, $price, $expirydate, $_SESSION['username'], $category);
		$_SESSION['msg'] = "Item successfully Added";
		header("location:../views/item/items.php");
	}

	function update_item($itemId, $itemName, $barcode, $price, $expirydate, $category) {
		$ca = new Item();
		$ca->update_item($itemId, $itemName, $barcode, $price, $expirydate, $_SESSION['username'], $category);
		$_SESSION['msg'] = "Item successfully Updated";
		header("location:../views/item/items.php");
	}

// }