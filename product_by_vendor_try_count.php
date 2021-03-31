<?php
require_once "../vendor/autoload.php";	
$collection = (new MongoDB\Client)->POS->Product;
$ProdVen = $_REQUEST['ProdVen'];
$ProdVen = json_decode($ProdVen, true);
//appropriate variables
$vendorname= $ProdVen['vendor'];
$position = $ProdVen['position'];


if ($position == -1)
{
    $result = $collection->count(['vendors' => $vendorname]);
}

else if ($position == 0)
{
    $result = $collection->count(['vendors.0' => $vendorname]);
}

else if ($position == 1)
{
    $result = $collection->count(['vendors.1' => $vendorname]);
}

else if ($position == 2)
{
    $result = $collection->count(['vendors.0' => $vendorname]);
}

else if ($position == 3)
{
    $result = $collection->count(['vendors.3' => $vendorname]);
}

else if ($position == 4)
{
    $result = $collection->count(['vendors.4' => $vendorname]);
}

else if ($position == 5)
{
    $result = $collection->count(['vendors.5' => $vendorname]);
}

else if ($position == 6)
{
    $result = $collection->count(['vendors.6' => $vendorname]);
}



echo json_encode($result);