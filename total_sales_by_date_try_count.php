<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Sales;

$SaleByDate = $_REQUEST['SaleByDate'];
$SaleByDate = json_decode($SaleByDate, true);
$startD = $SaleByDate['start'];
$finishD = $SaleByDate['finish'];

$startDate = new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable($startD));
$finishDate = new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable($finishD));

function getDOB($date){
    $utcdatetime = new MongoDB\BSON\UTCDateTime((string)$date);
    $datetime = $utcdatetime->toDateTime();
    $mydate = $datetime->format('Y-m-d');
    return $mydate;
}


$result = $collection->aggregate([ 
    ['$match' => [ '$and' => [ ['salesdate' => ['$gte' => $startDate,'$lte' =>$finishDate]]
                             ]
                ]
    ],
    ['$group' => 
                [
                    '_id' => ['day' => ['$dayOfYear'=> '$salesdate'], 'month' => ['$month' => '$salesdate'], 'year' => ['$year'=> '$salesdate']],
                    'date' => ['$first' => '$salesdate'],
                    'amt' => ['$sum' => '$salestotal'],
                    'avgAmt' => ['$avg' => '$salestotal'],
                    'counter' => ['$sum'=> 1]
                ]
                ],
                [
                    '$count' => 'total'
                ]
                ]);

foreach ($result as $entry) {
    echo json_encode($entry);
    }