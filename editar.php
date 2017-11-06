<?php
	$title = "Editar Perfil";
	require_once("head.php");

		if (!$auth->estaLogueado()) {
		header("Location:login.php");exit;
	}

	// create curl resource
  $ch = curl_init();

  // set url
  curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v2/all");

  //return the transfer as a string
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // $output contains the output string
  $output = curl_exec($ch);

  // close curl resource to free up system resources
  curl_close($ch);

	$paises = json_decode($output,true);

  $usuario = $auth->obtenerUsuarioLogueado($db);

	$nombreDefault = $usuario->getNombre();
	$emailDefault = $usuario->getEmail();
	$edadDefault = $usuario->getEdad();
	/*
	if ($_POST){
		$nombreDefault = $_POST["nombre"];
	}
	else {
		$nombreDefault = "";
	}
	*/

	//Si el tipo envió información
	if ($_POST) {
		// Validar
		$arrayDeErrores = $validator->validarEdicion($db, $usuario);

		//Si no hay errores
		if (count($arrayDeErrores) == 0) {
			//Registrar

      $usuario->setNombre($_POST["nombre"]);
      $usuario->setEmail($_POST["email"]);
      $usuario->setNewPassword($_POST["password"]);
      $usuario->setPais($_POST["pais"]);
      $usuario->setEdad($_POST["edad"]);

			$db->editarUsuario($usuario);

			//Redirigir a la confirmacion
			header("Location:miPerfil.php");exit;
		}
	}
?>

<?php include("header.php"); ?>
<div class="medio">
	<h1>Registro</h1>


<?php if(isset($arrayDeErrores)) : ?>
	<ul class="errores">
		<?php foreach($arrayDeErrores as $error) : ?>
			<li>
				<?=$error?>
			</li>
		<?php endforeach;?>
	</ul>
<?php endif; ?>
<form method="POST" action="form.php" enctype="multipart/form-data">
		<label>Nombre:</label><br>
		<input  type="text" name="nombre" value="<?=$nombreDefault?>"><br>
		<label>Email:</label><br>
		<input  type="text" name="email" value="<?=$emailDefault?>"><br>
		<label>Edad:</label><br>
		<input  type="text" name="edad" value="<?=$edadDefault?>"><br>
		<label>Password anterior:</label><br>
		<input  type="password" name="oldpassword"><br>
		<label>Nueva Password:</label><br>
		<input  type="password" name="password"><br>
	<?php if(isset($_GET["versionCorta"]) == false) : ?>
				<label>Confirmar Contraseña:</label><br>
			<input  type="password" name="cpassword"><br>
		<?php endif; ?>
	<?php if (count($paises) > 0) : ?>
				<label>Pais:</label><br>
			<select name="pais">
				<?php foreach ($paises as $pais) : ?>
					<?php if ($pais["alpha2Code"] == $_POST["pais"]) : ?>
						<option value="<?=$pais["alpha2Code"]?>" selected>
							<?=$pais["name"]?>
						</option>
					<?php else: ?>
						<option value="<?=$pais["alpha2Code"]?>"><br>
							<?=$pais["name"]?>
						</option>
					<?php endif; ?>

				<?php endforeach; ?>

			</select><br>
		<?php endif; ?>
		<label>Avatar:</label><br><input type="file" name="avatar"><br>
		<input class="enviar" type="submit" name="enviar" value="enviar">
</form>
</div>
<?php include("footer.php"); ?>
