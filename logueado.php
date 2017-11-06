<?php
 $title = "Perfil De Usuario";
 require_once("head.php");
 require_once('header.php');
?><br><br><br><br><br>
<div class="medio">
  <a href="perfilDeUsuario.php">
    <div class="logueadoizq">
      <img class="imgslogueado1" width="150px"src="images/perfil.jpg" alt=""><br>
      <h5>Mi Perfil</h5>
  </div>
  </a>
  <a href="editar.php">
    <div class="logueadoder">
      <img class="imgslogueado2" width="150px"src="images/editar.jpg" alt=""><br>
      <h5>Editar</h5>
    </div>
  </a>
  <a href="deslogueo.php">
    <div class="logueadoder2">
      <img class="imgslogueado2" width="150px"src="images/cerrar.jpg" alt=""><br>
      <h5>Cerrar Sesion</h5>
    </div>
  </a>
</div>
<br><br><br><br>

<?php require_once('footer.php'); ?>
