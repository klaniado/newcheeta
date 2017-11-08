<?php
require_once("clases/dbJSON.php");
require_once("clases/dbMySQL.php");

$db = new dbMySQL();
$db->crearDB();
header("location:entrada.php")
 ?>
