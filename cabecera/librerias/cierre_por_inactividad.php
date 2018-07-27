<?php

	function cierrePorInactividad($link){
		$minunos  = 10;
		$segundos = $minunos * 60;
		
		if( ( $_SESSION['tiempo'] + $segundos ) < time()) {
			echo 	"<script>
						var id_usuario = ".$_SESSION["ses_id_usuario"].";

						$.ajax({
							url: '../../controlador/usuario.php',
							type: 'POST',
							async: true,
							dataType: 'json',
							data: 'consultar='+id_usuario,
							success: function(dato){
								comprobarClave1( dato.usuario[0], dato.usuario[1],  3);
							}
						});

						function comprobarClave1( nombre_usuario, clave_usuario,  cont){
							alertify.promptpassword('Your session has been expired for inactivity<br/><br/><b>User:</b> '+nombre_usuario+'<br/><br/>Enter your password:', function(c, clave){
								if( c && clave == clave_usuario ){
									".$_SESSION['tiempo']=time().";
								}
								else if( c && cont != 1 ){
									cont--;
									if( cont == 2 ){
										alertify.error('Incorrect password.<br>You have '+ cont + ' atempts left');
									}
									else{
										alertify.error('Incorrect password.<br>You have '+ cont + ' atempts left');
									}
									
									comprobarClave1( nombre_usuario, clave_usuario,  cont);
								}
								else if( c && cont == 1 ){
									alertify.confirmsuccess('You have exceeded the limit of atempts<br/><br/> Your session is going to end for security reasons', function(c){
										if(c){
											window.location.href = '".$link."';
										}
										else{
											window.location.href = '".$link."';
										}
									});
								}
								else{
									alertify.confirmsuccess('Your session is going to end for security reasons', function(c){
										if(c){
											window.location.href = '".$link."';
										}
										else{
											window.location.href = '".$link."';
										}
									});
								}
							});
						}
					</script>";			

			return false;
		}
		else{
		   $_SESSION['tiempo']=time();

		   return true;
		}
	}
?>
