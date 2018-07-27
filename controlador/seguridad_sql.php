<?php
	function antiInjectionSql($dato){
		/*$dato = htmlentities($dato);
		$dato =	utf8_encode($dato);
		$dato = htmlspecialchars($dato);
		$dato = stripcslashes($dato);
		$dato = mysql_real_escape_string($dato);*/
		
		return $dato;
	}
?>
