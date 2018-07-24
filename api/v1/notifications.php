<?php
include '../../db/db_conn.php';
include '../../models/Notification.php';
$notification = new Notification();
echo json_encode($notification->get_notification_items(), JSON_UNESCAPED_SLASHES);