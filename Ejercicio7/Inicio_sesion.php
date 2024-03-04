
<?php
include("Conexion.php");


session_start();


if(isset($_SESSION['id_registro'])){
    session_destroy();
    header('Location:Inicio_sesion.php');
} 


if(!empty($_POST["Login"])){

    $name2=mysqli_real_escape_string($conexion, $_POST['name']);
    $correo2=mysqli_real_escape_string($conexion, $_POST['correo']);
    $pass2=mysqli_real_escape_string($conexion, $_POST['psw']);
    $password_encriptada=sha1($pass2);
    
    $sql="SELECT id,tipo_usuario FROM usuarios WHERE correo='$correo2' and nombre='$name2' and contrasena='$password_encriptada'"; 
    $Resultado = $conexion->query($sql);
    $Rows = $Resultado->num_rows;

    $Resultado2 = $conexion->query($sql);
    $Rows2 = $Resultado2->num_rows;
    
    if ($Rows >= 1) {

        $Row = $Resultado->fetch_assoc();
        $_SESSION['id_registro'] = $Row['id'];

        $Row2 = $Resultado2->fetch_assoc();
        $_SESSION['id_usuario'] = $Row2['tipo_usuario'];


        $tipoUsuario = $Row['tipo_usuario'];
		
        if ($tipoUsuario == 1) {
            header("location: Cliente.php");
        } elseif ($tipoUsuario == 2) {
            header("location: Administrador.php");
        } else {
            echo "<script>
                      alert('Usuario en mantenimiento');
                      window.location.Inicio_sesion.php;
                 </script>";
        }
    } else {
        echo "<script>
                    alert('Usuario o Contraseña incorrecta');
                    window.location.Inicio_sesion.php;
					
                </script>";
				session_destroy();
    }
}

//register
if (isset($_POST["registrar"])) {
    
    $correo=mysqli_real_escape_string($conexion, $_POST['correo1']);
    $pass=mysqli_real_escape_string($conexion, $_POST['psw1']);
	$name=mysqli_real_escape_string($conexion, $_POST['name1']);
    $password_encriptada=sha1($pass);

    $sqluser="SELECT id FROM usuarios WHERE correo='$correo'"; 
	$resultadouser=$conexion->query($sqluser);
    $filas=$resultadouser->num_rows;

	$numeroAleatorio = 1;
	$sqlTipoUsuario = "SELECT id FROM tipos_usuario WHERE id = $numeroAleatorio";
	$resultadoTipoUsuario = $conexion->query($sqlTipoUsuario);


    if($filas>=1){
        echo "<script>
                alert('El usuario ya existe o no digito nada ');
                window.location.Inicio_sesion.php;
            </script>";
    }else{
        //insertar el registro

		
		$filaTipoUsuario = $resultadoTipoUsuario->fetch_assoc();
		$idTipoUsuario = $filaTipoUsuario['id'];
	
        $sqlusuario="insert into usuarios(Nombre, Correo,contrasena, tipo_usuario)
                        values('$name','$correo','$password_encriptada','$idTipoUsuario')";

        $resultadousuario=$conexion->query($sqlusuario);

        if($resultadousuario>0){
            echo "<script>
                    alert('Registro exitoso');
                    window.location.Inicio_sesion.php;
                </script>";
        }else{
            echo "<script>
                    alert('Error al registrar');
                    window.location.Inicio_sesion.php;
                </script>";
        }
    }
}


?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rB9Do1vvNTdPDfiEhFff6V04vcwMvp4PbDYY0RX+8bI/JqjI93u6t/dW5lZiCzX2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Diseñov2.css">
  </head>
  <body>

  <div class="container d-flex justify-content-center align-items-center fondo" style="min-height: 100vh;">    
    <div class="Menu text-center p-4">
        
	         <h2 >Parqueadero</h2>

        <button type="button" class="btn btn-unstyled p-0 boton1" data-bs-toggle="modal" data-bs-target="#myModal1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Registro">
            <lord-icon
                src="https://cdn.lordicon.com/vfczflna.json"
                trigger="hover"
                style="width:100px;height:100px">
            </lord-icon>
        </button>

        <button type="button" class="btn btn-unstyled p-0 boton2" type="button"  data-bs-toggle="modal" data-bs-target="#myModal2" data-bs-toggle="tooltip" data-bs-placement="top" title="Iniciar sesion">
            <lord-icon
                src="https://cdn.lordicon.com/stxfyhky.json"
                trigger="hover"
                style="width:100px;height:100px">
            </lord-icon>
        </button>

    </div>
</div>



<!-- Modales -->

<div class="modal" id="myModal1">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Felicidades !! Jugador </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form action="" method="POST" class="border p-3 custom-form">

<div class="section">
	<div class="container">
		<div class="row full-height justify-content-center">
			<div class="col-12 text-center align-self-center py-5">
				<div class="section pb-5 pt-5 pt-sm-2 text-center">
					
				<div class="section text-center">
							<h4 class="mb-3 pb-3">Sign Up</h4>
							<div class="form-group">
									<input type="text" class="form-style" name="name1"placeholder="Nombre">
									<i class="input-icon uil uil-edit"></i>
							</div>	
							<div class="form-group mt-2">
									<input type="email" class="form-style" name="correo1"placeholder="Correo">
												
									<i class="input-icon uil uil-at"></i>
							</div>	
							<div class="form-group mt-2">
									<input type="password" class="form-style" name="psw1" placeholder="Contraseña">
									<i class="input-icon uil uil-lock-alt"></i>
							</div>
						<button type="submit" name="registrar" class="btn mt-4">Register</button>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
</div>

<!-- Modales -->

<div class="modal" id="myModal2">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Felicidades !! Jugador </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      
<form action="" method="POST" class="border p-3 custom-form">

<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    
                    <h4 class="mb-4 pb-3">Log In</h4>
                        <div class="form-group">
                            <input type="text" class="form-style" placeholder="Nombre" name="name">
                            
                        </div>	

                        <div class="form-group mt-2">
                                <input type="email" class="form-style" name="correo"placeholder="Correo">
                        </div>

                        <div class="form-group mt-2">
                            <input type="password" class="form-style" placeholder="Password" name="psw">
                            
                        </div>
                        <input type="submit" class="btn mt-4" value="Login" name="Login" >
                </div>
            </div>
        </div>
    </div>
</div>
</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
</div>


    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>