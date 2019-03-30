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
 function convertirFecha($fecha) //convierte una fecha en formato año-mes-dia a dia-mes-añño
{
$newDate = date("d-m-Y", strtotime($fecha));
return  $newDate;
}
 function contarHitos($dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT COUNT(*) FROM hitos_eventos;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		return $res1[0]['COUNT(*)'];
	 }

	  function dameEventos($dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT * FROM app_evento;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		return $res1[0]['COUNT(*)'];
	 }
class SeedDMS_View_VerHitos extends SeedDMS_Bootstrap_Style 
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
    $idEvento = $this->params['idEvento'];
    $nombreEvento = $this->params['nombreEvento'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
    $consultar = "SELECT * FROM hitos_eventos;";
      $res1 = $db->getResultArray($consultar);
		$this->htmlStartPage("Lista de hitos del evento $nombreEvento", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
		  <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="out.GestionarItems.php"> Gestionar evntos</a></li>
        <li class="active">Ver eventos</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Listado de hitos del evento <b>$nombreEvento</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<button type="button" class="btn  btn-success btn-lg">Agregar nuevo hito</button>
 <div class="box">

            <div class="box-header">
              <h3 class="box-title">Haga clic en el nombre del elemento para editarlo</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre del hito</th>
                  <th>deadline</th>
                  <th>Estado</th>
                  <th>Comentario</th>
                  <th>Link a carpeta con anexos</th>           
                </tr>
               </thead>
               <tbody>
                	<?php
                	
                	//////////////// DIBUJO TABLA

                	$numEventos=contarHitos($dms);
					//echo "Consultar: ".$consultar;
				  	
                	for($cont=0;$cont<$numEventos;$cont++)
                	{
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[$cont]['id'];
                		 echo "<td>".$res1[$cont]['nombre_hito']."</a></td>";
                		 //2. fecha de inicio a fin
                		 echo "<td>".$res1[$cont]['deadline']."</td>";
                		  // 3. lugar
                		  echo "<td>".$res1[$cont]['estado']."</td>";
                		  // 4. enlace para editar
                      echo "<td>".$res1[$cont]['comentario']."</td>";
                		  //$idEvento=$res1[$cont]['id'];
                		 echo "<td>".$res1[$cont]['link_anexos']."</td>";

		           
                	}                                
                ?>
            </tbody>
              <tfoot>
              </tfoot>
                

               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

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
		//echo "<script type='text/javascript' src='/formularioSubida.js'></script>";
		echo '<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
        echo '<script src="../styles/multisis-lte/plugins/sorting/moment.min.js"></script>';
        echo '<script src="../styles/multisis-lte/plugins/sorting/datetime-moment.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/jquery-knob/js/jquery.knob.js"></script>';
		echo '<script src="../tablasDinamicas.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>
