<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Practica 6</title>
	<link rel="stylesheet" type="text/css" href="views/css/estilos.css" />  

</head>

<body>

	
	
	
	<form action="index.php">

		<input type="hidden" name="controlador" value="categoria">
		<input type="hidden" name="accion" value="nuevo">
		
				
		<?php echo isset($errores["categoria"]) ? "*" : "" ?>
		<label for="cat_nombre">NOMBRE</label>
		<input type="text" name="cat_nombre">
		</br>		
		

		<input type="submit" name="submit" value="Aceptar">

	</form>



	</br>
	<?php
if (isset($errores)):
	foreach ($errores as $key => $error):
		echo $error . "</br>";
	endforeach;
endif;
?>

<?php include_once("common/pie.php"); ?>

</body>

</html>