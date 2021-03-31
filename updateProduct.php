<?php
      require_once "../vendor/autoload.php";
    
    $product = $_POST['product'];
    $decodedProduct = json_decode($product, true);
    $collection = (new MongoDB\Client)->POS->Product;

      
    $updateResult=  $collection->updateOne(
                            ['_id' => new MongoDB\BSON\ObjectID($decodedProduct['_id'])],
                            ['$set' => ['code' => $decodedProduct['code'],
                                       'name' => $decodedProduct['name'],
                                       'cost' => (float) $decodedProduct['cost'],
                                       'price' => (float) $decodedProduct['price'],
                                       'onhand' => (int) $decodedProduct['onhand'],
                                       'vendors' => $decodedProduct['vendors']]]
                                       
                            
                        );

    printf("Matched %d document(s)\n", $updateResult->getMatchedCount());
    printf("Modified %d document(s)\n", $updateResult->getModifiedCount());