<?php
require_once("clases/auth.php");
require_once("clases/validator.php");
require_once("clases/dbJSON.php");
require_once("clases/dbMySQL.php");

$db = new dbMySQL();
$db->migrarJSONaMySQL();

$todos = $db->traerTodosLosUsuarios();

//var_dump($todos); exit;

if (count($todos) > 0) {
  header('location:index.php');
} else {
  header('location:entrada.php');
}
?>
