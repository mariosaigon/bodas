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

            <div class="box-footer">
            

            	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
               Añadir nueva categoría <i class="fa fa-plus"></i>
              </button>


         		 <p></p>
            </div>

          </div>
          <!-- /.box -->


        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Añadiendo nueva categoría de bebida</h4>
              </div>
              <div class="modal-body">

            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre</label>

                  <div class="col-sm-8">
                    <input type="nombre" class="form-control" id="nombre" placeholder="Nombre de la categoría">
                  </div>
                </div>



                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Margen de Ganancia Bruta (%) para 100 invitados</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="mgb100" name="mgb100" placeholder="Ingrese margen de ganancia bruta para prorrateo para un aproximado de 100 personas">
                  </div>
                </div>


                 <div class="form-group">
                  <label for="mgb150" class="col-sm-4 control-label">Margen de Ganancia Bruta (%) para más de 150 invitados</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control"  id="mgb150" name="mgb150" placeholder="MGB para prorrateo para un aproximado de 150 o más personas">
                  </div>
                </div>

              </div>

              <!-- /.box-footer -->
            </form>
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

          

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
