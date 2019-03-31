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

class SeedDMS_View_CalculaPrecios extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Calculadora del precio de tus servicios Signature Events", "skin-blue sidebar-mini sidebar-collapse");
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
  
 $this->startBoxPrimary("Cotice su evento con Signature Events");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="form-group">
                  <label for="invitados">Indique el número de invitados</label>
                  <input type="number" class="form-control" id="invitados"  name="invitados" placeholder="Ingrese un número">
</div>

<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Calcula los mejores precios con Signature Events!</a></li>
            
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Para mi evento, quiero: (seleccione)</b>


                 <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input id="pastel" name="pastel" type="checkbox">
                      Pastel
                    </label>
                  </div>               
                 </div>


                 <div id="consoPastel" style="display: none;">
                
                	<h4>Precio total por el pastel: </h4>
                	<p id="preciopastel"></p>	
                	<img src="../pastel.jpg" alt="Pastel" height="170" width="130">	

                	<h3>Signature Events le regala: decoración mesa de postres. </h3>		      					
				</div>







				<div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input id="sweet" name="sweet" type="checkbox">
                      Sweet Pack
                    </label>
                  </div>               
                 </div>


                 <div id="consoSweet" style="display: none;">
                
                	<h4>Precio total por el Sweet Pack: </h4>
                	<p id="preciosweet"></p>	
                	<img src="../sweet.jpg" alt="Sweet Pack" height="160" width="120">	

                	<h3>Signature Events le regala: decoración mesa de Sweet Pack. </h3>		      					
				</div>






                 <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input id="postres" name="postres" type="checkbox">
                      Mesa de Postres
                    </label>
                  </div>               
                 </div>

                 <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input id="barra" name="barra" type="checkbox">
                      Barra Libre
                    </label>
                  </div>               
                 </div>


               




              <!-- /.tab-pane -->
             
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

      </div>

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
		echo '<script src="../calculadora.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>
