<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors","1");



include("php/conexion.php");



$user_id=null;
$sql1= "select * from orders where 1 ";
$query2 = $con->query($sql1);
$datos = array();
while ($row = mysqli_fetch_array($query2)):
	array_push($datos,$row);
endwhile;

$sql13= "select * from orders where status = 'CREATED' ";
$query3 = $con->query($sql13);
$datos2 = array();
while ($row = mysqli_fetch_array($query3)):
	array_push($datos2,$row);
endwhile;


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

?>


<html>
	<head>
		<!-- scripts     -->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/ionicons@4.1.1/dist/css/ionicons.min.css">



		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet"
		    type="text/css">
		<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/ionicons@^4.0.0/dist/css/ionicons.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/@mdi/font@^2.0.0/css/materialdesignicons.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/animate.css@^3.5.2/animate.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/quasar-framework@0.17.8/dist/umd/quasar.mat.min.css" rel="stylesheet"
		    type="text/css">
		<title>TIENDA JF</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
	<div id="root">
	<?php include "php/navbar.php"; ?>
	<div class="container">
	<div class="row">
	<div class="col-md-12">
			<h2>TIENDA JF {{ nombre }}</h2>
			<p class="lead">En esta tienda se pueden Crear Transacciones, Pagar y Eliminar</p>
			<p>Instrucciones:</p>
			<ol>
				<li>Ir a la opcion ver.</li>
				<li>Agregar elementos desde el boton agregar.</li>
				<li>Seleccionar el boton Editar de cualquier elemento.</li>
				<li>Seleccionar el boton Eliminar de cualquier elemento.</li>
			</ol>
			<br>
			
			<form>
				<input v-model="nombre" class="form-control" placeholder="Nombre Persona"/>
				<br>
				<input type="email" v-model="email" class="form-control"  placeholder="Email" />
				<br>
				<input type="number" v-model="movil" class="form-control" placeholder=" Numero Telefono"/>
				<br>
				<button type="button" class="btn btn-success" @click="enviar()">Grabar</button>
			</form>
			
			<table class="table table-bordered table-dark">
				<thead>
					<tr style="color:#2f03fc ">
						
							<td>id</td>
							<td>nombre</td>
							<td>email</td>
							<td>Movil</td>
							<td>ESTADO</td>
							<td>Opciones de Pago</td>
						
					</tr>
				</thead>
				<tbody>
				
							<?php 
							foreach ($datos as $value){?>
							<tr>
								<td><?php echo $value['id'];?> </td>
								<td><?php echo $value['customer_name'];?></td>
								<td><?php echo $value['customer_email'];?></td>
								<td><?php echo $value['customer_movil'];?></td>
								<td><?php echo $value['status'];?></td>
								<td>
                                    <button type="button" v-if="'<?php echo $value['status'];?>' != 'CREATED'" class="btn btn-primery" @click="actualizar('<?php echo $value['id'];?>','<?php echo $value['customer_name'];?>','<?php echo $value['customer_email'];?>','<?php echo $value['customer_movil'];?>','CREATED')">CREATED</button>
									<button type="button" v-if="'<?php echo $value['status'];?>' != 'REJECT'" class="btn btn-danger" @click="actualizar('<?php echo $value['id'];?>','<?php echo $value['customer_name'];?>','<?php echo $value['customer_email'];?>','<?php echo $value['customer_movil'];?>','REJECT')">REJECT</button>
									
								</td>
							</tr>
							<?php }?>
							
					
				</tbody>
			</table>
			
	<button type="button" class="btn btn-success" @click="pagardeuda('<?php echo $login;?>','<?php echo $tranKey;?>','<?php echo $nonce;?>','<?php echo $seed;?>')">IR PAGAR</button>
	</div>
	</div>
	</div>
	</div>
    <!--  scripts     -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar-framework@0.17.8/dist/umd/quasar.ie.polyfills.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@latest/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar-framework@0.17.8/dist/umd/quasar.mat.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar-framework@0.17.8/dist/umd/i18n.pt-br.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar-framework@0.17.8/dist/umd/icons.fontawesome.umd.min.js"></script>



    <!--  control VUE -->
    <script type="text/javascript">
    new Vue({
        el: "#root",
        data: function() {
            return {
            	arrays: [] ,
            	nombre: '',
            	movil:'',
            	email: '',
            	pagar: [],
            	pin: ''
            	
			}
        },
        mounted: function() {
        	this.auht();
        	this.pagar = JSON.parse('<?php echo json_encode($datos2); ?>');
        },
        methods: {
        	enviar: function(){
				$.post( "php/agregar.php", 
					{	
						"locale": "es_CO",
	  					'customer_name': this.nombre,
	  					'customer_email': this.email,
	  					'customer_movil' : this.movil,
	  					'action': 'ingresar'
					}
				).done(function( data ) {
			  	alert(data);
			    location.reload();
			  });
			},
			auht: function(){
					this.pin = data.pin;
			},
			actualizar: function(id,name,email,movil,status){
				

				$.post( "php/actualizar.php", 
					{	
						"locale": "es_CO",
	  					'id': id,
	  					'customer_name': name,
	  					'customer_email': email,
	  					'customer_movil' : movil,
	  					'status' : status,
	  					'action': 'actualizar'
					}
				).done(function( data ) {
			  	alert(status);
			    location.reload();
			  });
			},

				
			pagardeuda: function(login,trankey,nonce,seed){
				
				
				var array2 = [];
				array2.push(
					{
						"auth": {
						    "login": login,
						    "tranKey": trankey,
						    "nonce": nonce,
						    "seed":seed
	    				},
	    				"user": { 
							'ciudad': 'medellin',
							'pais': 'colombia',
							'object': this.pagar 
						}
					}
					
				);
				console.log(array2);
			}
        }

    });
    </script>
	</body>
</html>