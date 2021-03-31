<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;
$BestSell = $_REQUEST['BestSell'];
$BestSell = json_decode($BestSell, true);
//appropriate variables
$page  = isset($BestSell['page']) ? (int)$BestSell['page'] : 1;
$limit = (int)$BestSell['limit'];
$skip  =($page -1) * $limit;


$result = $collection->aggregate([  ['$unwind' => '$items'],
                                    ['$group' => [
                                                    '_id' => '$items.ProdID',
                                                    'pname' =>  ['$first' => '$items.ProdName'],
                                                    'totalAmtSold' => ['$sum' => '$items.AmtSold'],
                                                  ]
                                    ],
                                    ['$sort' => ['totalAmtSold' => -1]],
                                    ['$skip' => $skip],
                                    ['$limit' => $limit] 
                                    
                                   
                                    ]);


foreach ($result as $entry) {
    $arr_out[] = $entry;
}
if (isset($arr_out)){
    echo json_encode($arr_out);
}
else{
    echo "";
}