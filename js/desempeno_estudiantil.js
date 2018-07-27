$(document).ready(function(){

			$("#reporte").click(function(){
				var id_ano_escolar = $("#id_ano_escolar_rep").val();
				var id_seccion = $("#id_seccion_rep").val();
				var id_area = $("#id_area_rep").val();
				var id_actividad = $("#id_actividad_rep").val();

				var fecha, fecha_consultar;

				if ( $('input[name="por_fecha"]').is(':checked') ) {
    					fecha = $("#fecha_consultar").val();
				} else {
    					fecha = " ";
				}

				if(fecha == " "){
						fecha_consultar = "00/00/00";
				}else{
						fecha_consultar = fecha;
				}
				console.log('hola');
				/*if(cedula != ""){
					$("#reporte").attr("hidden", false);	
					$("#link_reporte").attr("href", "../controlador/reporte_desempeno_estudiantil.php?cedula_escolar_rep="+cedula+"&&id_ano_escolar_rep="+id_ano_escolar+"&&id_seccion_rep="+id_seccion+"&&id_area_rep="+id_area+"&&id_actividad_rep="+id_actividad+"&&fecha_consultar="+fecha_consultar);
				}
				else{
					$("#link_reporte").attr("href", "#");
					alert("Enter the students Ingrese la cédula escolar del estudiante a consultar!");
				}*/
			});

			$(".id-est").on('click', function(this){
				alert(this);
    			seleccionFilaCat(this);
			});

			$('input[name="por_fecha"]').on('click', function(){
    			if ( $(this).is(':checked') ) {
        			$('span[name="area_fecha"]').show();
							$('input[name="fecha_consultar"]').prop('disabled', false);
							$( '.botoncal' ).css({
   									opacity: 1,
    									pointerEvents: 'auto'
							})
    			} 
    			else {
        			$('span[name="area_fecha"]').hide();
							$('input[name="fecha_consultar"]').prop('disabled', true);
    			}
			});

			$("#id_area_rep").change(function(){

					var id_area_rep = $(this).val();

					alert(id_area_rep);

					if( id_area_rep != ""){
							$.ajax({
									url: "../cabecera/campos_de_seleccion/actividad.php",
									type: "POST",
									async: true,
									dataType: "json",
									data: "consultarIdAreaReporte="+$(this).val(),
									success: cargarActividad
							});
					}else{
							$("#id_actividad_rep option").remove();

							var option = "<option value=''>";
							option    += "SELECT";
							option    += "</option>";

							$("#id_actividad_rep").append(option);
					}
			});

});

function cargarActividad(dato){

	$("#id_actividad_rep option").remove();

	var option = "<option value=''>";
	option    += "SELECT";
	option    += "</option>";

	$("#id_actividad_rep").append(option);

	for(var i = 0; i<dato.length; i++){
		
			//Creamos el option
			var option = "<option value='"+dato[i].id_actividad+"'>";
			option    += dato[i].nombre_actividad;
			option    += "</option>";

			$("#id_actividad_rep").append(option);
		
	}
}
