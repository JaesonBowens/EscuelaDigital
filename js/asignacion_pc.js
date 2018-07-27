$(document).ready(function(){
	//Desactivo el sombreado y seleccion de .seleccion
	$(document).on(".seleccion").disableSelection();
	
	$(".seleccion").on("taphold", function(){
		var id_estudiante = $(this).find("td").eq(0).find("input[name='id_estudiante']").val();

		seleccion(id_estudiante);
	});

	$(".seleccion").dblclick(function(){
		var id_estudiante = $(this).find("td").eq(0).find("input[name='id_estudiante']").val();

		seleccion(id_estudiante);
	});

	function seleccion(id_estudiante){
		var cont = 0;
		var id = new Array();

		$("#asig-contenido tr").each(function(){
			var checked = $(this).find("td").eq(0).find("input[name='seleccion']").is(':checked');
			 
			if(checked){
				id[cont] = $(this).find("td").eq(0).find("input[name='seleccion']").val();
				cont++;
			}
		});

		if(cont != 0){
			var dato = {
				contenido : id
			};

			$.ajax({
				url: '../controlador/asignacion_pc.php',
				type: 'POST',
				dataType: 'json',
				data: "comprobarActividad="+JSON.stringify(dato),
				success: function(data){
					if( data.resultado == "YES" ){
						window.location = "../controlador/asignacion_pc.php?id_estudiante="+id_estudiante+"&&contenido="+JSON.stringify(dato);
					}
					else{
						alertify.error(data.msj);
					}
				},
				error: function(){
					alertify.error("Error");
				}
			});					
		}
		else{
			alertify.error("Please select themes for the Activities!");
		}
	}

	$("#seleccion-todo").click(function(){
		var checked = comprobarSeleccion();
		
		if(!checked){
			seleccionarTodo();
		}
		else{
			deseleccionarTodo();
		}
	});
});

function comprobarSeleccion(){
	var resul = true;

	$("#asig-contenido tr").each(function(){
		var checked = $(this).find("td").eq(0).find("input[name='seleccion']").is(':checked');
		
		if(!checked){
			resul = false;
		}
	});
	
	return resul;
}

function seleccionarTodo(){
	$("#asig-contenido tr").each(function(){
		$(this).find("td").eq(0).find("input[name='seleccion']").prop("checked", true);
	});
}

function deseleccionarTodo(){
	$("#asig-contenido tr").each(function(){
		$(this).find("td").eq(0).find("input[name='seleccion']").prop("checked", false);
	});
}
