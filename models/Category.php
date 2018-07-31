<?php 
class Category {

	public function save_category($category, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_categories (name, created_by, created_at) VALUES (?,?,?)");
    	$stmt->bind_param("sss", $category, $user, $today);
    	$stmt->execute() or die($stmt->error);
	}

	public function get_categories() {
		$sql = "SELECT * from csr_categories ORDER BY c_id DESC";
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

	public function update_category($category_id, $category, $user) {
		$today = date("Y-m-d h:i:s");
    	$stmt = $GLOBALS['conn']->prepare("UPDATE csr_categories SET name=? WHERE c_id = ?");
    	$stmt->bind_param("ss", $category, $category_id);
    	$stmt->execute() or die($stmt->error);
	}
}

?>