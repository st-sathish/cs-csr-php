<?php
include_once 'Category.php';
class Notification {

	public function get_notification_items() {
		$today = date('m-d-Y');
		$sql = "SELECT * from csr_notification where event_date='$today'";
		$result = mysqli_query($GLOBALS['conn'], $sql);
		$item_ids_str = $result->fetch_assoc()['item_ids'];

		$sql1 = "SELECT * from csr_items where i_id IN ('$item_ids_str')";
		$result1 = mysqli_query($GLOBALS['conn'], $sql1);
		$items = array();
		while ($row = $result1->fetch_assoc()) {
			$item = $row;
	        $category = new Category();
	        $item['category'] = $category->get_category($row['category']);
	        array_push($items, $item);
		}
	    return $items;
	}
}