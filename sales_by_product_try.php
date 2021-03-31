<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;
$SaleByProd = $_REQUEST['SaleByProd'];
$SaleByProd = json_decode($SaleByProd, true);


//appropriate variables
$code= $SaleByProd['pcode'];
$page  = isset($SaleByProd['page']) ? (int)$SaleByProd['page'] : 1;
$limit = (int)$SaleByProd['limit'];
$skip  = ($page -1) * $limit;


function getDOB($date){
    $utcdatetime = new MongoDB\BSON\UTCDateTime((string)$date);
    $datetime = $utcdatetime->toDateTime();
    $mydate = $datetime->format('Y-m-d');
    return $mydate;
}


$result = $collection->aggregate([  ['$unwind' => '$items'],
                                    ['$match' => ['items.ProdID' => $code]],
                                    ['$group' => [
                                                    '_id' => [ 'day' => [ '$dayOfYear' => '$salesdate'], 'year' => [ '$year' => '$salesdate' ] ],
                                                    'date' => ['$first' => '$salesdate'],
                                                    'subTotal' => ['$sum' => ['$multiply' => ['$items.AmtSold','$items.UnitPrice']]],
                                                    'count' => ['$sum' => '$items.AmtSold'],
                                                  ]
                                    
                                    ],
                                    ['$sort' => ['date' => 1]],
                                    ['$skip' => $skip],
                                    ['$limit' => $limit] 
                                    
                                   
                                    ]);

foreach ($result as $entry) {
    $entry['date'] = getDOB($entry['date']);
    $entry['subTotal'] = number_format($entry['subTotal'],2);
    $arr_out[] = $entry;
}
if (isset($arr_out)){
    echo json_encode($arr_out);
}
else{
    echo "";
}