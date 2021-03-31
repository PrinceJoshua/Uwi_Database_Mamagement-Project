<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;
$SaleByDate = $_REQUEST['SaleByDate'];
$SaleByDate = json_decode($SaleByDate, true);
$startD = $SaleByDate['start'];
$finishD = $SaleByDate['finish'];
//appropriate variables
$page  = isset($SaleByDate['page']) ? (int)$SaleByDate['page'] : 1;
$limit = (int)$SaleByDate['limit'];
$skip  = ($page -1) * $limit;



$startDate = new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable($startD));
$finishDate = new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable($finishD));

function getDOB($date){
    $utcdatetime = new MongoDB\BSON\UTCDateTime((string)$date);
    $datetime = $utcdatetime->toDateTime();
    $mydate = $datetime->format('Y-m-d');
    return $mydate;
}


$result = $collection->aggregate([ 
                                    ['$match' => 
                                                [ 
                                                    '$and' =>  
                                                             [
                                                                    ['salesdate' => ['$gte' => $startDate]],
                                                                    ['salesdate' => [ '$lte' => $finishDate]]
                                                             ]
                                                              
                                                ]
                                    ],
                                    [
                                        '$group' => 
                                                [
                                                    '_id' => ['day' => ['$dayOfYear'=> '$salesdate'], 'year' => ['$year'=> '$salesdate']],
                                                    'date' => ['$first' => '$salesdate'],
                                                    'amt' => ['$sum' => '$salestotal'],
                                                    'avgAmt' => ['$avg' => '$salestotal'],
                                                    'counter' => ['$sum'=> 1]
                                                ]
                                    ],
                                    [
                                        '$sort' => ['_id'=> -1]
                                    ],
                                    [
                                        '$skip' => $skip
                                    ],
                                    [
                                        '$limit' => $limit
                                    ]
                                                 
                                ]);

foreach ($result as $entry)
 {
     $entry['date'] = getDOB($entry['date']);
    $entry['amt'] = number_format($entry['amt'],2);
    $entry['avgAmt'] = number_format($entry['avgAmt'],2);
    $arr_out[] = $entry;
} 
if (isset($arr_out)){
    echo json_encode($arr_out);
}
else
{
    echo "";
}

?>