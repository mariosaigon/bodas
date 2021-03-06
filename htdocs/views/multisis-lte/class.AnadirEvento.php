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
function imprimirTipos()
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
    echo "out.AnadirEvento.php[]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT nombre,id FROM tipos_eventos;";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  $arrayDepartamentos=$resultado[0]['nombre'];
  ////////////////////// EL SELECT
  echo ' <select class="form-control chzn-select"  name="tipo"  id="tipo"  data-placeholder="Selecciona una categoría de evento..."  required>';
  echo "<option disabled  selected value>Selecciona una</option>";
  foreach ($resultado as $a) 
  {
       echo "<option value=\"".$a['id']."\">".$a['nombre']."</option>";
  }

  echo "</select>";
}// fin de imprimir departamentos
class SeedDMS_View_AnadirEvento extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Añadiendo evento", "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Datos básicos del evento");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="row">
        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 1 -->

        <div class="col-md-6">
        		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">El inicio de una experiencia inolvidable...</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioGrupo" id="formularioGrupo" action="out.EventoAnadido.php" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="nombre" class="col-sm-2 control-label">Nombre</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="por ejemplo Boda María y Pepe  ..." required>
                  </div>
                </div>
                          
                 <div class="form-group">
                  <label for="descripcion" class="col-sm-2 control-label">Tipo</label>

                  <div class="col-sm-10">
                   <?php imprimirTipos(); ?>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Breve resumen del evento  ..." required>
                  </div>

                </div> 

                <div class="form-group">
                  <label for="fecha" class="col-sm-2 control-label">Fecha</label>

                  <div class="col-sm-10">
                    <input type="date"  class="form-control" id="fecha" name="fecha" placeholder="Seleccionar de calendario  ..." required>
                  </div>

                </div> 

                <div class="form-group">
                  <label for="lugar" class="col-sm-2 control-label">Lugar</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lugar" name="lugar" placeholder="Ubicación del evento  ..." required>
                  </div>

                </div> 


                 <div class="form-group">
                  <label for="cantidad" class="col-sm-2 control-label">Cantidad de invitados</label>

                  <div class="col-sm-10">
                    <input type="number" min="1" class="form-control" id="invitados" name="invitados" placeholder="Cantidad de invitados  ..." required>
                  </div>

                </div> 



                </div> 






              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Borrar campos</button>
                <button type="submit" class="btn btn-info pull-right">Crear evento</button>
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
