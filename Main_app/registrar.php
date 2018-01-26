<?php 

	$usu = $_POST['usuario'];
	$pass = $_POST['pass'];
	
	session_start();
	$llave_privada = trim($_SESSION['llave_privada']);


 	$res = openssl_pkey_get_private($llave_privada);
 	//echo $llave_privada;
	//echo $encriptado = base64_encode(pack('H*',$pass));	
	//echo $encriptado = base64_decode($pass);

	openssl_private_decrypt(base64_decode($pass), $texto_desencriptado, $res);
	echo "RESULTADO: ".$texto_desencriptado;
	openssl_free_key($res);
?>