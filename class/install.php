<?php

include_once( dirname( __FILE__ ) . '/../class/Database.class.php' );
$pdo = Database::getInstance()->getPdoObject();

$sql = "CREATE TABLE `notification` ( `id` INT NOT NULL AUTO_INCREMENT , `notification` VARCHAR(255) NOT NULL , `link` VARCHAR(255) NOT NULL , `status` SMALLINT NOT NULL DEFAULT '0' , `created_at` VARCHAR(16) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
$query = $pdo->prepare( $sql );
$query->execute();

header('Location: ../');