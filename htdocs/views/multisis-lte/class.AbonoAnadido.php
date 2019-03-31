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

class SeedDMS_View_AbonoAnadido extends SeedDMS_Bootstrap_Style 
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

		$nombreProveedor = $this->params['nombreProveedor'];
		$nombreEvento = $this->params['nombreEvento'];
		$descripcion_proveedor = $this->params['descripcion_proveedor'];
		$monto = $this->params['monto'];
		$fecha = $this->params['fecha'];
		$idEvento = $this->params['idEvento'];
		$idProveedor = $this->params['idProveedor'];
		$comentario = $this->params['comentario'];
		$nombreEvento = $this->params['nombreEvento'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Abono añadido al proveedor  $nombreProveedor en el evento $nombreEvento", "skin-blue sidebar-mini");
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

              <h3 class="box-title">Abono registrado con éxito</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
              <div class="callout callout-success">
                <h4>Resumen del abono registrado:</h4>

				 <ul>
				 	 <li><?php echo "Monto abonado: ".$monto; ?></li>
				   <li><?php echo "Fecha del pago:  ".$fecha?></li>
				   <li><?php echo "Comentario: ".$comentario?></li>
				 
				</ul>
		     </div>
            </div>
            <!-- /.box-body -->

            <?php echo "<a href=\"out.VerAbonos.php?evento=$idEvento&proveedor=$idProveedor\"><b>Retornar a la lista de abonos del proveedor del evento</b></a>"; ?>
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
