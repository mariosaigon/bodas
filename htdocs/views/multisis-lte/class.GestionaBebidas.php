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

class SeedDMS_View_GestionaBebidas extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Gestion de precios de bebidas", "skin-blue sidebar-mini sidebar-collapse");
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
  
 $this->startBoxPrimary("Gestionar las bebidas de la Barra Libre");
$this->contentContainerStart();
//////INICIO MI CODIGO

 //////FIN MI CODIGO                 

?>
 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Categorías de bebidas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre</th>
                  <th>%MGB a 100 invitados</th>
                  <th>%MGB a 150 invitados</th>            
                </tr>
               </thead>
               <tbody>
                	<?php
                	//$numEventos=contarUbicaciones($dms);
                	//////////////// DIBUJO TABLA
                	$consultar = "SELECT * FROM categorias_bebidas;";
					//echo "Consultar: ".$consultar;
				  	$res1 = $db->getResultArray($consultar);
                	for($cont=0;$cont<$numEventos;$cont++)
                	{
                		echo ' <tr>';
                		//1. nombre
                       echo "<td><a href=\"#\" id=\"telefono\" data-type=\"text\" data-pk=\"$idProveedor\" data-url=\"../modificarProveedor.php\" data-title=\"telefono\">".$res1[$cont]['nombre']."</a></td>";

                       echo "<td><a href=\"#\" id=\"telefono\" data-type=\"text\" data-pk=\"$idProveedor\" data-url=\"../modificarProveedor.php\" data-title=\"telefono\">".$res1[$cont]['mgb100']."</a></td>";

                       echo "<td><a href=\"#\" id=\"telefono\" data-type=\"text\" data-pk=\"$idProveedor\" data-url=\"../modificarProveedor.php\" data-title=\"telefono\">".$res1[$cont]['mgb150']."</a></td>";
		           
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
