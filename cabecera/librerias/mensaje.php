<?php
	class CabeceraMensaje{
		public $mensaje;

		function mostrarMensaje(){
			echo "<script>alertify.alert('".$this->mensaje."')</script>";
		}

		function mostrarMensaje1(){
			echo "<script>
					".$this->mensaje.";
					setTimeout(function(){
						$.unblockUI();
					}, 3000);
					</script>";
		}
	}
?>
