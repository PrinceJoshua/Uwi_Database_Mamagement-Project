<?php
	require_once "../vendor/autoload.php";
    $_mcode = $_REQUEST['m_code'];
    $collection = (new MongoDB\Client)->POS->Product;
    $code_regex = new MongoDB\BSON\Regex( "^{$_mcode}", 'i');
   
    $result = $collection->find(['name' => $code_regex], ['limit' => 8], ['price' => 1, 'code' => 1]);
       
    foreach($result as $row)
     {
         $arr_out[] = $row;
    }
     
     if (isset($arr_out)) 
     {
        echo json_encode($arr_out);
         return;
    }
    else
    {
        echo "X";
        return;
    }