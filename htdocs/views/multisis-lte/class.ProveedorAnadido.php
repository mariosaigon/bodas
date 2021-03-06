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

class SeedDMS_View_ProveedorAnadido extends SeedDMS_Bootstrap_Style 
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

		$nombre_proveedor = $this->params['nombre_proveedor'];
		$descripcion_proveedor = $this->params['descripcion_proveedor'];
		$monto_cobrar = $this->params['monto_cobrar'];
		$nombreEvento = $this->params['nombreEvento'];
		$idEvento = $this->params['idEvento'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Proveedor añadido al evento $nombreEvento", "skin-blue sidebar-mini");
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
  
 $this->startBoxPrimary("Proveedor añadido exitosamente");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-bullhorn"></i>

              <h3 class="box-title">Proveedor añadido con éxito</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
              <div class="callout callout-success">
                <h4>Resumen del proveedor creado:</h4>

				 <ul>
				 	 <li><?php echo "Nombre: ".$nombre_proveedor."para el evento ".$nombreEvento; ?></li>
				   <li><?php echo "Descripcion: ".$descripcion_proveedor?></li>
				   <li><?php echo "Monto a pagar: ".$monto_cobrar?></li>
				 
				</ul>
		     </div>
            </div>
            <!-- /.box-body -->

              <?php echo "<a href=\"out.VerProveedores.php?evento=$idEvento\"><b>Retornar a la lista de provedores del evento</b></a>"; ?>
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
		$this->htmlEndPage();
	} /* }}} */
}
?>
