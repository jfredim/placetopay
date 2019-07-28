<?php
include 'vars.php';
include "php/conexion.php";

//-----------------------------------------------------
// Get data
//-----------------------------------------------------
	$user_id=null;
	$sql1= "select * from orders where id = ".$_GET["id"];
	$query = $con->query($sql1);
	$orders = null;
	if($query->num_rows>0){
	while ($r=$query->fetch_array()){
  		$orders=$r;
  		break;
	}

  }
	

//-----------------------------------------------------
// generate and save sale reference
//-----------------------------------------------------

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

$tranKey = base64_encode(sha1($nonceBase64 . $seed . $login, true));

echo "trankey: $tranKey<br>";
echo "seed: $seed<br>";
echo "nonce: $nonceBase64<br>";


$saveResponse=saveDataByReference($orders->customer_email,$orders);
//-----------------------------------------------------
// generate texts
//-----------------------------------------------------
if ($saveResponse['error']!=1) {
  $messageSale="Hola! Esta es la descripción de tu compra. Si es correcta, puedes continuar el proceso.";
}else {
  $messageSale="Se ha producido un error, es posible que alguno de los elementos ya no este disponible.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet"  href="hola.css" />
  <title></title>
</head>
<body class="ltr">
  <div id="logo">
      <a href="index.php">
        <img class="" src="https://i0.wp.com/independientesantafe.com/wp-content/uploads/2016/02/cropped-Santa-Fe-escudo-2016.png?fit=240%2C240">
        <span>Tienda del león</span>
      </a>
    </div>

    <div id="menu">
      <a class="home-link" href="index.php">Inicio</a>
    </div>
  <p><?php print($messageSale); ?></p>
  <h3>Descripción</h3>
  <table>
    <tr>
      <th>item</th>
      <th>cantidad</th>
      <th>valor</th>
    </tr>
    <?php
    $precioTotal=0;
    foreach($datos as $id => $unidades){
      $product=getItemById($id);
    ?>
    <tr>
      <td><?php print( $product['name']);?></td>
      <td><?php print( $unidades); ?></td>
      <td><?php print(($unidades*$product['precio'])); ?></td>
    </tr>
    <?php
    $precioTotal+=($unidades*$product['precio']);
    }
     ?>
    <tr>
      <th>TOTAL</th>
      <th></th>
      <th><?php print($precioTotal); ?></th>
    </tr>
  </table>
  <?php if ($saveResponse['error']!=1) { ?>
  <form method="post" action="<?php print($postUrl) ?>">
    <input name="merchantId"    type="hidden"  value="<?php print($merchantId)?>"   >
    <input name="accountId"     type="hidden"  value="<?php print($accountId)?>" >
    <input name="description"   type="hidden"  value="<?php print($description)?>"  >
    <input name="referenceCode" type="hidden"  value="<?php print($referenceCode)?>" >
    <input name="amount"        type="hidden"  value="<?php print($precioTotal)?>"   >
    <input name="tax"           type="hidden"  value="<?php print($tax); ?>"  >
    <input name="taxReturnBase" type="hidden"  value="<?php print($taxReturnBase); ?>" >
    <input name="currency"      type="hidden"  value="<?php print($currency)?>" >
    <input name="signature"     type="hidden"  value="<?php print(md5($apiKey."~".$merchantId."~".$referenceCode."~".$precioTotal."~".$currency))?>"  >
    <input name="test"          type="hidden"  value="<?php print($test); ?>">
    <input name="buyerEmail"    type="hidden"  value="<?php print($buyerEmail); ?>" >
    <input name="responseUrl"    type="hidden"  value="<?php print($responseUrl); ?>" >
    <input name="confirmationUrl"    type="hidden"  value="<?php print($confirmationUrl); ?>" >
    <input name="Submit" class="button" type="submit"  value="Enviar" >
  </form>
  <?php } ?>
</body>
</html>
