<?php
/**
 * Implementation of MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx> DMS with modifications of José Mario López Leiva
 * @copyright  Copyright (C) 2017 José Mario López Leiva
 *             marioleiva2011@gmail.com    
 				San Salvador, El Salvador, Central America

 *             
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");


/**
 * Include class to preview documents
 */
require_once("SeedDMS/Preview.php");



/**
 * Class which outputs the html page for MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
 /**
 Función que muestra los documentos próximos a caducar de todos los usuarios
 mostrarTodosDocumentos(lista_usuarios,dias)
 -dias: documentos que van a caducar dentro de cúantos días
 */
function imprimirUbicaciones()
{
  //LOS DEPARTAMENTOS LEIDOS DE LA BD
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
    echo "out.AnadePersona.php[]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT nombre,id FROM app_ubicacion;";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  $arrayDepartamentos=$resultado[0]['nombre'];
  ////////////////////// EL SELECT
  echo ' <select class="form-control chzn-select"  name="ubicacion[]"  id="ubicacion" multiple="multiple" data-placeholder="Seleccione una o varias ubicaciones..."  >';
  echo "<option disabled  value>Seleccione una ubicación donde se va a guardar</option>";
  foreach ($resultado as $a) 
  {
       echo "<option value=\"".$a['id']."\">".$a['nombre']."</option>";
  }

  echo "</select>";
}// fin de imprimir departamentos

function imprimeProyectos()
{
  //LOS DEPARTAMENTOS LEIDOS DE LA BD
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
    echo "out.AnadeItem.php[]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT nombre,id FROM app_ubicacion;";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  $arrayDepartamentos=$resultado[0]['nombre'];
  ////////////////////// EL SELECT
  echo ' <select class="form-control chzn-select"  name="proyecto"  id="proyecto"  data-placeholder="Seleccione un proyecto..."  >';
  echo "<option disabled  value>Seleccione el proyecto que financia compra</option>";
  foreach ($resultado as $a) 
  {
       echo "<option value=\"".$a['id']."\">".$a['nombre']."</option>";
  }

  echo "</select>";
}// fin de imprimir departamentos
class SeedDMS_View_AnadeProyecto extends SeedDMS_Bootstrap_Style 
{
 /**
 Método que muestra los documentos próximos a caducar sólo de 
 **/
	function show() 
	{ /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$orderby = $this->params['orderby'];
		$showInProcess = $this->params['showinprocess'];
		$cachedir = $this->params['cachedir'];
		$workflowmode = $this->params['workflowmode'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Añadir proyecto a la base ", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
         <ol class="breadcrumb">
        <li><a href="/out/out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="/out/out.GestionarItems.php"> Gestionar proyectos</a></li>
        <li class="active">Añadir proyecto</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Añadir proyecto nuevo");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<!-- ***************** UNA FILA TRES COLUMNAS *********************-->
<div class="row">
        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 1 -->

        <div class="col-md-6">
        		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Datos del proyecto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioProyecto" id="formularioProyecto" action="../out/out.ProcesarProyecto.php" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="nombreItem" class="col-sm-2 control-label">Nombre del proyecto</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto" placeholder="por ejemplo Consolidación de la ENAFOP  ..." required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="nombreItem" class="col-sm-2 control-label">Origen de los fondos</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="origenFondos" name="origenFondos" placeholder="por ejemplo AECID..." required>
                  </div>
                </div>
                          
                 <div class="form-group">
                  <label for="descripcion" class="col-sm-2 control-label">Código SETEFE</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="codigoSetefe" name="codigoSetefe" placeholder="por ejemplo 27777 ..." required>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="empresa" class="col-sm-2 control-label">Monto total del proyecto</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="montoTotal" name="montoTotal" placeholder="en USD por ejemplo 150000  ..." required>
                  </div>

                </div> 

                <div class="form-group">
                  <label for="costo" class="col-sm-2 control-label">Fecha de finalización del proyecto</label>

                  
                        <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="fechaFin" id="fechaFin" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>   

                </div> 

                <div class="form-group">
                  <label for="costoCompra" class="col-sm-2 control-label">Monto total dentro del proyecto para bienes (activos fijos)</label>

                  <div class="col-sm-10">
                    <input type="number" step=".01" class="form-control" id="montoBienes" name="montoBienes" placeholder="por ejemplo $1000  ..." required>
                  </div>

                </div> 


                <div class="form-group">
                  <label for="origen" class="col-sm-2 control-label">Monto total dentro del proyecto para adquirir materiales (de trabajo y divulgativos)</label>

                   <div class="col-sm-10">
                    <input type="number" step=".01" class="form-control" id="montoMateriales" name="montoMateriales" placeholder="por ejemplo $1000  ..." required>
                  </div>

                </div> 

                </div> 






              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Borrar campos</button>
                <button type="submit" class="btn btn-info pull-right">Agregar proyecto</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>




        </div> <!-- FIN DE COLUMNA 2 -->


        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 3 -->
</div> <!-- FIN DE FILA -->


<?php
 //////FIN MI CODIGO                 
$this->contentContainerEnd();


$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>

		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
