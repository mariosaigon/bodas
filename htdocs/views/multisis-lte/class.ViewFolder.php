<?php
/**
 * Implementation of ViewFolder view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
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
 * Class which outputs the html page for ViewFolder view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
 function contarEventos($dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT COUNT(*) FROM app_evento;";
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

function contarItems($fechaInicio,$fechaFin) //le puedo pasar "postulado " o "aprobado"
//me da el conteo de cuantos postulados o aprobados hay entre fecha inicio y fecha fin
{
	//echo "funcion fechaInicio: ".$fechaInicio;
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error en consulta base de datos estadísitcas de items entregados","ViewFolders: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT sum(cantidad_variada) FROM app_transaccion WHERE tipo_transaccion=1 AND (fecha between '$fechaInicio' and '$fechaFin');";
	//echo "i quer_;".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);
	$contador=$resultado[0]['sum(cantidad_variada)'];
	if(!$resultado)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo ejecutar $miQuery");
	}
	//echo "Contados: ".$contador;
    return intval($contador);
}	 
class SeedDMS_View_ViewFolder extends SeedDMS_Bootstrap_Style {
	function getAccessModeText($defMode) { /* {{{ */
		switch($defMode) {
			case M_NONE:
				return getMLText("access_mode_none");
				break;
			case M_READ:
				return getMLText("access_mode_read");
				break;
			case M_READWRITE:
				return getMLText("access_mode_readwrite");
				break;
			case M_ALL:
				return getMLText("access_mode_all");
				break;
		}
	} /* }}} */
	function printAccessList($obj) { /* {{{ */
		$accessList = $obj->getAccessList();
		if (count($accessList["users"]) == 0 && count($accessList["groups"]) == 0)
			return;
		$content = '';
		for ($i = 0; $i < count($accessList["groups"]); $i++)
		{
			$group = $accessList["groups"][$i]->getGroup();
			$accesstext = $this->getAccessModeText($accessList["groups"][$i]->getMode());
			$content .= $accesstext.": ".htmlspecialchars($group->getName());
			if ($i+1 < count($accessList["groups"]) || count($accessList["users"]) > 0)
				$content .= "<br />";
		}
		for ($i = 0; $i < count($accessList["users"]); $i++)
		{
			$user = $accessList["users"][$i]->getUser();
			$accesstext = $this->getAccessModeText($accessList["users"][$i]->getMode());
			$content .= $accesstext.": ".htmlspecialchars($user->getFullName());
			if ($i+1 < count($accessList["users"]))
				$content .= "<br />";
		}
		if(count($accessList["groups"]) + count($accessList["users"]) > 3) {
			$this->printPopupBox(getMLText('list_access_rights'), $content);
		} else {
			echo $content;
		}
	} /* }}} */
	function js() { /* {{{ */
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$orderby = $this->params['orderby'];
		$expandFolderTree = $this->params['expandFolderTree'];
		$enableDropUpload = $this->params['enableDropUpload'];
		header('Content-Type: application/javascript; charset=UTF-8');
		parent::jsTranslations(array('cancel', 'splash_move_document', 'confirm_move_document', 'move_document', 'splash_move_folder', 'confirm_move_folder', 'move_folder'));
		
?>

function folderSelected(id, name) {
	window.location = '../out/out.ViewFolder.php?folderid=' + id;
}

function checkForm() {
	msg = new Array();
	/*if (document.form1.name.value == "") msg.push("<?php printMLText("js_no_name");?>");*/
	if (document.form1.comment.value == "") msg.push("<?php printMLText("js_no_comment");?>");
	if (msg != "") {
  	noty({
  		text: msg.join('<br />'),
  		type: 'error',
      dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaultTheme',
			_timeout: 1500,
  	});
		return false;
	}
	else
		return true;
}

function checkForm2() {
	msg = new Array();
	/*if (document.form2.name.value == "") msg.push("<?php printMLText("js_no_name");?>");*/
	if (document.form2.comment.value == "") msg.push("<?php printMLText("js_no_comment");?>");
	/*if (document.form2.expdate.value == "") msg.push("<?php printMLText("js_no_expdate");?>");*/
	if (document.form2.theuserfile.value == "") msg.push("<?php printMLText("js_no_file");?>");
	if (msg != "") {
  	noty({
  		text: msg.join('<br />'),
  		type: 'error',
      dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaultTheme',
			_timeout: 1500,
  	});
		return false;
	}
	else
		return true;
}

$(document).ajaxStart(function() { Pace.restart(); });
//  $('.ajax').click(function(){
//    $.ajax({url: '#', success: function(result){
//    $('.ajax-content').html('<hr>Ajax Request Completed !');
//  }});
//});

$(document).ready(function(){
	
	$('body').on('submit', '#form1', function(ev){
		if(!checkForm()) {
			ev.preventDefault();
		} else {
			$("#box-form1").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
		}
	});

	$('body').on('submit', '#form2', function(ev){
		if(!checkForm2()){
			ev.preventDefault();
		} else {
			$("#box-form2").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
		}
	});

	$("#form1").validate({
		invalidHandler: function(e, validator) {
			noty({
				text:  (validator.numberOfInvalids() == 1) ? "<?php printMLText("js_form_error");?>".replace('#', validator.numberOfInvalids()) : "<?php printMLText("js_form_errors");?>".replace('#', validator.numberOfInvalids()),
				type: 'error',
				dismissQueue: true,
				layout: 'topRight',
				theme: 'defaultTheme',
				timeout: 1500,
			});
		},
		messages: {
			name: "<?php printMLText("js_no_name");?>",
			comment: "<?php printMLText("js_no_comment");?>"
		},
	});

	$("#form2").validate({
		invalidHandler: function(e, validator) {
			noty({
				text:  (validator.numberOfInvalids() == 1) ? "<?php printMLText("js_form_error");?>".replace('#', validator.numberOfInvalids()) : "<?php printMLText("js_form_errors");?>".replace('#', validator.numberOfInvalids()),
				type: 'error',
				dismissQueue: true,
				layout: 'topRight',
				theme: 'defaultTheme',
				timeout: 1500,
			});
		},
		messages: {
			name: "<?php printMLText("js_no_name");?>",
			comment: "<?php printMLText("js_no_comment");?>",
			/*expdate: "<?php printMLText("js_no_expdate");?>",*/
			theuserfile: "<?php printMLText("js_no_file");?>",
		},
	});

	$("#add-folder").on("click", function(){
 		  $("#div-add-folder").show('slow');
  });

  $("#cancel-add-folder").on("click", function(){
 		  $("#div-add-folder").hide('slow');
  });

  $("#add-document").on("click", function(){
 		  $("#div-add-document").show('slow');
  });

  $("#btn-add-document-hide").on("click", function(){
 		  $("#div-add-document").hide('slow');
  });

  $(".cancel-add-document").on("click", function(){
 		  $("#div-add-document").hide('slow');
  });

  $(".move-doc-btn").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-document-"+id).show('slow');
  });

  $(".cancel-doc-mv").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-document-"+id).hide('slow');
  });

  $(".move-folder-btn").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-folder-"+id).show('slow');
  });

  $(".cancel-folder-mv").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-folder-"+id).hide('slow');
  });

 

  $("#btn-next-2").on("click", function(){
  	$("#nav-tab-2").removeClass("active");
  	$("#nav-tab-3").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  });

  /* ---- For document previews ---- */

  $(".preview-doc-btn").on("click", function(){
  	$("#div-add-folder").hide();
		$("#div-add-document").hide();
  	$("#folder-content").hide();

  	var docID = $(this).attr("id");
  	var version = $(this).attr("rel");
  	$("#doc-title").text($(this).attr("title"));
  	$("#document-previewer").show('slow');
  	$("#iframe-charger").attr("src","../pdfviewer/web/viewer.html?file=..%2F..%2Fop%2Fop.Download.php%3Fdocumentid%3D"+docID+"%26version%3D"+version);
  });

  $(".close-doc-preview").on("click", function(){
  	$("#document-previewer").hide();
  	$("#iframe-charger").attr("src","");
  	$("#folder-content").show('slow');
  });
  
  $("#attributes_13").on("change", function() {
	 console.log(this.value);
	 if(this.value == 'Anormal') {
		 $("#problemaJuridico").hide();
	 } else {
		 $("#problemaJuridico").show();
	 }
  });
  
});
<?php
		if ($enableDropUpload && $folder->getAccessMode($user) >= M_READWRITE) {
			echo "SeedDMSUpload.setUrl('../op/op.Ajax.php');";
			echo "SeedDMSUpload.setAbortBtnLabel('".getMLText("cancel")."');";
			echo "SeedDMSUpload.setEditBtnLabel('".getMLText("edit_document_props")."');";
			echo "SeedDMSUpload.setMaxFileSize(".SeedDMS_Core_File::parse_filesize(ini_get("upload_max_filesize")).");";
			echo "SeedDMSUpload.setMaxFileSizeMsg('".getMLText("uploading_maxsize")."');";
		}
		$this->printDeleteFolderButtonJs();
		$this->printDeleteDocumentButtonJs();
		$this->printKeywordChooserJs("form2");
		$this->printFolderChooserJs("form3");
		$this->printFolderChooserJs("form4");
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$db = $dms->getDB();
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$orderby = $this->params['orderby'];
		$enableFolderTree = $this->params['enableFolderTree'];
		$enableClipboard = $this->params['enableclipboard'];
		$enableDropUpload = $this->params['enableDropUpload'];
		$expandFolderTree = $this->params['expandFolderTree'];
		$showtree = $this->params['showtree'];
		$cachedir = $this->params['cachedir'];
		$workflowmode = $this->params['workflowmode'];
		$enableRecursiveCount = $this->params['enableRecursiveCount'];
		$maxRecursiveCount = $this->params['maxRecursiveCount'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];
		$folderid = $folder->getId();
		$this->htmlAddHeader('<link href="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">'."\n", 'css');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/jquery.dataTables.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/validate/jquery.validate.js"></script>'."\n", 'js');
		
		echo $this->callHook('startPage');
		$this->htmlStartPage("Gestor de eventos de Signature Events", "skin-blue sidebar-mini sidebar-collapse");
		$this->containerStart();

		$this->mainHeader();
		$this->mainSideBar($folder->getID(),0,0);
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		//echo $this->callHook('preContent');
		$this->contentStart();		
		echo $this->getFolderPathHTML($folder);
		echo "<div class=\"row\">";
		echo "<h3>Bienvenido al sistema de gestión de eventos de Signature Events!</h3>";

		//// Add Folder ////
		echo "<div class=\"col-md-12 div-hidden\" id=\"div-add-folder\">";
		echo "<div class=\"box box-success div-green-border\" id=\"box-form1\">";
    echo "<div class=\"box-header with-border\">";
    echo "<h3 class=\"box-title\">".getMLText("add_subfolder")."</h3>";
    echo "<div class=\"box-tools pull-right\">";
    echo "<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>";
    echo "</div>";
    echo "<!-- /.box-tools -->";
    echo "</div>";
    echo "<!-- /.box-header -->";
    echo "<div class=\"box-body\">";
    ?>
     <style>
        .error {
            color: red;
        }
    </style>

    <?php
    echo "</div>";
    echo "<!-- /.box-body -->";
    echo "</div>";
		echo "</div>";
		//// Add Document (Añadir resolución del TEG. Modificado por Mario López Leiva marioleiva2011@gmail.com)////
		echo "<div class=\"col-md-12 div-hidden\" id=\"div-add-document\">";
		echo "<div class=\"box box-warning div-bkg-color\" id=\"box-form2\">";
    echo "<div class=\"box-header with-border\">";
    echo "<h3 class=\"box-title\">".getMLText("anadir_resolucion")."</h3>";
    echo "<div class=\"box-tools pull-right\">";
    echo "<button id=\"btn-add-document-hide\" type=\"button\" class=\"btn btn-box-tool\"><i class=\"fa fa-times\"></i></button>";
    echo "</div>";
    echo "<!-- /.box-tools -->";
    echo "</div>";
    echo "<!-- /.box-header -->";
    echo "<div class=\"box-body\">";
    ?>

   	
    <?php
    echo "</div>";
    echo "<!-- /.box-body -->";
    echo "</div>";
		echo "</div>";
		//// Folder content ////
	////////////// AQUI VA MI CONTENIDO DE SIGNATURE		
		?>



		<?php
		
		////////////////////////// INICIO VISTA DE ADMINISTRADORES
		if($user->isAdmin())		
		{
			//crear
		echo '<div class="row">'; //abro fila
			echo '<div class="col-lg-6" >'; //media pagina abro
			
						echo '<div class="col-lg-12 col-xs-12">
				          <div class="small-box bg-yellow">
				            <div class="inner">
				              <h3>Crear nuevo evento</h3>

				              <p> y llenar sus datos</p>
				            </div>
				            <div class="icon">
				              <i class="fa fa-calendar"></i>
				            </div>
				            <a href="out.AnadirEvento.php" class="small-box-footer">Acceder<i class="fa fa-arrow-circle-right"></i></a>
				          </div>
				        </div>';
				        //ver lista
				        echo '<div class="col-lg-12 col-xs-12">
				          <div class="small-box bg-blue">
				            <div class="inner">
				              <h3>Ver lista de eventos</h3>

				              <p> realizados y en curso</p>
				            </div>
				            <div class="icon">
				              <i class="fa fa-list-alt"></i>
				            </div>
				            <a href="out.VerEventos.php" class="small-box-footer">Acceder<i class="fa fa-arrow-circle-right"></i></a>
				          </div>
				        </div>';
					

			echo '</div>'; //media pagina  cierro

        echo '<div class="col-lg-6" >'; //otra media pagina abro

        ?>
        	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Últimos eventos conseguidos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre de evento</th>
                  <th>Fecha</th>
                  <th>Lugar</th>
                       
                </tr>
               </thead>
               <tbody>
                	<?php
                	$numEventos=10;
                	//////////////// DIBUJO TABLA
                	$consultar = "SELECT * FROM eventos ORDER by fecha DESC ;";
					//echo "Consultar: ".$consultar;
				  	$res1 = $db->getResultArray($consultar);
                	for($cont=0;$cont<$numEventos;$cont++)
                	{
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[$cont]['id'];
                    $consultaNombre= "SELECT nombre FROM eventos WHERE id= $idItem;";
                    $resName = $db->getResultArray($consultaNombre);
                     $name=$resName[0]['nombre'];
                     echo "<td>".$name."</td>";
                   
                    	 //2. fecha
                        $fecha=$resName[0]['fecha'];
                		 echo "<td>".$fecha."</td>";
                		
                     $lugar=$res1[$cont]['lugar'];
                     // 3. lugar
                		 echo "<td>". $lugar."</td>";
                		  
     
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



        <?php
 
        	 echo "Ver lista de proveedores de este evento y editarlos:";
        echo "<a class=\"btn btn-success\" href=\"out.CalculaPrecios.php\">".'
                <i class="fa fa-calculator"></i> Acceder a calculadora de tu evento
              </a>';
        echo '</div>'; //otra media pagina  cierro


		echo '</div>'; //cierro fila

		} //fin de si es admin


		////////////////////////// INICIO VISTA DE UUSUARIOS FINALES
		if(!$user->isAdmin())
		{
				echo '<div class="col-lg-6" >'; //media pagina abro
			
						echo '<div class="col-lg-12 col-xs-12">
				          <div class="small-box bg-yellow">
				            <div class="inner">
				              <h3>Ver mis eventos con Signature Events</h3>

				              <p> y llenar sus datos</p>
				            </div>
				            <div class="icon">
				              <i class="fa fa-calendar"></i>
				            </div>
				            <a href="out.AnadirEvento.php" class="small-box-footer">Acceder<i class="fa fa-arrow-circle-right"></i></a>
				          </div>
				        </div>';
				        //ver lista
				        echo '<div class="col-lg-12 col-xs-12">
				          <div class="small-box bg-blue">
				            <div class="inner">
				              <h3>Ver lista de eventos</h3>

				              <p> realizados y en curso</p>
				            </div>
				            <div class="icon">
				              <i class="fa fa-list-alt"></i>
				            </div>
				            <a href="out.VerEventos.php" class="small-box-footer">Acceder<i class="fa fa-arrow-circle-right"></i></a>
				          </div>
				        </div>';
					

			echo '</div>'; //media pagina  cierro

		} //fin de si es usuario
		/////////////////////////////////////////7

		?>




<?php
	////////////// FIN DE  DE SIGNATURE
		echo "</div>\n"; // End of row
		echo "</div>\n"; // End of container

		//echo $this->callHook('postContent');

		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();

		//echo "<script type='text/javascript' src='/formularioSubida.js'></script>";
		echo '<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
		echo '<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';

        echo '<script src="../styles/multisis-lte/bower_components/Chart.js/Chart.js"></script>';


        echo '<script src="../styles/multisis-lte/plugins/sorting/moment.min.js"></script>';
        echo '<script src="../styles/multisis-lte/plugins/sorting/datetime-moment.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/jquery-knob/js/jquery.knob.js"></script>';
		//echo '<script src="../tablasDinamicas.js"></script>';
		//echo '<script src="../graficaInicial.js"></script>';

		$this->htmlEndPage();
	} /* }}} */
}

?>