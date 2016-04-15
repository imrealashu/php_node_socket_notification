<?php

include_once( dirname( __FILE__ ) . '/../class/Database.class.php' );
$pdo = Database::getInstance()->getPdoObject();

$notification_id = $_POST[ 'notification_id' ];

$query = $pdo->prepare( 'UPDATE notification SET status=1 WHERE id=:id' );
$query->execute( [ 'id' => $notification_id ] );
