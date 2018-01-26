/************************************************************/
/**************** Funcion onload ****************************/
/************************************************************/
window.onload = function() {
  $(".error").hide();
  $(".exito").hide();
};


function encripta_rsa_contrasena(dato_a_encriptar){
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey($('#llave_publica').val());
    var dato_encriptado = encrypt.encrypt(dato_a_encriptar);

	return dato_encriptado;
}

/************************************************************/
/**************   evento submit      ************************/
/************************************************************/
jQuery(document).on('submit','#formlg',function(event){
	//Evitamos el funcinamiento normal de boton
	event.preventDefault();

	//Obtenemos los datos a enviar
	var usuario = document.getElementById('usuariolg').value;
	var pass = document.getElementById('passlg').value;
	var password_encriptado = encripta_rsa_contrasena(pass);


	//Creamos un formData para el envio de los datos
	var formData = new FormData();
	formData.append('usuario', usuario);
	formData.append('pass', password_encriptado);



	var ajax = new XMLHttpRequest();
	ajax.open('POST', 'Main_app/registrar.php', true);
	ajax.onreadystatechange = function(e) {
	  if (this.readyState == 4 && this.status == 200) {
	    alert(this.responseText);
	  }
	};

	ajax.send(formData);


/*	jQuery.ajax({
	  url: 'Main_app/login.php',
	  type: 'POST',
	  dataType: 'json',
	  data: $(this).serialize(), //Le mandamos el el formulario codificado en notacion URL
	  beforeSend: function(){
	  	$('.botonlg').val('Validando...');
	  }
	})
	.done(function(respuesta){
		console.log(respuesta);
		//Si se obtuvieron datos
		if(!respuesta.error){
			if(respuesta.tipo=="Admin"){
				location.href="Main_app/Admin/";
			}else if(respuesta.tipo=="Usuario"){
				location.href="Main_app/Usuario/";
			}
		}else{
			$('.error').slideDown('slow');
			setTimeout(function(){
				$('.botonlg').val("Iniciar Sessión");
				$(".error").hide();
			},2000);
		}
	})
	.fail(function(respuesta){
		console.log(respuesta.responseType);
	})
	.always(function(){
		//console.log("completado");
	});*/


});
