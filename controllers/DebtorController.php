<?php
session_start();
include '../db/db_conn.php';
include '../models/Debtor.php';
	$action = $_REQUEST['action'];
	if ($action == 'add_debtor') {
		parse("ADD", $_POST);
	}
	else if ($action == 'edit_debtor') {
		parse("MODIFY", $_POST);
	}

	function parse($action, $post) {
		$debtorEmpId = $post['debtorEmpId'];
		$firstName = $post['firstName'];
		$lastName = $post["lastName"];
		$email = $post["email"];
		$debtAmount = $post['debtAmount'];
		if ($action == "ADD") {
			add_debtor($debtorEmpId, $firstName, $lastName, $email, $debtAmount);
		}
		else if ($action == "MODIFY") {
			$debtId = $post['debtorId'];
			update_debtor($debtId, $debtorEmpId, $firstName, $lastName, $email, $debtAmount);
		}
	}

	function add_debtor($debtorEmpId, $firstName, $lastName, $email, $debtAmount) {
		$dt = new Debtor();
		$isExist = $dt->is_user_exist($debtorEmpId);
		if($isExist) {
			$_SESSION['msg'] = "Debtor already exist";
			header("location:../views/debtor/debtors.php");
			return;
		}
		$dt->save_debtor($debtorEmpId, $firstName, $lastName, $email, $debtAmount, $_SESSION['username']);
		$_SESSION['msg'] = "Debtor successfully Added";
		header("location:../views/debtor/debtors.php");
	}

	function update_debtor($debtId, $debtorEmpId, $firstName, $lastName, $email, $debtAmount) {
		$dt = new Debtor();
		$dt->update_debtor($debtId, $debtorEmpId, $firstName, $lastName, $email, $debtAmount, $_SESSION['username']);
		$_SESSION['msg'] = "Debtor successfully Updated";
		header("location:../views/debtor/debtors.php");
	}