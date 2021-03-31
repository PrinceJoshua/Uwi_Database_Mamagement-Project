<?php 
	$_mcode = $_REQUEST['m_code'];
	require_once "../vendor/autoload.php";	
	$collection = (new MongoDB\Client)->POS->Product;
	
    $result = $collection->findOne(['code' =>  $_mcode]);



    if ($result){
        $myObj=new \stdClass();
        $myObj->Name = $result['name'];
        $myObj->Unit = $result['price'];
        echo json_encode($myObj);
    }else{
        $myObj=new \stdClass();
        $myObj->Name = '';
        echo json_encode($myObj);
    }