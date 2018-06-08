<?php 
class Category {

	public function save_category($category, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_categories (name, created_by, created_at) VALUES (?,?,?)");
    	$stmt->bind_param("sss", $category, $user, $today);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_categories() {
		$sql = "SELECT * from csr_categories ORDER BY c_id";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    while ($row = $result->fetch_assoc()) {
	        $categories[] = $row;
	    }
	    return $categories;
	}

	public function get_category($id) {
		$sql = "SELECT * from csr_categories where c_id = '$id'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    return $result->fetch_assoc();
	}
}

?>