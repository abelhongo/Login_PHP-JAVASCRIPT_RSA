<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro de Usuario</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<script src="js/jquery-3.2.1.min.js" ></script>
	<script src="js/jsencrypt.min.js"></script>
	<script src="js/main.js" ></script>

</head>
<body>

	<?php
			/****************************************************************************/
			/***********************    Generar llaves RSA    ***************************/
			/****************************************************************************/
			//Establecemos la configuración de las llaves
    		$configuracion_llaves = array(
			    "digest_alg" => "sha512", //Establecemos el digest que vamos a usar
			    "private_key_bits" => 2048,
			    "private_key_type" => OPENSSL_KEYTYPE_RSA
			);

			$configuracion_firmas = array(
			    "countryName" => "CR",
			    "stateOrProvinceName" => "Alajuela",
			    "localityName" => "Alajuela",
			    "organizationName" => "Sede Interuniversitaria de Alajuela",
			    "organizationalUnitName" => "Unidad de Gestión e Innovación Tecnológica",
			    "commonName" => "UGIT",
			    "emailAddress" => "interuniversitaria de Alajuela"
			);


    		// Generar una nueva pareja de clave privada y pública
			$llaves=openssl_pkey_new($configuracion_llaves);

			// Solicitamos la firma del certificado con una confirguracion
			$certificado_firmado = openssl_csr_new($configuracion_firmas, $llaves);

			//para hacer el certificado auto firmado (certificado_firmado,ente certificador NUll= autofirmado,llaves, tiempo de vigencia en dias)
			$sscert = openssl_csr_sign($certificado_firmado, null, $llaves, 1);


			//Obtenemos la llave privada
			openssl_pkey_export($llaves, $llave_privada);



			//Obtenemos la llave publica
			//Obtenemos los detalles de la llave
			$llave_publica=openssl_pkey_get_details($llaves);
			//Obtenemos especificamente la llave publica
			$llave_publica=$llave_publica["key"];


			/****************************************************************************/
			/***********************   Creamos la session     ***************************/
			/****************************************************************************/
			//Creamos una session para guardar la llave privada
			session_start();
			$_SESSION['llave_privada'] = $llave_privada;


    ?>
    <!-- *********************************************************** -->
    <!-- ***********Campo oculto que almacena la llave publica ***** -->
    <!-- *********************************************************** -->
    <input type="hidden" name="llave_publica" id="llave_publica" value="<?=$llave_publica?>">
    <input type="hidden" name="llave_privada" id="llave_privada" value="<?=$llave_privada?>">
    <input type="hidden" name="pass_ecriptado" id="pass_ecriptado" value="">

    <div id="result"></div>
	<div class="error">
		<span>Datos de Ingreso no válidos, intentelo de nuevo!</span>
	</div>
	<div class="exito">
		<span>Se ha registrado correctamente!</span>
	</div>
	<div class="main">
		<form action="" id="formlg">
			<input type="text" name="usuariolg" id="usuariolg" placeholder="Usuario" required pattern="[A-Za-z0-9_-]{1,15}" value="gmatamor">
			<input type="text" name="passlg" id="passlg" placeholder="Contraseña" required value="12345">
			<input type="submit" class="botonlg" value="Registrar">
		</form>
	</div>
</body>
</html>
