<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Product;
$ProdPriceRange = $_REQUEST['ProdPriceRange'];
$ProdPriceRange = json_decode($ProdPriceRange, true);
//appropriate variables
$min = (float)$ProdPriceRange['min'];
$max = (float)$ProdPriceRange['max'];

$result = $collection->count(['price' => ['$gte' => $min, '$lte' => $max]]);

echo json_encode($result);

?>