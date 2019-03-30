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
 function dameExistencias($id, $dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT cantidad_actual FROM app_item WHERE id=$id;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		return $res1[0]['cantidad_actual'];
	 }

    function dimeUbicaciones($id, $dms)
   {
    $res=true;
    $db = $dms->getDB();
    $consultar = "SELECT id_ubicacion FROM app_ubicacion_item WHERE id_item=$id;";
    //echo "Consultar: ".$consultar;
    $res1 = $db->getResultArray($consultar);
    $ubicaciones=array();
    foreach ($res1 as $ubics) 
    {
      $idUbicacion=$ubics['id_ubicacion'];
      array_push($ubicaciones, $idUbicacion);
      $consultar2 = "SELECT nombre,descripcion FROM app_ubicacion WHERE id=$idUbicacion;";
       $res2 = $db->getResultArray($consultar2);
      foreach ($res2 as $a) 
      {
          $nombre=$a['nombre'];
          $com=$a['descripcion'];
          print "<p>$nombre</p> <br>";
          print "<p>($com)</p>";
          print "--------------";
      }
    }
    
     
     
     
    

   }
class SeedDMS_View_VerEvento extends SeedDMS_Bootstrap_Style 
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

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Ver detalle de artículo", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
		$consultar = "SELECT * FROM app_item where id=$idEvento;";
    //echo "consultar: ".$consultar;
        $res1 = $db->getResultArray($consultar);
          
		?>
    <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="out.GestionarItems.php"> Gestionar items</a></li>
        <li><a href="out.VerItems.php"> Ver la lista de items</a></li>
        <li class="active">Ver datos de item</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
  $this->startBoxPrimary("Viendo información del artículo "."<b>".$res1[0]['nombre']."</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> En esta pantalla puede ver el estado del item</h4>
               Incluyendo cuántos quedan e información general.
                <br>
              </div>
<?php
 //////FIN MI CODIGO                 
$this->contentContainerEnd();

?>
<div class="row">
	<div class="col-md-3">
		<div class="info-box">
            <span class="info-box-icon bg-black"><i class="fa fa-tags"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">De este artículo quedan:</span>
              <span class="info-box-number"><?php 
              print dameExistencias($idItem, $dms);

              ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

                <div class="info-box">
            <span class="info-box-icon bg-navy"><i class="fa  fa-map-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">En cuales ubicaciones está este artículo?:</span>
              <span class="info-box-number"><?php 
               dimeUbicaciones($idItem, $dms);

              ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

        </div>


        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Información</a></li>
              <li><a href="#tab_2" data-toggle="tab">Transacciones</a></li>
              <li><a href="#tab_3" data-toggle="tab">Foto del artículo</a></li>

              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              	            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre</th>
                  <th>descipción</th>
                  <th>Empresa</th>
                  <th>Costo unitario</th>
                  <th>Costo de compra</th>
                  <th>Origen de los fondos</th>
                  <th>Cantidad inicial</th>                 
                </tr>
               </thead>
               <tbody>
                	<?php
            
                	//////////////// DIBUJO TABLA
                	$consultar = "SELECT * FROM app_item WHERE id=$idItem;";
					//echo "Consultar: ".$consultar;
				  	$res1 = $db->getResultArray($consultar);
                	
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[0]['id'];
                		 echo "<td><a href=\"#\" id=\"nombre\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['nombre']."</a></td>";
                		 //2. fecha de inicio a fin
                		 echo "<td><a href=\"#\" id=\"descripcion\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['descripcion']."</a></td>";
                		  // 3. lugar
                		  echo "<td><a href=\"#\" id=\"empresa\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['empresa']."</a></td>";
                      /////////////////////
                		  echo "<td><a href=\"#\" id=\"costo\" data-type=\"number\"  step=\"any\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['costo']."</a></td>";
                      //////////////////////////////////
                		  echo "<td><a href=\"#\" id=\"costo_compra\" data-type=\"number\" step=\"any\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['costo_compra']."</a></td>";
                      ///////////////////////
                		  echo "<td><a href=\"#\" id=\"origen_fondos\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarItemEditable.php\" data-title=\"Enter username\">".$res1[0]['origen_fondos']."</a></td>";
                		  // 4. enlace para editar
                		 echo "<td>".$res1[0]['cantidad_inicial']."</td>";

                     echo ' </tr>';		           
                	                               
                ?>
            </tbody>
              <tfoot>
              </tfoot>
                

               
              </table>
            </div>
            <!-- /.box-body -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <p>Las transacciones están ordenadas desde la más reciente</p>
                <table id="tablaEventos" class="table table-hover table-striped table-condensed">
                <thead>
                <tr>
                  <th>Fecha de la operación</th>
                  <th>Persona que lo hizo</th>
                  <th>Razón</th>
                  <th>Cantidad de artículos tomados/puestos</th>
                
                </tr>
               </thead>
               <tbody>
                                  <?php            
                  //////////////// DIBUJO TABLA
                  $consultar = "SELECT * FROM app_transaccion WHERE id_item=$idItem ORDER BY fecha DESC;";
          //echo "Consultar: ".$consultar;
            $res1 = $db->getResultArray($consultar);
                  
                    foreach ($res1 as $transa) 
                    {
                      echo ' <tr>';
                    //1. fecha
                    $idItem=$res1[0]['id_item'];
                     echo "<td>".$transa['fecha']."</td>";
                     
                     //// 2 persona
                     $idUsuario=$transa['id_usuario'];
                     $usuario=$dms->getUser($idUsuario);
                     $nombreUser=$usuario->getFullName();
                     echo "<td>".$nombreUser."</td>";
                     /// 3 razon
                     echo "<td>".$transa['razon']."</td>";

                     /// 4 cantidad
                      echo "<td>".$transa['cantidad_variada']."</td>";

                     //
                       echo ' </tr>';                                                                 
                    }//fin foreach transaccion
                ?>
                 </tbody>
              <tfoot>
              </tfoot>              
              </table>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                   <img <?php echo "src=\"/images/items/item".$idItem.".jpg\""?> alt="Foto del artículo" height="400" width="280">
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">

      

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row  Y COMIENZA TIMELINE-->

      <?php
      if($user->isAdmin())
      {
        echo "Ver lista de hitos de este evento y editarlos:";
        echo "<a class=\"btn btn-app\" href=\"out.VerHitos.php?evento=$idEvento\">".'
                <i class="fa fa-heart-o"></i> Lista de hitos de este evento
              </a>';

      }
//////////////////////////////////////////////// TIMELINE DE HITOS
    $idPostulacion=getIdPostulacion($idpostulante,$db);
    $inicial="SELECT deadline FROM hitos_eventos WHERE id_evento=$idEvento;";
    $res = $db->getResultArray($inicial);
    $fechaInicial=$res[0]['deadline']; 
    //echo "Fecha inicial: ".$fechaInicial; 
    $tempo=explode(" ", $fechaInicial);
    $datIni=$tempo[0];
    $horaIni=$tempo[1];
    $consultar1="SELECT nombre_hito,estado,comentario FROM hitos_eventos WHERE id_evento=$idEvento ORDER BY deadline desc;";
    //echo "consultar historial: ".$consultar1;
    $res1 = $db->getResultArray($consultar1); 
     echo '<div class="box box-info no-print collapsed-box">';
     echo '<div class="box-header with-border">';
             echo "<h1> Línea del tiempo <small>del histórico del proceso de evaluación del postulante (click en la cruz para desplegar)</small> </h1>";
              echo '<div class="box-tools pull-right">';
                echo '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>';
                echo '</button></div></div>';

            echo '<div class="box-body">';
  
echo '<ul class="timeline">';

    foreach($res1 as $linea)
    {
      
           
      $comment=$linea['comentario'];
      $estado=$linea['estado'];
      $fechaCompleta=$linea['fecha'];
      //echo "Fecha completa: ".$fechaCompleta;
      $temp=explode(" ", $fechaCompleta);
      $dat=$temp[0];
      $hora=$temp[1];
      echo '<li class="time-label">';
        echo '<span class="bg-red">';
            echo "$dat";
        echo '</span>';
        echo '</li>';
       echo '<li>';
        echo '<i class="fa fa-envelope bg-blue"></i>';
        echo '<div class="timeline-item">';
             echo "<span class=\"time\"><i class=\"fa fa-clock-o\"></i> $hora</span>";

             echo "<h3 class=\"timeline-header\"><a href=\"#\">Estado</a> $estado</h3>";

             echo '<div class="timeline-body">';
                
                 echo "$comment";
             echo '</div>';

             echo '<div class="timeline-footer">';
                 
             echo '</div>';
         echo '</div>';
    echo '</li>';
    }//fin de obtener de la bd desde el mas reciente eventos
    //al final, del todo, pongo la postulación inicial
    echo '<li class="time-label">';
        echo '<span class="bg-red">';
            echo "$datIni";
        echo '</span>';
        echo '</li>';
       echo '<li>';
        echo '<i class="fa fa-envelope bg-blue"></i>';
        echo '<div class="timeline-item">';
             echo "<span class=\"time\"><i class=\"fa fa-clock-o\"></i> $horaIni </span>";

             echo "<h3 class=\"timeline-header\"><a href=\"#\">Estado</a> Postulado</h3>";

             echo '<div class="timeline-body">';
                
                 echo "Postulación inicial";
             echo '</div>';

             echo '<div class="timeline-footer">';
                 
             echo '</div>';
         echo '</div>';
         echo '</li>';

echo '</ul>'; 
echo '</div>'; //cierre del box body linea del tmepo
echo '</div>'; //cierre del box  linea del tmepo

      ?>

      <a class="btn btn-app">
                <span class="badge bg-red">531</span>
                <i class="fa fa-heart-o"></i> Likes
              </a>

 <!-- /.box-header -->

<?php
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
        echo '<script type="text/javascript" src="/styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="/styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
    echo "<script type='text/javascript' src='/modificarPerfil.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
