<?php
include 'Category.php';
class Item {

	public function save_item($item_name, $barcode, $price, $expiry_date, $user, $category) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_items (item_name, barcode, price, expiry_date, 
    		created_by, created_at, modified_by, modified_at, category) VALUES (?,?,?,?,?,?,?,?,?)");
    	$stmt->bind_param("sssssssss", $item_name, $barcode, $price, $expiry_date, 
    		$user, $today, $user, $today, $category);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_items($params) {
		$sql = "SELECT * from csr_items";
		if(isset($params['search']) && $params['search'] != '') {
			$sql .= ' WHERE item_name LIKE \'%' .$params['search'].'%\' ORDER BY modified_at DESC';
			$count = $this->get_total_items($sql);
		} else {
			$count = $this->get_total_items($sql);
			$offset = $params['offset'];
			$limit = $params['limit'];
			$sql .= ' ORDER BY modified_at DESC limit '.$limit.' offset '.$offset;
		}
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

	public function get_expired_items() {
		$today = date('Y-m-d');
		$sql = "SELECT * from csr_items where expiry_date < '$today' ORDER BY modified_at DESC";
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
	}

	public function get_item($item_id) {
		$sql = "SELECT * from csr_items where i_id = $item_id";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
	    $item = $row;
	    $category = new Category();
	    $item['category'] = $category->get_category($row['category']);
	    return $item;
	}

	public function update_item($item_id, $item_name, $barcode, $price, $expiry_date, $user, $category) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("UPDATE csr_items SET item_name = ? , barcode =?, price =?, expiry_date =?, 
    		modified_by = ?, modified_at = ?, category = ? WHERE i_id = ?");
    	$stmt->bind_param("ssssssss", $item_name, $barcode, $price, $expiry_date, $user, $today, $category, $item_id);
    	$stmt->execute() or die($stmt->error);
	}
}