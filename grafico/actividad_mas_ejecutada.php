<?php 

require_once ('../jpgraph/src/jpgraph.php');
//require_once ('../jpgraph/src/jpgraph_bar.php');
  
require_once ('../jpgraph/src/jpgraph_pie.php');   
require_once ('../jpgraph/src/jpgraph_pie3d.php'); 

include("../modelo/conexion_bd.php");

$conexion_bd = new conexionBD;
$conexion_bd->conexion();

$sql = "SELECT act.nombre_actividad AS nom, COUNT( * ) AS contador FROM actividad AS act JOIN prueba AS pba USING(id_actividad) GROUP BY act.nombre_actividad;";
			
$resul = mysql_query($sql);

if(!$resul){
	$_SESSION['actividad_ejecutada'] = true;
}

$conexion_bd->cerrar_conexion();

$data = array();
$legends = array();

$i = 0;

while($fila = mysql_fetch_array($resul)){

    $data[$i] =  $fila["contador"];
    
    if($fila["nom"] == 'SELECT THE IMAGES WHOOSE FIRST LETTER IS EQUAL TO THE INDICATED'){

       $legends[$i] =  'IMGS WHOOSE 1ST LETTER IS EQUAL TO THE INDICATED';

    }else if($fila["nom"] == 'WRITE THE FIRST LETTER OF THE OBJECT'){

       $legends[$i] =  'WRITE THE FIRST LETTER';

    }else if($fila["nom"] == 'FIND THE IMAGES WITH THE MOST OBJECTS'){

       $legends[$i] =  'THE IMG WITH THE MOST OBJECTS';

    }else if($fila["nom"] == 'COMPLETE THE SEQUENCE OF NUMBERS'){

       $legends[$i] =  'SEQUENCE OF NUMBERS';

    }else if($fila["nom"] == 'SELECT THE IMAGE THAT´S ASSOCIATED TO THE WORD'){

       $legends[$i] =  'IMAGE ASSOCIATED TO THE WORD';

    }else{

	$legends[$i] =  utf8_decode($fila["nom"]);
    }
    $i++;
 
}
 
// Creating a new graphic   
  $graph = new PieGraph(600, 450);   
  $graph->SetShadow();   
  
  // Naming the graphic  
  $graph->title->Set(utf8_decode('Actividades más ejecutadas'));   
  $graph->title->SetFont(FF_FONT2, FS_BOLD, 14);   
  
  // Legend positioning (%/100)   
  $graph->legend->Pos(0.05, 0.1, 'right', 'top');
  $graph->legend->SetFillColor('lightblue');
  $graph->legend->SetLineSpacing(10);
  $graph->legend->SetLineWeight(2);
  $graph->legend->SetFrameWeight(2);

  if($i > 6){ 
  
	$graph->legend->SetColumns(2); 

  } else{

	$graph->legend->SetColumns(2); 

  }
  
  // Creating a 3D pie graphic   
  $p1 = new PiePlot3d($data);   
  
  // Setting the graphic center (%/100)   
  $p1->SetCenter(0.5, 0.68);   
  
  // Setting the ancle   
  $p1->SetAngle(30);   
  
  // Choosing the type   
  $p1->value->SetFont(FF_FONT1, FS_NORMAL, 10);   
  
  // Setting legends for graphic segments  
  $p1->SetLegends($legends);   
  
  // Adding the diagram to the graphic  
  
  $graph->Add($p1);   
  // Showing graphic 
 
  // Display the graph
  $graph->Stroke();
?>
