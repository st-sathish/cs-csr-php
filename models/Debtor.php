<?php
class Debtor {
	
	public function save_item($debtor_emp_id, $first_name, $last_name, $email, $debt_amount, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_debtors (debtor_emp_id, first_name, last_name, email, debt_balance, created_by, created_at, modified_by, modified_at) VALUES (?,?,?,?,?,?,?,?,?)");
    	$stmt->bind_param("sssssssss", $debtor_emp_id, $first_name, $last_name, $email, 
    		$debt_amount, $user, $today, $user, $today);
    	$stmt->execute() or die($stmt->error);
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
	    $items = array();
	    while ($row = $result->fetch_assoc()) {
	        array_push($items, $row);
	    }
	    $response = array();
	    $response["total_record"] = $count;
	    $response['data'] = $items;
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
    		modified_by = '$user', modified_at = '$today' WHERE debtor_emp_id IN ('$ids_str')";
    	mysqli_query($GLOBALS['conn'], $sql);
	}
}