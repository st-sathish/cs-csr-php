<?php
class User {
	
	public function get_push_notification_token($email) {
		$sql = "SELECT * from csr_user where username = '$email'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
	    return $row['device_token'];
	}

	public function modify_user_device_token($email, $device_token) {
    	$stmt = $GLOBALS['conn']->prepare("UPDATE csr_user SET device_token = ? WHERE username = ?");
    	$stmt->bind_param("ss", $device_token, $email);
    	$stmt->execute() or die($stmt->error);
	}
}