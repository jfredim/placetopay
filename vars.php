<?php

use Exception;

include 'Conf.php';
//======================================================================
// General Data
//======================================================================
$postUrl="https://test.placetopay.com/redirection/api/session/";
$apiKey=$API_KEY;
$merchantId = $MERCHANTID;
$accountId = $ACCOUNTID;
$tax="0";
$taxReturnBase="0";
$currency="COP";
$test="1";
$buyerEmail="test2x@test2x.com";
$responseUrl = $RESPONSEUrl;
$confirmationUrl = $CONFIRMATIONUrl;


function saveDataByReference($reference, $data){
  global $items,$cantidad,$con;
  $res=0;
  $con->autocommit(FALSE);
  try{
    $sql = "INSERT INTO pagos(referenceCode,estado) VALUES ('".$reference."',10);";
    if($con->query($sql)){
        foreach($data as $id => $unidades){
            $sql2 = "INSERT INTO pagoproducto(id,reference,unidades) VALUES (".$id.",'".$reference."',".$unidades.");";
            if(!$con->query($sql2)){throw new Exception("error");}
        }
    }else{
        throw new Exception("error");
    }
    $con->commit();
  }catch (Exception $e){
      $con->rollback();
      $res=1;
  }
  $con->autocommit(TRUE);
  return array('error' => $res);
}



function getUniqueID($data){
  $UUID=uniqid();
  return "SBPrueba".$UUID.hash('crc32', $data)."TestPayU";
}
?>
