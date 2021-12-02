<?php
	$idpaciente = $_GET['id'];
	$iduser = $_GET['user'];
	if($iduser != '1' && $iduser != '2'){
		echo "Usted no ha iniciado sesión";
	}else{
		// EXTRAER EL REGISTRO
		// Conectar a la base de datos:
		$DBuser 		= "root";
		$DBpwd 			= "1234";
		$servidor 		= "cruddb-service";
		$basededatos 	= "hospital";
		$conexion = mysqli_connect( $servidor, $DBuser, $DBpwd, $basededatos)
				or die ("No se ha podido conectar al servidor de Base de datos");
		$db = mysqli_select_db( $conexion, $basededatos) 
				or die ( "Error al conectar con la base de datos" );
				
		//Establecer y realizar consulta.
		$consulta = "SELECT * FROM pacientes WHERE id_paciente=".$idpaciente.";";
		$consulta = mysqli_query( $conexion, $consulta ) 
					or die ( "Algo ha ido mal en la consulta a la base de datos");
		
		// Almacenar los datos en una variable
		$registro = mysqli_fetch_array($consulta);
		
		// Determinar si el usuario tiene o no permiso de editar:
		if($iduser=='1'){
			$temp = "";
			$temp2 = "";
		}else{ 
			$temp = "readonly";
			$temp2 = "disabled";
			echo "Usuario no administrativo. Sólo lectura de expediente <BR><BR><BR>";
		}
		
		mysqli_close( $conexion );

	// SE VAN A HACER CAMBIOS EN EL REGISTRO O SE VA A BORRAR
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
		
		// Determinar qué acción se va a tomar
		if(isset($_POST['cambios'])){
			$query = "UPDATE pacientes SET nombre='$nombre',fecha='$fecha',fecha_nac='$fechanac',edad='$edad',genero='$genero',ocupacion='$ocupacion',lateralidad='$lat',nacionalidad='$nac',religion='$relig',domicilio='$domicilio',telefono='$tel',email='$correo',tel_emergencia='$teleme',con_emergencia='$emercont' WHERE id_paciente = $idpaciente;";
			if(mysqli_query($conexion, $query)){
				echo "Cambios realizados";
				//header("Refresh:0");
				echo("<meta http-equiv='refresh' content='1'>");
			}else{ 
				echo "Error al realizar cambios"; 
				echo mysqli_error($conexion);
			}
		}elseif(isset($_POST['borrar'])){
			$query = "DELETE FROM pacientes WHERE id_paciente= '$idpaciente'";
			if(mysqli_query($conexion, $query)){
				header("Location: index.php");
			}else{ 
				echo "Error al eliminar expediente"; 
				echo mysqli_error($conexion);
			}
		}else{}
		
		mysqli_close($conexion);
	} else { echo "Favor de llenar todos los campos"; }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="styles/form.css">
	<title> Expediente de paciente </title>
</head>
<body>
	<a href=<?php echo "index.php";?>>Volver</a> <BR>
	<form ACTION="<?php echo "paciente.php?id=".$idpaciente."&user=".$iduser?>" METHOD="post">
    <table>
      <TR>
        <TH COLSPAN = 3>
          Expediente del paciente
		 </TH>
      </TR>
      <TR>
        <TD COLSPAN = 2> 
          NOMBRE: <input TYPE = 'text' NAME = 'nombre' 
				REQUIRED SIZE = 70% value= "<?php echo $registro['nombre'] ;?>" <?php echo $temp;?>>
        </TD>
        <TD> 
          FECHA: <input TYPE = 'date' NAME = 'fecha' REQUIRED 
					value= "<?php echo $registro['fecha'] ;?>" <?php echo $temp;?>>
        </TD>
      </TR>
      <TR>
        <TD> 
          FECHA DE NACIMIENTO: <input TYPE = 'date' NAME = 'fechanac' SIZE = 20 REQUIRED 
					value= "<?php echo $registro['fecha_nac'] ;?>" <?php echo $temp;?>>
        </TD>
        <TD> 
          EDAD: <input TYPE = 'number' NAME = 'edad' MIN = 0 SIZE = 10 REQUIRED 
				value= "<?php echo $registro['edad'] ;?>" <?php echo $temp;?>>
        </TD>
        <TD> 
          GÉNERO: <BR> 
			<?php 
				//Determinar qué botón va seleccionado
				if($registro['genero'] == 'M'){
					echo "Masculino:<input type='radio' name='genero' value='M' checked ".$temp2.">";
					echo "Femenino:<input type='radio' name='genero' value='F' ".$temp2.">";
				}else{
					echo "Masculino:<input type='radio' name='genero' value='M' ".$temp2.">";
					echo "Femenino:<input type='radio' name='genero' value='F' checked ".$temp2.">";
				}
			?>
        </TD>
      </TR>
      <TR>
        <TD> 
          OCUPACIÓN: <input type="text" name="ocupacion" REQUIRED
						value= "<?php echo $registro['ocupacion'] ;?>" <?php echo $temp;?>>
        </TD>
		<TD COLSPAN = 2>
          LATERALIDAD: <BR> 
			<?php
				switch($registro['lateralidad']){
					case 'D':
						echo "Diestro:<input type='radio' name='lateralidad' value='D' ".$temp2." checked>";
						echo "Zurdo:<input type='radio' name='lateralidad' value='Z' ".$temp2.">";
						echo "Ambidiestro:<input type='radio' name='lateralidad' value='X' ".$temp2.">";
					break;
					case 'Z':
						echo "Diestro:<input type='radio' name='lateralidad' value='D' ".$temp2.">";
						echo "Zurdo:<input type='radio' name='lateralidad' value='Z' ".$temp2." checked>";
						echo "Ambidiestro:<input type='radio' name='lateralidad' value='X' ".$temp2.">";
					break;
					case 'X':
						echo "Diestro:<input type='radio' name='lateralidad' value='D' ".$temp2.">";
						echo "Zurdo:<input type='radio' name='lateralidad' value='Z' ".$temp2.">";
						echo "Ambidiestro:<input type='radio' name='lateralidad' value='X' ".$temp2." checked>";
					break;
				}
			?>
        </TD>
      </TR>
      <TR>
        <TD> 
          NACIONALIDAD: <input type="text" name="nacionalidad" REQUIRED 
						value= "<?php echo $registro['nacionalidad'] ;?>" <?php echo $temp;?>>
        </TD>
		<TD>
          RELIGIÓN: <input type="text" name="religion" REQUIRED 
					value= "<?php echo $registro['religion'] ;?>" <?php echo $temp;?>>
        </TD>
      </TR>
      <TR>
        <TH COLSPAN = 3> Datos de contacto </TH>
      </TR>
	  <TR>
        <TD> 
          DOMICILIO: <input TYPE = 'text' NAME = 'domicilio' SIZE = 20 REQUIRED 
					value= "<?php echo $registro['domicilio'] ;?>" <?php echo $temp;?>>
        </TD>
		<TD> 
          TELEFONO: 
            <input TYPE = 'text' NAME = 'tel' SIZE = 20 REQUIRED 
			value= "<?php echo $registro['telefono'] ;?>" <?php echo $temp;?>>            
        </TD>
      </TR>
      <TR>
        <TD> 
          EMAIL: <input TYPE = 'email' NAME = 'correo' SIZE = 20 REQUIRED
					value= "<?php echo $registro['email'] ;?>" <?php echo $temp;?>>
        </TD>
		<TD>
          TEL EMERGENCIA: <input TYPE = 'text' NAME = 'teleme' SIZE = 20 REQUIRED 
						value= "<?php echo $registro['tel_emergencia'] ;?>" <?php echo $temp;?>> 
        </TD>
      </TR>
	  <TR>
		<TD COLSPAN = 3>
			EN CASO DE EMERGENCIA, CONTACTAR A: <BR>
			<input type="text" name="emergenciacontact" size=100% REQUIRED 
				value= "<?php echo $registro['con_emergencia'] ;?>" <?php echo $temp;?>>
    </table>
    <BR> <BR>
    <table>
      <TR>
        <TD>
          <input type="submit" value="Guardar cambios" name='cambios' <?php echo $temp2;?>>
        </TD>
        <TD>
          <input type="submit" value="Borrar expediente" name='borrar' <?php echo $temp2;?>>
        </TD>
      </TR>
    </table>
    </form>	

</body>
</html>
<?php
	}
?>