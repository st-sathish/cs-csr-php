<?php
include 'Category.php';
class Item {

	public function save_item($item_name, $barcode, $price, $expiry_date, $user, $category) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_items (item_name, barcode, price, expiry_date, 
    		created_by, created_at, category) VALUES (?,?,?,?,?,?,?)");
    	$stmt->bind_param("sssssss", $item_name, $barcode, $price, $expiry_date, $user, $today, $category);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_items() {
		$sql = "SELECT * from csr_items ORDER BY i_id";
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
}