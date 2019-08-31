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
function imprimeBebidas($idCategoria)
{
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
    echo "imprimeBebidas.php: Error: no se pudo conectar a la BD";
	exit;
  } 
  /////////////// CONTEO DE INACCIONES
  $bebidas="SELECT * FROM bebida WHERE categoria=$idCategoria;";
  $resultado1=$manejador->getResultArray($bebidas);
 echo '<table class="table table-bordered" border="1">';
 echo '<tr>
    <th>Bebida</th>
    <th>Foto</th>
    <th>¡Lo quiero en mi evento!</th>
  </tr>';

  foreach ($resultado1 as $bebi) 
  {
  	$idBebi=$bebi['id'];
  	$rutaFoto="../../images/bebidas/$idCategoria/$idBebi".".jpg";
  	echo '<tr>';
  	echo "<td width=\"40%\" style=\"font-family:helvetica;font-size:160%;text-align:center;color:blue;\"><b>".$bebi['nombre']."</b></td>";
  	echo "<td width=\"20%\" >"."<img src=\"$rutaFoto\" alt=\"Foto del guaro\" class=\"img-responsive\">"."</td>";
  	$idBebida="bebida-".$idBebi;
  	echo "<td width=\"20%\" >".'<div class="form-group">
                  <div class="checkbox">
                    <label>';
                      echo "<input type=\"checkbox\" value=\"$idBebi\" id=\"$idBebida\">";
                      
                    echo '</label></div>'."</td>";
  	echo '</tr>';
  }

echo '</table>';

}
class SeedDMS_View_Calcula extends SeedDMS_Bootstrap_Style 
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
		$this->htmlAddHeader('<script type="text/javascript" src="../../styles/'.$this->theme.'/dist/adminlte/js/adminlte.min.js"></script>');
		$this->htmlAddHeader('<script type="text/javascript" src="../../styles/'.$this->theme.'/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>');
		$this->htmlStartPage("Cotiza tu barra libre", "skin-blue sidebar-mini sidebar-collapse");
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
  
 $this->startBoxPrimary("Cotiza la mejor Barra Libre de El Salvador para tus eventos!");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
 <h2 class="page-header">¡Arma tu barra libre! <i class="fa fa-glass"></i> </h2>

      <div class="row">
        <div class="col-md-8">
          <div class="box box-solid">
            <div class="box-header with-border">
              


              <div class="input-group">
                
                
              </div>


              <div id="contenedorInvitados" class="form-group ">
                  <label class="control-label" for="inputInvis"><i class="fa fa-user"></i> Cantidad de invitados a tu evento</label>
                 <input type="number" id="cantidadInvitados" name="cantidadInvitados" class="form-control" placeholder="Indique una cantidad...">
                  
                </div>

            </div>
            <!-- /.box-header -->
            <h3 class="box-title">Selecciona cuales bebidas quieres de cada variedad:</h3>
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Ron
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                      <?php 

                      		imprimeBebidas(1);
                      ?>
                    </div>
                  </div>
                </div>
                <div class="panel box box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Vodka
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                     <?php 

                      		imprimeBebidas(3);
                      ?>
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Tequila
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="box-body">
                      <?php 

                      		imprimeBebidas(2);
                      ?>
                    </div>
                  </div>
                </div>


                 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#whiskey">
                        Whiskey
                      </a>
                    </h4>
                  </div>
                  <div id="whiskey" class="panel-collapse collapse">
                    <div class="box-body">
                      <?php 

                      		imprimeBebidas(4);
                      ?>
                    </div>
                  </div>
                </div>


                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#gin">
                        Gin
                      </a>
                    </h4>
                  </div>
                  <div id="gin" class="panel-collapse collapse">
                    <div class="box-body">
                     <?php 

                      		imprimeBebidas(5);
                      ?>
                    </div>
                  </div>
                </div>



                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#vino">
                        Vino
                      </a>
                    </h4>
                  </div>
                  <div id="vino" class="panel-collapse collapse">
                    <div class="box-body">
                      <?php 

                      		imprimeBebidas(6);
                      ?>
                    </div>
                  </div>
                </div>

                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#jager">
                        Jägermeister
                      </a>
                    </h4>
                  </div>
                  <div id="jager" class="panel-collapse collapse">
                    <div class="box-body">
                      <?php 

                      		imprimeBebidas(7);
                      ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2">
       
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- END ACCORDION & CAROUSEL-->

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
		echo "<script type='text/javascript'  src='scriptBarra.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
