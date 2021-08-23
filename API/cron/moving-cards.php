<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once'./object/movecards.php';
	include_once '../vendor/autoload.php';
	
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	$movecards = new moveCards($db);
    $movecards->movingCardsToFirstRevision();
	$movecards->movingCardsToSecondRevision();
	$movecards->movingCardsToThirdRevision();
	$movecards->movingCardsToFourthRevision();
	
	
?>