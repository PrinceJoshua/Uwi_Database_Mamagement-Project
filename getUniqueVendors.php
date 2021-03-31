<?php 
	require_once "../vendor/autoload.php";	
	$collection = (new MongoDB\Client)->POS->Product;
	
    $result = $collection->distinct('vendors');

    echo json_encode($result);
    
?>

