<?php
session_start();

include('Conexion.php');


if (!isset($_SESSION['id_registro']) ){
    header("Location:Form.php"); 
}

if (($_SESSION['id_usuario']!=3)) {
    
	switch ($_SESSION['id_usuario']){
       case 1:echo"<script>
	   window.location.href = 'Form 1.php';
	   </script>";
        break;
	   case 2:echo"<script>
	   window.location.href = 'Form 2.php';
	   </script>";
        break;
	   case 3: echo"<script>
	   window.location.href = 'Form 3.php';
	   </script>";
	}
   
}
$idusuario=$_SESSION['id_registro'];


$Sql1="SELECT id,usuario FROM usuarios WHERE id='$idusuario' ";
$Resultado=$conexion->query($Sql1); 
$Row=$Resultado->fetch_assoc();

?>




<!doctype html>
<html lang="en">
<head>
  <title>Inicio de Sesion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="Diseño.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><?php  echo utf8_decode($Row['usuario']);?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="Salir.php">Salir</a>
      </li>
    </ul>
  </div>
</nav>


<form action="" method="POST">
	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Calculadora IMC </span></h6>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Digite la informacion</h4>

											<div class="form-group">
												<input type="text" id="Nombre" step="0.01" required class="form-style" placeholder="Nombre paciente" >	
											</div>	
											<div class="form-group mt-2">
												<input type="Number" id="Numero2" step="0.01" required class="form-style" placeholder="Peso en kilogramos" >
											</div>	
                                            <div class="form-group mt-2">
												<input type="Number" id="Numero3" step="0.01" required class="form-style" placeholder="Estatura en metros" >
											</div>

                                            <button type="button" class="btn mt-4" onclick="IMC()">Calcular</button>
				      					</div>
			      					</div>
			      				</div>

			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
    </form>

    <script>

function IMC() {
  var nombre = document.getElementById("Nombre").value;
  var num2 = document.getElementById("Numero2").value;
  var num3 = document.getElementById("Numero3").value;

  // Convertir los valores a números (ya que los valores de los inputs son cadenas)
  num2 = parseFloat(num2);
  num3 = parseFloat(num3);

  alert("El resultado de la operación es: " + num3);
  var estatura= num3**2;
  var IMC = num2 / estatura;
  alert("El resultado de la operación es: " + num2);

  if (IMC < 18.5) {
    alert("Por debajo del peso con IMC " + IMC);
  } else if (IMC >= 18.5 && IMC <= 24.9) {
    alert("Saludable con IMC " + IMC);
  } else if (IMC >= 25.0 && IMC <= 29.9) {
    alert("Con sobrepeso " + IMC);
  } else if (IMC >= 30.0 && IMC <= 39.9) {
    alert("Obeso " + IMC);
  } else {
    alert("Morbida " + IMC);
  }

  alert("El resultado de la operación es: " + IMC);
}



</script>

</body>
</html>