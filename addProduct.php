<?php
      require_once "../vendor/autoload.php";	
    $product = $_POST['product'];
    $decodedProduct = json_decode($product, true);
	  $collection = (new MongoDB\Client)->POS->Product;


    
    $float_cost = (float) $decodedProduct['cost'];
    $flost_price = (float) $decodedProduct['price'];
    $int_onhand = (int) $decodedProduct['onhand'];

    $new_product = ['code' => $decodedProduct['code'], 
                    'name' => $decodedProduct['name'],
                    'cost' => $float_cost,
		                'price' => $flost_price,
                    'onhand' => $int_onhand, 
                    'vendors' => $decodedProduct['vendors']
                  ];
    
   
    $collection->insertOne($new_product);

?>