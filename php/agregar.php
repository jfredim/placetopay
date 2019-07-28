<?php

if(!empty($_POST)){
	if(isset($_POST["customer_name"]) &&isset($_POST["customer_email"]) &&isset($_POST["customer_movil"]) && $_POST["action"] == 'ingresar' ){
			include "conexion.php";
			$status='CREATED';
			$sql = "insert into orders(customer_name,customer_email,customer_movil,status,created_at,updated_at) value (\"$_POST[customer_name]\",\"$_POST[customer_email]\",\"$_POST[customer_movil]\",\"$status\",NOW(),'')";
			$query = $con->query($sql);
			if($query!=null){
				print "Agregado exitosamente.";
			}else{
				print "No se pudo agregar.";

			}
	}
	
	if($_POST["action"] == 'actualizar' && isset($_POST['status']) ){
			include "conexion.php";
			$status='CREATED';
			$sql = "insert into orders(customer_name,customer_email,customer_movil,status,created_at,updated_at) value (\"$_POST[customer_name]\",\"$_POST[customer_email]\",\"$_POST[customer_movil]\",\"$status\",NOW(),'')";
			$query = $con->query($sql);
			if($query!=null){
				print "Agregado exitosamente.";
			}else{
				print "No se pudo agregar.";

			}
	}
}



?>