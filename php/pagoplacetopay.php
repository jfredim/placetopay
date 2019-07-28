<?php

error_reporting(E_ALL);
ini_set("display_errors","1");

//-----------------------------------------------------
// generate and save sale reference
//-----------------------------------------------------

include "../AuthenticationTest.php";
include "../TestCase.php";

if (function_exists('random_bytes')) {
    $nonce = bin2hex(random_bytes(16));
} elseif (function_exists('openssl_random_pseudo_bytes')) {
    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
} else {
    $nonce = mt_rand();
}

$nonceBase64 = base64_encode($nonce);
$seed = date('c');
$login="6dd490faf9cb87a9862245da41170ff2";
$secretkey="024h1IlD";

$tranKey = base64_encode(sha1($nonce . $seed . $secretkey, true));

$url="https://test.placetopay.com/redirection/api/session/";

echo "Trankey $tranKey <br>";
echo "seed: $seed<br>";
echo "nonce: $nonce <br>";
exit;


    require_once '../vendor/autoload.php';
 //   use SWServices\Authentication\AuthenticationService as Authentication;
    use Dnetix\Redirection\Carrier\Authentication as  Authentication;      

$placetopay = new AuthenticationTest([
    'login' => $login,
    'tranKey' => $tranKey,
    'url' => $url,
]);
  
  
//require_once(__DIR__ . "/../bootstrap.php");
// Creating a random reference for the test
$reference = 'TEST_' . time();
// Request Information
$request = [
    "locale" => "es_CO",
    "payer" => [
        "name" => "Kellie Gerhold",
        "surname" => "Yost",
        "email" => "flowe@anderson.com",
        "documentType" => "CC",
        "document" => "1848839248",
        "mobile" => "3006108300",
        "address" => [
            "street" => "703 Dicki Island Apt. 609",
            "city" => "North Randallstad",
            "state" => "Antioquia",
            "postalCode" => "46292",
            "country" => "US",
            "phone" => "363-547-1441 x383"
        ]
    ],
    "buyer" => [
        "name" => "Kellie Gerhold",
        "surname" => "Yost",
        "email" => "flowe@anderson.com",
        "documentType" => "CC",
        "document" => "1848839248",
        "mobile" => "3006108300",
        "address" => [
            "street" => "703 Dicki Island Apt. 609",
            "city" => "North Randallstad",
            "state" => "Antioquia",
            "postalCode" => "46292",
            "country" => "US",
            "phone" => "363-547-1441 x383"
        ]
    ],
    "payment" => [
        "reference" => $reference,
        "description" => "Iusto sit et voluptatem.",
        "amount" => [
            "taxes" => [
                [
                    "kind" => "ice",
                    "amount" => 56.4,
                    "base" => 470
                ],
                [
                    "kind" => "valueAddedTax",
                    "amount" => 89.3,
                    "base" => 470
                ]
            ],
            "details" => [
                [
                    "kind" => "shipping",
                    "amount" => 47
                ],
                [
                    "kind" => "tip",
                    "amount" => 47
                ],
                [
                    "kind" => "subtotal",
                    "amount" => 940
                ]
            ],
            "currency" => "USD",
            "total" => 1076.3
        ],
        "items" => [
            [
                "sku" => 26443,
                "name" => "Qui voluptatem excepturi.",
                "category" => "physical",
                "qty" => 1,
                "price" => 940,
                "tax" => 89.3
            ]
        ],
        "shipping" => [
            "name" => "Kellie Gerhold",
            "surname" => "Yost",
            "email" => "flowe@anderson.com",
            "documentType" => "CC",
            "document" => "1848839248",
            "mobile" => "3006108300",
            "address" => [
                "street" => "703 Dicki Island Apt. 609",
                "city" => "North Randallstad",
                "state" => "Antioquia",
                "postalCode" => "46292",
                "country" => "US",
                "phone" => "363-547-1441 x383"
            ]
        ],
        "allowPartial" => false
    ],
    "expiration" => date('c', strtotime('+1 hour')),
    "ipAddress" => "127.0.0.1",
    "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
    "returnUrl" => "http://dnetix.dev/p2p/client",
    "cancelUrl" => "https://dnetix.co",
    "skipResult" => false,
    "noBuyerFill" => false,
    "captureAddress" => false,
    "paymentMethod" => null
];
try {
    $placetopay = placetopay();
    $response = $placetopay->request($request);
    if ($response->isSuccessful()) {
        // Redirect the client to the processUrl or display it on the JS extension
        // $response->processUrl();
    } else {
        // There was some error so check the message
        // $response->status()->message();
    }
    var_dump($response);
} catch (Exception $e) {
    var_dump($e->getMessage());
}  
    

if(!empty($_POST)){
	if(isset($_POST["customer_name"]) &&isset($_POST["customer_email"]) &&isset($_POST["customer_movil"]) ){
			include "conexion.php";
			
			$sql = "update orders set customer_name=\"$_POST[customer_name]\",customer_email=\"$_POST[customer_email]\",customer_movil=\"$_POST[customer_movil]\",status=\"$_POST[status]\",updated_at=NOW() where id=".$_POST["id"];
			$query = $con->query($sql);
			if($query!=null){
				print "<script>alert(\"Actualizado exitosamente.\");window.location='../ver.php';</script>";
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../ver.php';</script>";

			}
		}
}
echo "no entro";


?>