<?php
include_once 'Category.php';
class Item {

	public function save_item($item_name, $barcode, $price, $s_price, $expiry_date, $user, $category) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_items (item_name, barcode, purchase_price, selling_price, expiry_date, 
    		created_by, created_at, modified_by, modified_at, category) VALUES (?,?,?,?,?,?,?,?,?,?)");
    	$stmt->bind_param("ssssssssss", $item_name, $barcode, $price, $s_price, $expiry_date, 
    		$user, $today, $user, $today, $category);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_items($params, $notification_dates) {
		$expiry_date = date('m/d/Y');
		$noti_date_str = '';
		foreach ($notification_dates as $date) {
			$noti_date_str .= '\''.$date.'\'' . ',';
		}
		$noti_date_str = rtrim($noti_date_str, ',');
		$sql = "SELECT *, CASE WHEN expiry_date IN ($noti_date_str) 
		THEN 1 ELSE 2 END as tmp from csr_items WHERE is_sold = 0 
		AND expiry_date > '$expiry_date'";
		return $this->execute_item_query($sql, $params, ' ORDER BY tmp ASC ');
	}

	public function get_expired_items($expiry_date, $offset, $limit, $query = '') {
		$sql = "SELECT * from csr_items WHERE expiry_date = '$expiry_date' AND is_sold = 0";
		return $this->execute_item_query($sql, $limit, $offset, $query);
	}

	public function get_all_expired_items($params) {
		$expiry_date = date('m/d/Y');
		$sql = "SELECT * from csr_items WHERE expiry_date <= '$expiry_date' AND is_sold = 0";
		return $this->execute_item_query($sql, $params);
	}

	public function get_all_sold_items($params) {
		$sql = "SELECT * from csr_items WHERE is_sold = 1";
		return $this->execute_item_query($sql, $params);
	}

	public function execute_item_query($sql, $params, $order_by = '') {
		$offset = $params["offset"];
		$limit = $params["limit"];
		$query = $params['search'];
		$sql .= ' AND is_deleted = 0';
		if(isset($params['search']) && $params['search'] != '') {
			$sql .= ' AND item_name LIKE \'%' .$query.'%\'';
		}
		$count = $this->get_total_items($sql);
		if($order_by == '') {
			$sql .= " ORDER BY expiry_date DESC ";
		} else {
			$sql .= $order_by;
		}
		$sql .= " limit " .$limit." offset ".$offset;
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $items = array();
	    while ($row = $result->fetch_assoc()) {
	        $item = $row;
	        $category = new Category();
	        $item['category'] = $category->get_category($row['category']);
	        array_push($items, $item);
	    }
	    $response = array();
	    $response["total_record"] = $count;
	    $response['data'] = $items;
	    return $response;
	}

	public function get_total_items($sql) {
		$result = mysqli_query($GLOBALS['conn'], $sql);
    	return mysqli_num_rows($result);
	}

	/*public function get_expired_items() {
		$today = date('Y-m-d');
		$sql = "SELECT * from csr_items where expiry_date < '$today' AND is_sold = 0 AND is_deleted = 0 ORDER BY modified_at DESC";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $items = array();
	    while ($row = $result->fetch_assoc()) {
	        $item = $row;
	        $category = new Category();
	        $item['category'] = $category->get_category($row['category']);
	        array_push($items, $item);
	    }
	    return $items;
	}*/

	public function get_item($item_id) {
		$sql = "SELECT * from csr_items where i_id = $item_id AND is_sold=0 AND is_deleted = 0";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
	    $item = $row;
	    $category = new Category();
	    $item['category'] = $category->get_category($row['category']);
	    return $item;
	}

	public function update_item($item_id, $item_name, $barcode, $price, $s_price, $expiry_date, $user, $category) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("UPDATE csr_items SET item_name = ? , barcode =?, purchase_price =?, selling_price =?, expiry_date =?, modified_by = ?, modified_at = ?, category = ? WHERE i_id = ?");
    	$stmt->bind_param("ssssssss", $item_name, $barcode, $price, $s_price, $expiry_date, $user, $today, $category, $item_id);
    	$stmt->execute() or die($stmt->error);
	}

	public function mark_as_sold($ids, $user) {
		$ids_str = implode(',', $ids);
		$today = date("Y-m-d h:i:s");
		$sql = "UPDATE csr_items SET is_sold = 1, 
    		modified_by = '$user', modified_at = '$today' WHERE i_id IN ('$ids_str')";
    	mysqli_query($GLOBALS['conn'], $sql);
	}

	public function delete($ids, $user) {
		$ids_str = implode(',', $ids);
		$today = date("Y-m-d h:i:s");
		$sql = "UPDATE csr_items SET is_deleted = 1, 
    		modified_by = '$user', modified_at = '$today' WHERE i_id IN ('$ids_str')";
    	mysqli_query($GLOBALS['conn'], $sql);
	}

	public function get_expired_dates_group_by() {
		$yesterday_date = date('m-d-Y', strtotime("-1 days"));
		$sql = "SELECT * from csr_items where expiry_date <= '$yesterday_date' AND 
		is_sold=0 AND is_deleted = 0 group by expiry_date order by expiry_date desc";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $exp_dates = array();
	    while ($row = $result->fetch_assoc()) {
	        array_push($exp_dates, $row["expiry_date"]);
	    }
	    return $exp_dates;
	}
}