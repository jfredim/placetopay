<?php
include "conexion.php";



$user_id=null;
$sql1= "select * from orders where id = ".$_GET["id"];
$query = $con->query($sql1);
$orders = null;
if($query->num_rows>0){
while ($r=$query->fetch_object()){
  $orders=$r;
  break;
}

  }
?>

<?php if($orders!=null):?>

<form role="form" method="post" action="php/actualizar.php">
  <div class="form-group">
    <label for="customer_name">Nombre</label>
    <input type="text" class="form-control" value="<?php echo $orders->customer_name; ?>" name="customer_name" required>
  </div>
  <div class="form-group">
    <label for="customer_email">Email</label>
    <input type="email" class="form-control" value="<?php echo $orders->customer_email; ?>" name="customer_email" required>
  </div>
  <div class="form-group">
    <label for="customer_movil">Movil</label>
    <input type="text" class="form-control" value="<?php echo $orders->customer_movil; ?>" name="customer_movil" required>
  </div>
  <div class="form-group">
    <label for="email">Estado</label>
    <input type="text" class="form-control"  readonly="" value="<?php echo $orders->status; ?>" name="status" >
  </div>
<input type="hidden" name="id" value="<?php echo $orders->id; ?>">
  <button type="submit" class="btn btn-default">Actualizar</button>
</form>
<?php else:?>
  <p class="alert alert-danger">404 No se encuentra</p>
<?php endif;?>