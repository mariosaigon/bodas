<?php  

include("../../inc/inc.Settings.php");
include("../../inc/inc.LogInit.php");
include("../../inc/inc.Utils.php");
include("../../inc/inc.Language.php");
include("../../inc/inc.Init.php");
include("../../inc/inc.Extension.php");
include("../../inc/inc.DBInit.php");
include("../../inc/inc.ClassUI.php");


$settings = new Settings(); //acceder a parámetros de settings.xml con _antes
$driver=$settings->_dbDriver;
$host=$settings->_dbHostname;
$user=$settings->_dbUser;
$pass=$settings->_dbPass;
$base=$settings->_dbDatabase;
$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
  $estado=$manejador->connect();
  //echo "Conectado: ".$estado;
  if($estado!=1)
  {
    echo "consultaDatos.php: Error: no se pudo conectar a la BD";
	exit;
  } 
  $arrayBebidas=array();
 $bebis=$_GET["bebidas"];
 $cantidadInvitados=$_GET["invitados"];

$baseTragos=3; //es el famoso 3 que se mete en la calculadora

$arrayBebidas = explode(",",$bebis);
 $elMero=array(); // el array que devuelvo por cada entrada de la tabla tiene la forma: [INstitucion,contador]
 /////////777 ESTE BUCLE ES SOLO PARA MEDIR LAS PROBABILIDADES DE LA CATEGORIA
 $sumaProbabilidad=0;
	  foreach($arrayBebidas as $idBebida)
	  {
	  	$consultaCategoria="SELECT categoria FROM  bebida WHERE id=$idBebida;";
	  	
	  	$resultado1=$manejador->getResultArray($consultaCategoria);
	  	$catego=$resultado1[0]['categoria'];
	  	//1-CALCULO DE LA PROBABILDIAD
	  	//1.1-Probabilidad de categoría
	  	$consultaProbabilidad="SELECT probabilidad FROM  categoria_bebida WHERE id=$catego;";
	  	$resultado2=$manejador->getResultArray($consultaProbabilidad);
	  	$probabilidad=$resultado2[0]['probabilidad'];
	  	//echo "Probabiliudad de bebida; ".$probabilidad;
	  	$sumaProbabilidad=$sumaProbabilidad+$probabilidad;
	  		
	  	// $conteo=$folder->countChildren($user,0);
	  	// $conteoTotal=$conteo['document_count'];
	  	// if($conteoTotal==0)
	  	// {	
	  	// 	$nombreCarpeta=$folder->getName();
	  	// 	array_push($aux, $nombreCarpeta);
	  	// 	array_push($elMero, $aux);
	  	// }	  	
		  //array_push($elMero,$r);	  	  	  
	  	  //echo "fecha inicio comision: ".$doc->getAttributeValue($fechaInicioComision);
	  	
	  }

	  ///////// bucle 2: Sacar nueva distribucion, precio por ml, cantidad de tragos por persona y precio
	  // OBJETIVO: Sacar el precio final con margen de ganancia de cada bebida
	   foreach($arrayBebidas as $idBebida)
	  {
	  	$consultaCategoria="SELECT categoria FROM  bebida WHERE id=$idBebida;";
	  	
	  	$resultado1=$manejador->getResultArray($consultaCategoria);
	  	$catego=$resultado1[0]['categoria'];
	  	//1-CALCULO DE LA PROBABILDIAD
	  	//1.1-Probabilidad de categoría
	  	$consultaProbabilidad="SELECT probabilidad FROM  categoria_bebida WHERE id=$catego;";
	  	$resultado2=$manejador->getResultArray($consultaProbabilidad);
	  	$probabilidad=$resultado2[0]['probabilidad'];
	  	//echo "Probabiliudad de bebida; ".$probabilidad;
	  	//echo "Suma de probabilidad; ".$sumaProbabilidad;
	  	$nuevaDistribucion=$probabilidad/$sumaProbabilidad;
	  	//sacar cantidad y precio de botella
	  	$consultaCantidad="SELECT cantidad_botella FROM  bebida WHERE id=$idBebida;";
	  	$consultaPrecio="SELECT precio_botella FROM  bebida WHERE id=$idBebida;";

	  	//echo "Consulta precio: ".$consultaPrecio;

	  	$resultado3=$manejador->getResultArray($consultaCantidad);
	  	$resultado4=$manejador->getResultArray($consultaPrecio);
	  	$cantidadBotella=$resultado3[0]['cantidad_botella'];
	  	$precioBotella=$resultado4[0]['precio_botella'];
	  	//echo "Cantidad botella: ".$cantidadBotella;
	  	//echo "Precio notella: ".$precioBotella;
	  	$precioMl=$precioBotella/$cantidadBotella;
	  	//calculo tragos por persona
	  	$tragosPersona=$baseTragos*$nuevaDistribucion;
	  	 	//echo "La nueva distribucion es: ".$nuevaDistribucion."<br>";
	  	//ml por trago
	  	$consultaMl="SELECT mlxtrago FROM  bebida WHERE id=$idBebida;";
	  	$resultado5=$manejador->getResultArray($consultaMl);
	  	$mlTrago=$resultado5[0]['mlxtrago'];
	  	//calculo precio
	  	$precioCosto=$precioMl*$tragosPersona*$mlTrago;

	  	//echo "El precio ML del  trago es: ".$precioMl."<br>";
	  	//echo "El pnumero de tragos por persona es: ".$tragosPersona."<br>";
	  	//echo "El pnumero de ml por trago es: ".$mlTrago."<br>";
	  	//echo "El precio costo del trago es: ".$precioCosto."<br>";
	  	//traigo margenes de ganancia
	  	$consultaMg100="SELECT mgb100 FROM  categoria_bebida WHERE id=$catego;";
	  	$resultado6=$manejador->getResultArray($consultaMg100);
	  	$Mgb100=$resultado6[0]['mgb100'];
	  	// 150 o mas personas
	  	$consultaMg150="SELECT mgb150 FROM  categoria_bebida WHERE id=$catego;";
	  	$resultado7=$manejador->getResultArray($consultaMg150);
	  	$Mgb150=$resultado7[0]['mgb150'];	
	  	$precioFinalTrago=0; //el magico
	  	if($cantidadInvitados<150)
	  	{
	  		$precioFinalTrago=($Mgb100/100)*$precioCosto;
	  	}
	  	if($cantidadInvitados>=150)
	  	{
	  		$precioFinalTrago=($Mgb150/100)*$precioCosto;
	  	}
	  	$precioFinalTrago=round($precioFinalTrago,2);
	  	$consultaNombre="SELECT nombre FROM  bebida WHERE id=$idBebida;";
	  	$resultado8=$manejador->getResultArray($consultaNombre);
	  	$nombreTrago=$resultado8[0]['nombre'];	


	 	//echo "El precio final del trago  ".$nombreTrago." es ".$precioFinalTrago;
	 	$aux=array();
	 	array_push($aux, $nombreTrago);
	 	array_push($aux, $precioFinalTrago);
	 	array_push($elMero,$aux);	  

	 }
	  	// $conteo=$folder->countChildren($user,0);
	  	// $conteoTotal=$conteo['document_count'];
	  	// if($conteoTotal==0)
	  	// {	
	  	// 	$nombreCarpeta=$folder->getName();
	  	// 	array_push($aux, $nombreCarpeta);
	  	// 	array_push($elMero, $aux);
	  	// }	  	
		  //array_push($elMero,$r);	  	  	  
	  	  //echo "fecha inicio comision: ".$doc->getAttributeValue($fechaInicioComision);
	  	
	  //echo "Suma de probabilidades; ".$sumaProbabilidad;
  ///////////////////////////// FINALIZAMOS
  echo json_encode($elMero);

?>