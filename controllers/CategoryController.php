<?php
session_start();
include '../db/db_conn.php';
include '../models/Category.php';

// class CategoryController {
	$action = $_REQUEST['action'];

	if ($action == 'add_category') {
		add_category($_POST['category']);
	}
	if($action == 'update_category') {
		$category_id = $_POST["categoryId"];
		$category = $_POST["category"];
		$ca = new Category();
		$ca->update_category($category_id, $category, $_SESSION['username']);
		$_SESSION['msg'] = "Successfully Category Updated";
		header("location:../views/category/categories.php");
	}

	function add_category($category) {
		$ca = new Category();
		$ca->save_category($category, $_SESSION['username']);
		$_SESSION['msg'] = "Successfully Category Added";
		header("location:../views/category/categories.php");
	}
// }