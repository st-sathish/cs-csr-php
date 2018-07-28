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

	public function get_admin_email() {
		$sql = "SELECT u.username as email FROM csr_user as u, csr_role r, csr_user_role ur where ur.role_id = r.r_id 
		AND ur.user_id = u.u_id AND r.name = 'ROLE_ADMIN'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
	    return $row['email'];
	}

	public function get_password($user) {
		$sql = "SELECT password as pass FROM csr_user as u where u.username = '$user'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	    $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
	    return $row['pass'];
	}

	public function change_password($new_password, $user) {
		$sql = "UPDATE csr_user SET password = MD5('$new_password') where username = '$user'";
		$stmt = $GLOBALS['conn']->prepare($sql);
	    $stmt->execute() or die($stmt->error);
	}
}