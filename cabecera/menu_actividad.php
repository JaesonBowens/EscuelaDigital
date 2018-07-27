<?php
	function menuActividad($descripcion){
		echo '
			<nav class="menu-actividad">
				<ul id="menu">
					<li id="informacion-texto"><img src="../../imagen/icon/ejemplo.png" title="Description of the Activity" /></li>
					<li id="informacion-video"><img src="../../imagen/icon/video-descripcion.png" title="Video of the description of the Activity" /></li>
					<li id="informacion-lenguaje-signo"><img src="../../imagen/icono_boton/ib-18.png" title="Video of the description of the Activity using sign language" /></li>
					
				</ul>
			</nav>

			<section class="tutorial">
				<video controls="controls" width="300" height="200" id="act-video" class="video">

				</video>

				<section class="guia">
					<p>'.$descripcion.'</p>
				</section>

				<img src="#" class="lenguaje_sena_img" hidden />
				
			</section>
		';
	}
?>
