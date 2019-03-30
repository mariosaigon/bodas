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
		$consultar = "SELECT * FROM eventos where id=$idEvento;";
    //echo "consultar: ".$consultar;
        $res1 = $db->getResultArray($consultar);
          
		?>
    <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="out.VerItems.php"> Experiencia Signature Events</a></li>
        <?php  echo "<li class=\"active\">Tracking - ". $res1[0]['nombre']."</li>"; ?>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
  $this->startBoxPrimary("Viendo información del evento "."<b>".$res1[0]['nombre']."</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
  <?php  
  $fechaEvento=$res1[0]['fecha'];
  $idItem=$res1[0]['id'];
  echo "Solo administradores del sistema: hacer clic en cada elemento en azul para editarlo.<br>";

  //echo "<p id=\"fechaEvento\">$fechaEvento</p>"; ?>
<div class="row">

  <div class="col-md-6">

    <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h3>Mi evento</h3></span>

               <p>Nombre del evento:<span class="info-box-number">
                <?php 
                if($user->isAdmin())
                {

                  echo "<td><a href=\"#\" id=\"nombre\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarEvento.php\" data-title=\"nombre\">".$res1[0]['nombre']."</a></td>";
                }

                else
                {
                  echo $res1[$cont]['nombre'];
                } 

                ?>
                 

               </span></p>

               <p>Lugar:<span class="info-box-number">
                <?php 
                if($user->isAdmin())
                {

                  echo "<td><a href=\"#\" id=\"lugar\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarEvento.php\" data-title=\"Lugar\">".$res1[0]['lugar']."</a></td>";
                }

                else
                {
                  echo $res1[$cont]['lugar'];
                } 

                ?>
                 

               </span></p>
                <p>Cantidad de invitados:<span class="info-box-number">
                  
                   <?php 
                if($user->isAdmin())
                {

                  echo "<td><a href=\"#\" id=\"cantidad_invitados\" data-step=\"1\" data-type=\"number\" data-pk=\"$idItem\" data-url=\"../modificarEvento.php\" data-title=\"cantidad_invitados\">".$res1[0]['cantidad_invitados']."</a></td>";
                }

                else
                {
                  echo $res1[$cont]['cantidad_invitados'];
                } 

                ?>

                </span></p>

              <p>Un poco sobre mi evento:<span class="info-box-number">
                <?php 
                if($user->isAdmin())
                {

                  echo "<td><a href=\"#\" id=\"descripcion\"  data-type=\"text\" data-pk=\"$idItem\" data-url=\"../modificarEvento.php\" data-title=\"descripcion\">".$res1[0]['descripcion']."</a></td>";
                }

                else
                {
                  echo $res1[$cont]['descripcion'];
                } 

                ?>
              </span></p>

              <p>Fecha:<span class="info-box-number">
                <?php 
                if($user->isAdmin())
                {

                  echo "<td><a href=\"#\" id=\"fecha\"  data-type=\"combodate\" data-pk=\"$idItem\" data-url=\"../modificarEvento.php\" data-title=\"fecha\">".$res1[0]['fecha']."</a></td>";
                }

                else
                {
                  echo $res1[$cont]['fecha'];
                } 

                ?>
              </span></p>
            </div>
            <!-- /.info-box-content -->
    </div>

  
      
  </div>


  <div class="col-md-6">

      <div class="small-box bg-green">
            <div class="inner">
              <p><?php echo "<b>Faltan...</b>";?> </p>
              <div id="fechita" style="display: none;"><?php echo "$fechaEvento";?> </div>
              <h3 id="demo" >53<sup style="font-size: 20px">%</sup></h3>

             
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>


          <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>

  </div>


</div>

<?php


?>


      <?php
      if($user->isAdmin())
      {
        echo "Ver lista de hitos de este evento y editarlos:";
        echo "<a class=\"btn btn-app\" href=\"out.VerHitos.php?evento=$idEvento\">".'
                <i class="fa fa-heart-o"></i> Lista de hitos de este evento
              </a><br>';


        echo "Ver lista de proveedores de este evento y editarlos:";
        echo "<a class=\"btn btn-info\" href=\"out.VerProveedores.php?evento=$idEvento\">".'
                <i class="fa fa-file"></i> Lista de proveedores de este evento
              </a>';

      }
//////////////////////////////////////////////// TIMELINE DE HITOS


echo '<div class="row">';



      echo "<div class=\"col-md-6\">";

       echo "</div>"; //FIN DE COL IZQUIERDA


         echo "<div class=\"col-md-6\">";
                //$idPostulacion=getIdPostulacion($idpostulante,$db);
    $inicial="SELECT deadline FROM hitos_eventos WHERE id_evento=$idEvento;";
    $res = $db->getResultArray($inicial);
    $fechaInicial=$res[0]['deadline']; 
    //echo "Fecha inicial: ".$fechaInicial; 
    $tempo=explode(" ", $fechaInicial);
    $datIni=$tempo[0];
    $horaIni=$tempo[1];
    $consultar1="SELECT deadline,nombre_hito,estado,comentario FROM hitos_eventos WHERE id_evento=$idEvento ORDER BY deadline desc;";
    //echo "consultar historial: ".$consultar1;
    $res1 = $db->getResultArray($consultar1); 
     echo '<div class="box box-info no-print collapsed-box">';
     echo '<div class="box-header with-border">';
             echo "<h1> Línea del tiempo <small>del de los hitos en la planificación de tu evento (click en la cruz para desplegar)</small> </h1>";
              echo '<div class="box-tools pull-right">';
                echo '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>';
                echo '</button></div></div>';

            echo '<div class="box-body">';
  
echo '<ul class="timeline">';

    foreach($res1 as $linea)
    {
      
      $nameHito=$linea['nombre_hito'];     
      $comment=$linea['comentario'];
      $estado=$linea['estado'];
      $fechaCompleta=$linea['deadline'];
      //echo "Fecha completa: ".$fechaCompleta;
      $temp=explode("-", $fechaCompleta);
      $year=$temp[0]; //echo "dat: ".$dat;
      $mes=$temp[1];
      $dia=$temp[2];

      echo '<li class="time-label">';
        echo '<span class="bg-red">';
            echo "$dia-$mes-$year";
        echo '</span>';
        echo '</li>';
       echo '<li>';
        echo '<i class="fa fa-envelope bg-blue"></i>';
        echo '<div class="timeline-item">';
             echo "<span class=\"time\"><i class=\"fa fa-clock-o\"></i> $hora</span>";

             echo "<h3 class=\"timeline-header\"><a href=\"#\"><b>$nameHito</b> | Estado:</a> $estado</h3>";

             echo '<div class="timeline-body">';
                
                 echo "$comment";
             echo '</div>';

             echo '<div class="timeline-footer">';
                 
             echo '</div>';
         echo '</div>';
    echo '</li>';
    }//fin de obtener de la bd desde el mas reciente eventos
    //al final, del todo, pongo la postulación inicial


echo '</ul>'; 
echo '</div>'; //cierre del box body linea del tmepo
echo '</div>'; //cierre del box  linea del tmepo

       echo "</div>"; //FIN DE COL DRECHA



    echo "</div>"; //FIN DE SEGUNDA ROW
  
 //////FIN MI CODIGO                 
$this->contentContainerEnd();
      ?>


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
    echo "<script type='text/javascript' src='../modificarPerfil.js'></script>";
        echo '<script type="text/javascript" src="../styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="../styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
    //echo "<script type='text/javascript' src='../modificarPerfil.js'></script>";
      echo "<script type='text/javascript' src='../contador.js'></script>";
   
		$this->htmlEndPage();
	} /* }}} */
}
?>
