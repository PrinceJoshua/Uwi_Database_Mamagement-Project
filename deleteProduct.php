<?php 
	$_id = $_REQUEST['_id'];
	require_once "../vendor/autoload.php";	
	$collection = (new MongoDB\Client)->POS->Product;
	$result = $collection->findOneAndDelete(['_id' =>  new MongoDB\BSON\ObjectID($_id)]);


?>