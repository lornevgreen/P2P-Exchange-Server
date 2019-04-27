<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/transaction.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$qty = $_GET['qty'];
$price = $_GET['price'];
$currency = $_GET['currency'];
$paymentmethod =$_GET['paymentmethod'];
$transactionid =$_GET['sellorderid'];
$buyorderid =$_GET['buyorderid'];
$buyerid =$_GET['buyerid'];
$sellerid =$_GET['sellerid'];
$buyercomment =$_GET['buyercomment'];
$sellercomment =$_GET['sellercomment'];
$buyerrating =$_GET['buyerrating'];
$sellerrating =$_GET['sellerrating'];
$transactionno =$_GET['transactionno'];
$recieptno =$_GET['recieptno'];


$authresponse = authenticate($ticket,$raida);

// echo json_decode( $authresponse);

if($authresponse["result"]) {
    
    $transaction = new Transaction($db);
    $transaction->coinsn =$authresponse["sn"];
    $transaction->qty=$qty;
    $transaction->price=$price;
    $transaction->currency = $currency;
    $transaction ->paymentmethod = $paymentmethod;
    $transaction->buyorderid=$buyorderid;
    $transaction->sellorderid=$sellorderid;
    $transaction->buyerid=$buyerid;
    $transaction->sellerid=$sellerid;
    $transaction->buyercomment=$buyercomment;
    $transaction->sellercomment=$buyercomment;
    $transaction->buyerrating=$buyerrating;
    $transaction->sellerrating=$sellerrating;
    $transaction->transactionno=$transactionno;
    $transaction->recieptno=$recieptno;
    
                    
    
    
    if($transaction->create()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Posted Transaction Successfully"));
    }
    else {
        echo json_encode(array("message" => "Error Posting transaction"));
  
    }
}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode(array("message" => "Unauthorised Request"));
}

?>