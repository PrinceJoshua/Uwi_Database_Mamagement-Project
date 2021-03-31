<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;


$result = $collection->aggregate([  ['$unwind' => '$items'],
                                    ['$group' => [
                                                    '_id' => '$items.ProdID',
                                                    'pname' =>  ['$first' => '$items.ProdName'],
                                                    'totalAmtSold' => ['$sum' => '$items.AmtSold'],
                                                  ]
                                    ],
                                    [
                                       '$count' => 'total'
                                    ]
                                   
                                    ]);


foreach ($result as $entry) {
    
    echo json_encode($entry);
}
?>