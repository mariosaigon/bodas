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
 function imprimirEstados()
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
  $resultado=array("Planificado","Iniciado","Completado");
  ////////////////////// EL SELECT
  echo ' <select class="form-control chzn-select"  name="estado"  id="estado"  data-placeholder="Selecciona una categoría de estado..."  required>';
  echo "<option disabled  selected value>Selecciona una</option>";
  foreach ($resultado as $a) 
  {
       echo "<option value=\"".$a,"\">".$a."</option>";
  }

  echo "</select>";
}// fin de imprimir departamentos
 function convertirFecha($fecha) //convierte una fecha en formato año-mes-dia a dia-mes-añño
{
$newDate = date("d-m-Y", strtotime($fecha));
return  $newDate;
}
 function contarHitos($idEvento,$dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT COUNT(*) FROM hitos_eventos WHERE id_evento=$idEvento";
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
        <?php echo "<li><a href=\"out.VerEvento.php?id=$idEvento\"> Tracking del evento $nombreEvento </a></li>"; ?>
        <li class="active">Ver hitos de este evento</li>
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
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">Agregar nuevo hito</button>
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

                	$numEventos=contarHitos($idEvento,$dms);
					//echo "Consultar: ".$consultar;
				  	
                	for($cont=0;$cont<$numEventos;$cont++)
                	{
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[$cont]['id'];
                		 echo "<td><a href=\"#\" id=\"nombre_hito\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarHito.php\" data-title=\"Funciones ejercidas\">".$res1[$cont]['nombre_hito']."</a></td>";
                		 //2. fecha de inicio a fin
                		 echo "<td><a href=\"#\" id=\"deadline\" data-type=\"combodate\" data-pk=\"$idItem\" data-url=\"../modificarHito.php\" data-title=\"deadline\">".$res1[$cont]['deadline']."</a></td>";
                		  // 3. lugar
                		echo "<td><a href=\"#\" id=\"estado\" data-type=\"select\" data-pk=\"$idItem\" data-url=\"../modificarHito.php\" data-source=\"{'Planificado': 'Planificado', 'Iniciado': 'Iniciado', 'Completado': 'Completado'}\" >".$res1[$cont]['estado']."</a></td>";
                		  // 4. enlace para editar
                      echo "<td><a href=\"#\" id=\"comentario\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarHito.php\" data-title=\"Comentario\">".$res1[$cont]['comentario']."</a></td>";
                		  //$idEvento=$res1[$cont]['id'];
                		 echo "<td><a href=\"#\" id=\"link_anexos\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarHito.php\" data-title=\"Comentario\">".$res1[$cont]['link_anexos']."</a></td>";


                     echo ' </tr>';
		           
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



     <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Añadiendo nuevo hito.</h4>
              </div>
              <div class="modal-body">
              <p>Aquí deberán añadirse aquellos hitos importantes para el tracking, por ejemplo, contacto con proveedores, reuniones de seguimiento, etc.</p>
                   <div class="col-md-12">
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Incluir la siguiente información...</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioGrupo" id="formularioGrupo" action="out.HitoAnadido.php" method="POST" enctype="multipart/form-data">
        <?php  echo "<input type=\"hidden\" name=\"idEvento\" id=\"idEvento\" value=\"$idEvento\"></input>"; ?>
              <div class="box-body">

                <div class="form-group">
                  <label for="nombre" class="col-sm-2 control-label">Nombre del hito</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre2" name="nombre2" placeholder="por ejemplo reunión inicial  ..." required>
                  </div>
                </div>
                          

                <div class="form-group">
                  <label for="estado" class="col-sm-2 control-label">Estado del hito</label>

                  <div class="col-sm-10">
                   <?php imprimirEstados(); ?>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="deadline2" class="col-sm-2 control-label">Deadline</label>

                  <div class="col-sm-10">
                    <input type="date"  class="form-control" id="deadline2" name="deadline2" placeholder="Seleccionar de calendario  ..." required>
                  </div>

                </div> 

                <div class="form-group">
                  <label for="comentario" class="col-sm-2 control-label">Comentario</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="comentario2" name="comentario2" placeholder="Un comentario sobre el mismo  ..." required>
                  </div>

                </div> 


                 <div class="form-group">
                  <label for="link" class="col-sm-2 control-label">Link a carpeta</label>

                  <div class="col-sm-10">
                    <input type="number" min="1" class="form-control" id="link" name="link" placeholder="Link a Google Drive o carpeta en este sistema  ..." >
                  </div>

                </div> 



                </div> 






              <!-- /.box-body -->
              <div class="box-footer">
                
                
              </div>
              <!-- /.box-footer -->
            
          </div>

        </div> <!-- FIN DE COLUMNA 2 -->
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default">Borrar campos</button>
                <button type="submit" class="btn btn-success pull-right">Crear hito a este evento</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
          </form>
        </div>
        <!-- /.modal -->

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
    echo "<script type='text/javascript' src='../modificarPerfil.js'></script>";
     echo "<script type=\"text/javascript\" src=\"../styles/".$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
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
