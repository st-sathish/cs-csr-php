<?php
session_start();
include '../db/db_conn.php';
include '../models/User.php';
include '../constants.php';
$action = $_REQUEST['action'];

if($action == 'change_password') {
	$old_pass = $_POST['old_password'];
	$new_pass = $_POST['new_password'];
	$confirm_pass = $_POST['confirm_password'];

	if($old_pass == '') {
		$_SESSION['cp_msg'] = "Old Password must not be empty";
		header("location:". BASE_URL ."/views/change_password.php");
		return;
	}
	if($new_pass == '') {
		$_SESSION['cp_msg'] = "New Password must not be empty";
		header("location:". BASE_URL ."/views/change_password.php");
		return;
	}
	if($confirm_pass == '') {
		$_SESSION['cp_msg'] = "Confirm password must not be empty";
		header("location:". BASE_URL ."/views/change_password.php");
		return;
	}
	if($new_pass != $confirm_pass) {
		$_SESSION['cp_msg'] = "New Password and Confirm password must be same";
		header("location:". BASE_URL ."/views/change_password.php");
		return;
	}

	$user = new User();
	$oldPassword = $user->get_password($_SESSION['username']);
	if(md5($old_pass) != $oldPassword) {
		$_SESSION['cp_msg'] = "Old Password didn't matched";
		header("location:". BASE_URL ."/views/change_password.php");
		return;
	}
	$user->change_password($new_pass, $_SESSION['username']);
	$_SESSION['cp_msg'] = "Password successfully changed";
	header("location:". BASE_URL ."/views/dashboard.php");
}