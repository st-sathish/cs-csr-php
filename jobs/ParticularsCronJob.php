<?php
require_once '../firebase/Firebase.php';
require_once '../firebase/Push.php';
require_once '../models/User.php';
require_once '../db/db_conn.php';

$today = date('m-d-Y');

$sql = "SELECT * from csr_items where is_sold = 0 ORDER BY modified_at DESC";
$result = mysqli_query($conn, $sql);
$count = 0;
$item_ids = array();
while($row = mysqli_fetch_array($result)) {
	$yesterday_date = date('m-d-Y', strtotime($row['expiry_date'] .' -1 day'));
	if($today == $yesterday_date) {
		$barcode = $row["barcode"];
		$item_name = $row['item_name'];
		$count += 1;
		array_push($item_ids, $row['i_id']);
	}
}
 if ($count > 0) {
 	$itm_ids = implode(', ',$item_ids);
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO csr_notification (item_ids, event_date) VALUES (?,?)");
    $stmt->bind_param("ss", $itm_ids, $today);
    $stmt->execute() or die($stmt->error);

	$push = new Push('CapeStart CSR Alert', $count . ' Products will expire Tomorrow');
	//getting the push from push object
	$mPushNotification = $push->getPush(); 

	$user = new User();
	$devicetoken = $user->get_push_notification_token('admin@gmail.com');

	//creating firebase class object
	$firebase = new Firebase(); 

	//sending push notification and displaying result
	try {
		$firebase->send($devicetoken, $mPushNotification);
	} catch(Exception $e) {

	}
}