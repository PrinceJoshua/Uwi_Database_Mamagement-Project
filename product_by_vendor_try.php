<?php

require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Product;
$ProdVen = $_REQUEST['ProdVen'];
$ProdVen = json_decode($ProdVen, true);
//appropriate variables
$vendorname= $ProdVen['vendor'];
$position = $ProdVen['position'];
$page  = isset($ProdVen['page']) ? (int)$ProdVen['page'] : 1;
$limit = (int)$ProdVen['limit'];
$skip  = ($page -1) * $limit; //amount of documents to skip


if ($position == -1)
{
    $result = $collection->find( ['vendors' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 0)
{
    $result = $collection->find( ['vendors.0' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 1)
{
    $result = $collection->find( ['vendors.1' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 2)
{
    $result = $collection->find( ['vendors.2' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 3)
{
    $result = $collection->find( ['vendors.3' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 4)
{
    $result = $collection->find( ['vendors.4' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 5)
{
    $result = $collection->find( ['vendors.5' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}

else if ($position == 6)
{
    $result = $collection->find( ['vendors.6' => $vendorname ],['limit' => $limit, 'skip' => $skip],['sort' => ['name' => 1]]);
}



foreach ($result as $entry) {
    $arr_out[] = $entry;
}
if (isset($arr_out))
{
    echo json_encode($arr_out);
}
else
{
    echo "";
}

?>