<?php
	
	include_once( dirname( __FILE__ ) . '/../class/Database.class.php' );
	$pdo = Database::getInstance()->getPdoObject();

	$notification = $_POST[ 'notification' ];
	$timestamp = time();
	
	$query = $pdo->prepare( 'INSERT INTO notification VALUES(:id, :notification, :link, :status, :created_at)' );
	$query->execute( [ 'id' => '', 'notification' => $notification, 'link' => 'http://vegfru.com/'.$timestamp.'/somerandomstring', 'status' => 0, 'created_at' => $timestamp ] );
	echo json_encode(['time' => $timestamp, 'link' => 'http://vegfru.com/'.$timestamp.'/somerandomstring','lastInsertId' => $pdo->lastInsertId()]);
