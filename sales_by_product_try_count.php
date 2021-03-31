<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;
$SaleByProd = $_REQUEST['SaleByProd'];
$SaleByProd = json_decode($SaleByProd, true);
$pcode= $SaleByProd['pcode'];


$result = $collection->aggregate([  ['$unwind' => '$items'],
                                    ['$match' => ['items.ProdID' => $pcode]],
                                    ['$group' => [
                                        '_id' => [ 'day' => [ '$dayOfYear' => '$salesdate'], 'year' => [ '$year' => '$salesdate' ] ],
                                        'date' => ['$first' => '$salesdate'],
                                        'subTotal' => ['$sum' => ['$multiply' => ['$items.AmtSold','$items.UnitPrice']]],
                                        'count' => ['$sum' => '$items.AmtSold'],
                                      ]
    
                                    ],
                                    [
                                        '$count' => 'total'
                                    ]
                                    
                                   
]);






foreach ($result as $entry) {
    echo json_encode($entry);
}