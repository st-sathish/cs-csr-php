<?php
require_once 'firebase/Firebase.php';
require_once 'firebase/Push.php';
require_once 'models/User.php';
require_once 'db/db_conn.php';

$today = date('Y-m-d');
$sql = "SELECT * from csr_items where expiry_date < '$today' ORDER BY modified_at DESC";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
	$barcode = $row["barcode"];
	$item_name = $row['item_name'];
	$expiry_date = $row['expiry_date'];
	$msg = $item_name . 'under the barcode '.$barcode.' will expire on '.$expiry_date;

	$push = new Push('CapeStart CSR Alert', $msg);
	//getting the push from push object
 	$mPushNotification = $push->getPush(); 
 
 	$user = new User();
 	$devicetoken = $user->get_push_notification_token('admin@gmail.com');

 	//creating firebase class object
 	$firebase = new Firebase(); 
 
 	//sending push notification and displaying result
 	echo $firebase->send($devicetoken, $mPushNotification);
}