<?php
    $_Productcode = $_REQUEST['m_code'];
    require_once "../vendor/autoload.php";	
	$collection = (new MongoDB\Client)->POS->Product;
	
    $result = $collection->findOne(['code' => $_Productcode]);

    if(!empty($result))
    {
        $myObj=new \stdClass();
        $myObj->_id = (string)$result['_id'];
        $myObj->Code = $result['code'];
        $myObj->Name = $result['name'];
        $myObj->Cost = $result['cost'];
        $myObj->Price = $result['price'];
        $myObj->Onhand = $result['onhand'];
        $myObj->vendors = $result['vendors'];
        echo json_encode($myObj);
    }

    else{
        $myObj=new \stdClass();
        $myObj->Name = '';
        echo json_encode($myObj);
    }
?>