<?php
class Debtor {
	
	public function save_debtor($debtor_emp_id, $first_name, $last_name, $email, $debt_amount, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_debtors (debtor_emp_id, first_name, last_name, email, debtor_balance, created_by, created_at, modified_by, modified_at) VALUES (?,?,?,?,?,?,?,?,?)");
    	$stmt->bind_param("sssssssss", $debtor_emp_id, $first_name, $last_name, $email, 
    		$debt_amount, $user, $today, $user, $today);
    	$stmt->execute() or die($stmt->error);
	}

	public function is_user_exist($debtor_emp_id) {
		$sql = "SELECT * from csr_debtors where debtor_emp_id = '$debtor_emp_id'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $count = mysqli_num_rows($result);
	    return ($count > 0) ? true : false;
	}

	public function get_debtors($params) {
		$sql = "SELECT * FROM csr_debtors WHERE ";
		return $this->execute_query($sql, $params, ' ORDER BY modified_at DESC ');
	}

	public function execute_query($sql, $params, $order_by = '') {
		$offset = $params["offset"];
		$limit = $params["limit"];
		$query = $params['search'];
		$sql .= ' is_deleted = 0';
		if(isset($params['search']) && $params['search'] != '') {
			$sql .= ' AND email LIKE \'%' .$query.'%\'';
		}
		$count = $this->get_total($sql);
		if($order_by == '') {
			$sql .= " ORDER BY modified_at DESC ";
		} else {
			$sql .= $order_by;
		}
		$sql .= " limit " .$limit." offset ".$offset;
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $response = array();
	    $response["total_record"] = $count;
	    $response['data'] = Debtor::parse_result($result);
	    return $response;
	}

	public function get_total($sql) {
		$result = mysqli_query($GLOBALS['conn'], $sql);
    	return mysqli_num_rows($result);
	}

	public function delete($ids, $user) {
		$ids_str = implode(',', $ids);
		$today = date("Y-m-d h:i:s");
		$sql = "UPDATE csr_debtors SET is_deleted = 1, 
    		modified_by = '$user', modified_at = '$today' WHERE debtor_id IN ('$ids_str')";
    	mysqli_query($GLOBALS['conn'], $sql);
	}

	public function update_debtor($debtId, $debtorEmpId, $firstName, $lastName, $email, $debtAmount, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("UPDATE csr_debtors SET debtor_emp_id = ? , first_name =?, last_name =?, email=?, debtor_balance=?, modified_by = ?, modified_at = ? WHERE debtor_id = ?");
    	$stmt->bind_param("ssssssss", $debtorEmpId, $firstName, $lastName, $email, $debtAmount, $user, $today, $debtId);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_debtor($debtor_id) {
		$sql = "SELECT * from csr_debtors where debtor_id = $debtor_id";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    return $result->fetch_assoc();
	}

	public function get_debtors_by_ids($ids) {
		$ids_str = implode($ids, ',');
		$sql = "SELECT * from csr_debtors where debtor_id IN($ids_str)";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    return Debtor::parse_simple_result($result);
	}

	public static function parse_result($result) {
		$debtors = array();
		while($row = $result->fetch_assoc()) {
			$debtor['debtor_id'] = $row['debtor_id'];
			$debtor['debtor_emp_id'] = $row['debtor_emp_id'];
	    	Debtor::put_mandatory_columns($debtor, $row);
	    	array_push($debtors, $debtor);
	    }
	    return $debtors;
	}

	public static function parse_simple_result($result) {
		$debtors = array();
		while($row = $result->fetch_assoc()) {
	    	Debtor::put_mandatory_columns($debtor, $row);
	    	array_push($debtors, $debtor);
	    }
	    return $debtors;
	}

	public static function put_mandatory_columns(&$debtor, $row) {
		if($debtor == null || !isset($debtor)) {
			$debtor = array();
		}
		$debtor['first_name'] = $row['first_name'];
	    $debtor['last_name'] = $row['last_name'];
	    $debtor['email'] = $row['email'];
	    $debtor['debtor_balance'] = $row['debtor_balance'];
	}
}