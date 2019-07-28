<?php

error_reporting(E_ALL);
ini_set("display_errors","1");

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