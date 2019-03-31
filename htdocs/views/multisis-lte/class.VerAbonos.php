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
 function contarAbonos($dms,$idEvento,$idProveedor)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT COUNT(*) FROM abonos_proveedor WHERE id_evento=$idEvento AND id_proveedor=$idProveedor";
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
class SeedDMS_View_VerAbonos extends SeedDMS_Bootstrap_Style 
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
     $idProveedor = $this->params['idProveedor'];
    $nombreEvento = $this->params['nombreEvento'];
    $nombreProveedor = $this->params['nombreProveedor'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
    $consultar = "SELECT * FROM abonos_proveedor WHERE id_evento=$idEvento AND id_proveedor=$idProveedor";
    //echo "consultar todo: ".$consultar;
    $res1 = $db->getResultArray($consultar);

		$this->htmlStartPage("Lista de proveedores del evento $nombreEvento", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
		  <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <?php echo "<li><a href=\"out.VerEvento.php?id=$idEvento\"> Tracking del evento $nombreEvento </a></li>"; ?>
          <?php echo "<li><a href=\"out.VerProveedores.php?evento=$idEvento\"> Gestión de proveedores </a></li>"; ?>
        <li class="active">Ver abonos a este proveedor</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Listado de abonos al proveedor <b>$nombreProveedor</b> en el evento <b>$nombreEvento</b>");
$this->contentContainerStart();

//////INICIO MI CODIGO
//TOTAL 
$consultar2 = "SELECT * FROM abonos_proveedor WHERE id_evento=$idEvento AND id_proveedor=$idProveedor";
    //echo "consultar todo: ".$consultar;
    $res12 = $db->getResultArray($consultar2);

?>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">Agregar nuevo abono a este proveedor</button>
 <div class="box">

            <div class="box-header">
              <h3 class="box-title">Haga clic en el nombre del elemento para editarlo</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Monto abonado (dólares)</th>
                  <th>Fecha</th>
                  <th>Comentario</th>
                          
                </tr>
               </thead>
               <tbody>
                	<?php
                	
                	//////////////// DIBUJO TABLA

                	$numEventos=contarAbonos($dms,$idEvento,$idProveedor);
					//echo "Consultar: ".$consultar;
				  	
                	for($cont=0;$cont<$numEventos;$cont++)
                	{
                		echo ' <tr>';
                		//1. nombre
                    $idProveedor=$res1[$cont]['id'];
                		 echo "<td><a href=\"#\" id=\"monto\" data-type=\"number\" data-pk=\"$idProveedor\" data-url=\"../modificarAbono.php\" data-title=\"monto\">".$res1[$cont]['monto']."</a></td>";
                	
                	
                      echo "<td><a href=\"#\" id=\"fecha\" data-type=\"combodate\" data-pk=\"$idProveedor\" data-url=\"../modificarAbono.php\" data-title=\"fecha\">".$res1[$cont]['fecha']."</a></td>";
                		  //$idEvento=$res1[$cont]['id'];
                		 echo "<td><a href=\"#\" id=\"comentario\" data-type=\"text\" data-pk=\"$idProveedor\" data-url=\"../modificarAbono.php\" data-title=\"comentario\">".$res1[$cont]['comentario']."</a></td>";


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
                <h4 class="modal-title">Añadiendo nuevo abono a proveedor.</h4>
              </div>
              <div class="modal-body">
              <p>Aquí deberán añadirse aquellos abonos que se hacen a este proveedor.</p>
                   <div class="col-md-12">
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Incluir la siguiente información...</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioGrupo" id="formularioGrupo" action="out.AbonoAnadido.php" method="POST" enctype="multipart/form-data">
        <?php  echo "<input type=\"hidden\" name=\"nombreEvento\" id=\"nombreEvento\" value=\"$nombreEvento\"></input>"; 
        echo "<input type=\"hidden\" name=\"idEvento\" id=\"idEvento\" value=\"$idEvento\"></input>";
        echo "<input type=\"hidden\" name=\"nombreProveedor\" id=\"nombreProveedor\" value=\"$nombreProveedor\"></input>";
        echo "<input type=\"hidden\" name=\"idProveedor\" id=\"idProveedor\" value=\"$idProveedor\"></input>";
        ?>
              <div class="box-body">

                <div class="form-group">
                  <label for="monto_abonar" class="col-sm-2 control-label">Monto a abonar</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="monto_abonar" name="monto_abonar" placeholder="por ejemplo 20 dólares ..." required>
                  </div>
                </div>
                          

                <div class="form-group">
                  <label for="fecha_pago" class="col-sm-2 control-label">Fecha del pago</label>

                  <div class="col-sm-10">
                   <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" placeholder="Seleccione del calendario la fecha del pago  ..." required>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="descripcion_pago" class="col-sm-2 control-label">Descripción</label>

                  <div class="col-sm-10">
                    <input type="text"  class="form-control" id="descripcion_pago" name="descripcion_pago" placeholder="Ingresar un comentario   ..." required>
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
                <button type="submit" class="btn btn-success pull-right">Registrar este abono</button>
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
