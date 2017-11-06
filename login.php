<?php
	$title = "Login";
	require_once("head.php");
	require_once("soporte.php");

	if ($auth->estaLogueado()) {
		header("Location:logueado.php");exit;
	}

	if ($_POST) {
		$arrayDeErrores = $validator->validarLogin($db);

		if (count($arrayDeErrores) == 0) {
			$auth->loguear($_POST["email"]);

			if (isset($_POST["recordame"])) {
				setcookie("usuarioLogueado", $_POST["email"], time()+60*60*24*30);
			}

			header("Location:logueado.php");
		}
	}

?>

<?php include("header.php"); ?>
		<div class="medio">
			<h1>Login</h1>
		<?php if(isset($arrayDeErrores)) : ?>
			<ul class="errores">
				<?php foreach($arrayDeErrores as $error) : ?>
					<li>
						<?=$error?>
					</li>
				<?php endforeach;?>
			</ul>
		<?php endif; ?>
		<form action="login.php" method="POST">
				<label>Email:</label><br>
				<input class="form-control" type="text" name="email"><br>
				<label>Password:</label><br>
				<input class="form-control" type="password" name="password"><br>
				 <input type="checkbox" name="recordame"><h3 class="hoola">Recordarme</h3><br>
				 <input type="submit" name="enviar"class="enviar" value="enviar">
		</form>
	</div>
<?php include("footer.php"); ?>
