<?php
//    
//    Copyright (C) José Mario López Leiva. marioleiva2011@gmail.com_addre
//    September 2017. San Salvador (El Salvador)
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");
 function crearItem($nombre,$descripcion,$tipo,$fecha,$lugar,$invitados,$dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO eventos VALUES(NULL,'$nombre',$tipo,'$descripcion','$fecha','$lugar',$invitados)";
		//echo "INSERTAR: ".$insertar;
		$res1 = $db->getResult($insertar);
		$idCreado=$db->getInsertID();
		return $idCreado;
	 }
//tabla seeddms.tblattributedefinitions;
 //generan
if ($user->isGuest()) {
	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
}

// Check to see if the user wants to see only those documents that are still
// in the review / approve stages.
$showInProcess = false;
if (isset($_GET["inProcess"]) && strlen($_GET["inProcess"])>0 && $_GET["inProcess"]!=0) {
	$showInProcess = true;
}

$orderby='n';
if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) {
	$orderby=$_GET["orderby"];
}
///campos del formulario
$nombre="";
if (isset($_POST["nombre"])) {
	$nombre=$_POST["nombre"];
}

$tipo="";
if (isset($_POST["tipo"])) {
	$tipo=$_POST["tipo"];
}

$descripcion="";
if (isset($_POST["descripcion"])) {
	$descripcion=$_POST["descripcion"];
}

$fecha="";
if (isset($_POST["fecha"])) {
	$fecha=$_POST["fecha"];
}

$lugar="";
if (isset($_POST["lugar"])) {
	$lugar=$_POST["lugar"];
}

$invitados="";
if (isset($_POST["invitados"])) {
	$invitados=$_POST["invitados"];
}


$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
//CREACIÓN COMO TAL
crearItem($nombre,$descripcion,$tipo,$fecha,$lugar,$invitados,$dms);


if($view) {
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('nombre', $nombre);
	$view->setParam('fecha', $fecha);
	$view->setParam('lugar', $lugar);

	$view($_GET);
	exit;
}


?>
