<?php
session_start();
session_destroy();
setcookie("usuarioLogueado", "", time() - 1);
header("location:index.php");exit;
?>
