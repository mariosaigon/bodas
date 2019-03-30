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
 function crearItem($idEvento,$nombre,$estado,$deadline,$comentario,$link,$dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO hitos_eventos VALUES(NULL,$idEvento,'$nombre','$deadline','$estado','$comentario','$link')";
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

$idEvento="";
if (isset($_POST["idEvento"])) {
	$idEvento=$_POST["idEvento"];
}


$nombre="";
if (isset($_POST["nombre2"])) {
	$nombre=$_POST["nombre2"];
}

$estado="";
if (isset($_POST["estado"])) {
	$estado=$_POST["estado"];
}


$deadline="";
if (isset($_POST["deadline2"])) {
	$deadline=$_POST["deadline2"];
}

$comentario="";
if (isset($_POST["comentario2"])) {
	$comentario=$_POST["comentario2"];
}

$link="";
if (isset($_POST["link"])) {
	$link=$_POST["link"];
}


$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
//CREACIÓN COMO TAL
crearItem($idEvento,$nombre,$estado,$deadline,$comentario,$link,$dms);


if($view) {
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('nombre', $nombre);
	$view->setParam('deadline', $deadline);
	$view->setParam('comentario', $comentario);
	$view->setParam('idEvento', $idEvento);

	$view($_GET);
	exit;
}


?>
