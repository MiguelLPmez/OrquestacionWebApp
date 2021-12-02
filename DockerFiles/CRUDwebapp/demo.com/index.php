<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="styles/form.css">
	<title> Formulario clínico </title>
</head>
<body>
	<IMG SRC = 'banner.jpg'>
    <BR> <h2>Registrar un paciente</h2> <BR> 
    <form ACTION="<?php echo "index.php" ?>"METHOD="post">
    	<table>
    	  <TR>
    	    <TH COLSPAN = 3>
    	      Historial clínico
			 </TH>
    	  </TR>
    	  <TR>
    	    <TD COLSPAN = 2> 
    	      NOMBRE: <input TYPE = 'text' NAME = 'nombre' REQUIRED SIZE = 70%>
    	    </TD>
    	    <TD> 
    	      FECHA: <input TYPE = 'date' NAME = 'fecha' REQUIRED>
    	    </TD>
    	  </TR>
    	  <TR>
    	    <TD> 
    	      FECHA DE NACIMIENTO: <input TYPE = 'date' NAME = 'fechanac' SIZE = 20 REQUIRED>
    	    </TD>
    	    <TD> 
    	      EDAD: <input TYPE = 'number' NAME = 'edad' MIN = 0 SIZE = 10 REQUIRED>
    	    </TD>
    	    <TD> 
    	      GÉNERO: <BR> 
				Masculino:<input type="radio" name="genero" value="M" checked> 
				Femenino:<input type="radio" name="genero" value="F">
    	    </TD>
    	  </TR>
    	  <TR>
    	    <TD> 
    	      OCUPACIÓN: <input type="text" name="ocupacion" REQUIRED>
    	    </TD>
			<TD COLSPAN = 2>
    	      LATERALIDAD: <BR> 
				Diestro:<input type="radio" name="lateralidad" value="D" checked> 
				Zurdo:<input type="radio" name="lateralidad" value="Z">
				Ambidiestro:<input type="radio" name="lateralidad" value="X">
    	    </TD>
    	  </TR>
    	  <TR>
    	    <TD> 
    	      NACIONALIDAD: <input type="text" name="nacionalidad" REQUIRED>
    	    </TD>
			<TD>
    	      RELIGIÓN: <input type="text" name="religion" REQUIRED>
    	    </TD>
    	  </TR>
    	  <TR>
    	    <TH COLSPAN = 3> Datos de contacto </TH>
    	  </TR>
		  <TR>
    	    <TD> 
    	      DOMICILIO: <input TYPE = 'text' NAME = 'domicilio' SIZE = 20 REQUIRED>
    	    </TD>
			<TD> 
    	      TELEFONO: 
    	        <input TYPE = 'text' NAME = 'tel' SIZE = 20 REQUIRED>            
    	    </TD>
    	  </TR>
    	  <TR>
    	    <TD> 
    	      EMAIL: <input TYPE = 'email' NAME = 'correo' SIZE = 20 REQUIRED>
    	    </TD>
			<TD>
    	      TEL EMERGENCIA: <input TYPE = 'text' NAME = 'teleme' SIZE = 20 REQUIRED> 
    	    </TD>
    	  </TR>
		  <TR>
			<TD COLSPAN = 3>
				EN CASO DE EMERGENCIA, CONTACTAR A: <BR>
				<input type="text" name="emergenciacontact" size=100% REQUIRED>
    	</table>
    	<BR> <BR>
    	<table>
    	  <TR>
    	    <TD>
    	      <input type="reset" value="Limpiar">
    	    </TD>
    	    <TD>
    	      <input type="submit" value="Registrar">
    	    </TD>
    	  </TR>
    	</table>
    </form>
<?php
	// ALTA DE UN REGISTROS
	if(isset($_POST['nombre']) && isset($_POST['fecha']) && isset($_POST['fechanac']) &&
		isset($_POST['edad']) && isset($_POST['genero']) && isset($_POST['ocupacion']) &&
		isset($_POST['lateralidad']) && isset($_POST['nacionalidad']) && 
		isset($_POST['religion']) && isset($_POST['domicilio']) && isset($_POST['tel']) &&
		isset($_POST['correo']) && isset($_POST['teleme']) && 
		isset($_POST['emergenciacontact'])){
		$nombre		= $_POST['nombre'];
		$fecha		= $_POST['fecha'];
		$fechanac	= $_POST['fechanac'];
		$edad		= $_POST['edad'];
		$genero		= $_POST['genero'];
		$ocupacion	= $_POST['ocupacion'];
		$lat		= $_POST['lateralidad'];
		$nac		= $_POST['nacionalidad'];
		$relig		= $_POST['religion'];
		$domicilio	= $_POST['domicilio'];
		$tel		= $_POST['tel'];
		$correo		= $_POST['correo'];
		$teleme		= $_POST['teleme'];
		$emercont	= $_POST['emergenciacontact'];
		
		// Conectar a la base de datos
		$DBuser 		= "root";
		$DBpwd 			= "1234";
		$servidor 		= "cruddb-service";
		$basededatos 	= "hospital";
		$conexion = mysqli_connect( $servidor, $DBuser, $DBpwd, $basededatos)
			or die ("No se ha podido conectar al servidor de Base de datos");
		$db = mysqli_select_db( $conexion, $basededatos) 
			or die ( "Error al conectar con la base de datos" );
		// Redactar la sentencia
		$insert = "INSERT INTO pacientes VALUES(DEFAULT, '$nombre','$fecha','$fechanac','$edad','$genero','$ocupacion','$lat','$nac','$relig','$domicilio','$tel','$correo','$teleme','$emercont');";
		// Ejecutar
		if(mysqli_query($conexion, $insert)){
			echo "Datos agregados";
		}else{ 
			echo "Error al insertar datos"; 
			echo mysqli_error($conexion);
		}
		
		mysqli_close($conexion);
	}else{ echo "Favor de llenar todos los campos"; }
?>
	<BR>
	<BR>
	<table id=registros>
		<TR>
			<TH COLSPAN = 4>Registros</TH>
		<TR>
			<TD> ID </TD>
			<TD> Nombre </TD>
			<TD> Teléfono </TD>
			<TD> Expediente </TD>
		<TR>
<?php
	// VISUALIZACIÓN DE LOS REGISTROS
	
	// Conectar a la base de datos
	$DBuser 		= "root";
	$DBpwd 			= "1234";
	$servidor 		= "cruddb-service";
	$basededatos 	= "hospital";
	$conexion = mysqli_connect( $servidor, $DBuser, $DBpwd, $basededatos) 
			or die ("No se ha podido conectar al servidor de Base de datos");
	$db = mysqli_select_db( $conexion, $basededatos) 
			or die ( "Error al conectar con la base de datos" );
	
	//Establecer y realizar consulta.
	$consulta = "SELECT * FROM pacientes";
	$consulta = mysqli_query( $conexion, $consulta ) 
				or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	// Bucle while que recorre cada registro y muestra cada campo en la tabla.
	while ($columna = mysqli_fetch_array($consulta)){
		// Preparar el enlace al expediente completo:
		$enlace = "<a HREF = paciente.php?id=".$columna['id_paciente']."&user=1>ver</a>";
		echo "<tr>";
		echo "<td>" . $columna['id_paciente'] ."</td><td>".$columna['nombre']."</td><td>".$columna['telefono']."</td><td>$enlace</td>";
		echo "</tr>";
	}
	
	mysqli_close( $conexion );
?>
		</TR>
	</table>
	<BR>
	<BR>
</body>
</html>