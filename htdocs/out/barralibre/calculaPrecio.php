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
 $estadistica=$_GET["estadistica"];

  /////////////// CONTEO DE INACCIONES
	//DOCUMENT CATEGORIES:
 //1-Comisionado (exento de comisión) 
 //2 -Comisiones 

 //a nivel de form:
 // 1- oe
 //2- muni
 // 3- exentos de comision (comisionados)

 // EN RESUMEN: obtener id de documentos de todos los comisionados:
 // SELECT id FROM tblDocuments INNER JOIN tblDocumentCategory ON documentID = id AND tblDocumentCategory.categoryID=1 ;
 //de todas las comisiones:
 //SELECT id FROM tblDocuments INNER JOIN tblDocumentCategory ON documentID = id AND tblDocumentCategory.categoryID=2;
$consulta="";

 if($estadistica==1) //Comisiones de instituciones del Gobierno Central
 {
	$consulta="SELECT folder FROM  tblFolderAttributes WHERE value='Pública';";
 }
 if($estadistica==2) //Comisiones de municipalidades
 {
$consulta="SELECT folder FROM  tblFolderAttributes WHERE value='Municipalidad';";
 }


///// la fecha parametro es de la autoridad de la comision
// $fechaInicioComision=$dms->getAttributeDefinitionByName("Autoridad Propietario Fecha Inicio");
// $fechaFinComision=$dms->getAttributeDefinitionByName("Autoridad Propietario Fecha Fin");


 $resultado=$manejador->getResultArray($consulta);
  $elMero=array(); // el array que devuelvo por cada entrada de la tabla tiene la forma: [INstitucion,contador]
	  foreach($resultado as $id)
	  {
	  	$contador=0;
	  	$idoc=$id['folder'];
	  	$folder=$dms->getFolder($idoc);
	  	//$meraFecha=$doc->getAttributeValue($fechaInicioComision);
	  	$aux=array();
	  	
	  	$conteo=$folder->countChildren($user,0);
	  	$conteoTotal=$conteo['document_count'];
	  	if($conteoTotal==0)
	  	{	
	  		$nombreCarpeta=$folder->getName();
	  		array_push($aux, $nombreCarpeta);
	  		array_push($elMero, $aux);
	  	}
	  
	  	
		  //array_push($elMero,$r);	  	  	  
	  	  //echo "fecha inicio comision: ".$doc->getAttributeValue($fechaInicioComision);
	  	
	  }
  ///////////////////////////// FINALIZAMOS
  echo json_encode($elMero);

?>