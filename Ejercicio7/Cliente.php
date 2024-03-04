<?php

session_start();
include('Conexion.php');

date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['id_registro']) ){
    session_destroy();
    header("Location:Inicio_sesion.php"); 
}

if (($_SESSION['id_usuario']!=1)) {
    
	switch ($_SESSION['id_usuario']){
       case 1:echo"<script>
	   window.location.href = 'Cliente.php';
	   </script>";
        break;
	   case 2:echo"<script>
	   window.location.href = 'Administrador.php';
	   </script>";
	}   
}



$idusuario=$_SESSION['id_registro'];


$Sql1="SELECT id,nombre FROM usuarios WHERE id='$idusuario' ";
$Resultado=$conexion->query($Sql1); 
$Row=$Resultado->fetch_assoc();


$Sql2="SELECT * FROM servicios ";
$Resultado2=$conexion->query($Sql2); 
$Row2=$Resultado2->fetch_assoc();


$Sql3="SELECT * FROM tipo_vehiculo ";
$Resultado3=$conexion->query($Sql3); 
$Row3=$Resultado3->fetch_assoc();


//register
if (isset($_POST["registrar"])) {
  
  $Servicio=mysqli_real_escape_string($conexion, $_POST['Servicio']);
  $Vehiculo=mysqli_real_escape_string($conexion, $_POST['Vehiculo']);
  $telefono=mysqli_real_escape_string($conexion, $_POST['telefono']);
  $Placa=mysqli_real_escape_string($conexion, $_POST['Placa']);
  

  if(!empty($Servicio) && !empty($Vehiculo) && !empty($telefono) && !empty($Placa)  ){
    $sqlvehiculo="SELECT ID_Vehiculos FROM vehiculos WHERE Placa='$Placa'"; 
    $resultadovehiculo=$conexion->query($sqlvehiculo);
    $vehiculo=$resultadovehiculo->num_rows;
    
    if($vehiculo>=1){
      echo "<script>
              alert('El vehiculo ya esta registrado  ');
              window.location.Cliente.php;
          </script>";
    
  }else{
     
    //insertar el registro
    $tiempo=time();

    $time = date("H:i:s", $tiempo);
    $date = date("Y-m-d", $tiempo);
    $sqlusuario = "INSERT INTO vehiculos (Placa,contacto, FK_Servicios, FK_Vehiculos_T, FK_Usuarios,Fecha_Ingreso,Hora_Sa)
    VALUES ('$Placa', '$telefono', '$Servicio', '$Vehiculo', '$idusuario','$date','$time')";
    $resultadousuario = $conexion->query($sqlusuario);
       
      if($resultadousuario==true){
          echo "<script>
                  alert('Registro exitoso');
                  window.location.Cliente.php;
              </script>";
      }else{
          echo "<script>
                  alert('Error al registrar');
                  window.location.Cliente.php;
              </script>";
      }
  }
  
}else{
  echo "<script>
  alert('no digito ningun dato');
  window.location.Cliente.php;
  </script>";
}
}



$select_vehiculos=$conection->prepare('SELECT * FROM vehiculos ORDER BY ID_Vehiculos DESC');

 $select_vehiculos->execute();
 $resultado_vehiculos=$select_vehiculos->fetchALL();

 if(isset($_POST['btn_buscar'])){
    $buscar_texto=$_POST['buscar'];
  
    $select_buscar=$conection->prepare('SELECT * FROM vehiculos WHERE FK_Usuarios LIKE :campo OR $Placa LIKE :campo ;');
    
  

 $select_buscar->execute(array(':campo' => "%". $buscar_texto. "%"));
 $resultado_vehiculos=$select_buscar->fetchALL();

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

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="Salir.php"><?php  echo utf8_decode($Row['nombre']);?></a>
 
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="Salir.php">Salir</a>
      </li>
    </ul>
  </div>
</nav>

  <div class="container d-flex justify-content-center align-items-center fondo" style="min-height: 100vh;">    
    <div class="Menu text-center p-4">
        
	         <h2 >Administrar vehiculo</h2>

        <button type="button" class="btn btn-unstyled p-0 boton1" data-bs-toggle="modal" data-bs-target="#myModal3"  data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar vehiculo">
            <lord-icon
                src="https://cdn.lordicon.com/crithpny.json"
                trigger="hover"
                style="width:100px;height:100px">
            </lord-icon>
        </button>
         <a href="CRUD_CLIENTE.php">
        <button type="button"  class="btn btn-unstyled p-0 boton2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Sacar vehiculo">
            <lord-icon
                src="https://cdn.lordicon.com/isrpughu.json"
                trigger="hover"
                style="width:100px;height:100px">
            </lord-icon>
        </button>
        </a>

    </div>
</div>



<!-- Modales -->

<div class="modal" id="myModal3">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Registrar vehiculo </h4>
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
                            <h4 class="mb-3 pb-3">Datos de su vehiculo1</h4>
                            <div class="form-group col-12">
                                <select class="custom-select" id="inputGroupSelect01" name="Servicio" id="cod_programac">
                                    <option value="<?php echo $Row2['ID_SERVICIOS']; ?>"><?php echo "Seleccione el tipo de servicio" ?></option>
                                    <?php
                                    $registros = mysqli_query($conexion, "SELECT ID_SERVICIOS, T_Servicios FROM Servicios ORDER BY ID_SERVICIOS ") or die("Problemas en el select:" . mysqli_error($conexion));

                                    while ($reg = mysqli_fetch_array($registros)) {
                                        echo "<option value=\"$reg[ID_SERVICIOS]\">$reg[T_Servicios]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-12 mt-2">
                                <select class="custom-select" id="inputGroupSelect02" name="Vehiculo" id="cod_programac">
                                    <option value="<?php echo $Row3['ID_Vehiculo']; ?>"><?php echo "Seleccione el tipo de vehiculo" ?></option>
                                    <?php
                                    $registros = mysqli_query($conexion, "SELECT ID_Vehiculo, T_vehiculos FROM tipo_vehiculo ORDER BY ID_Vehiculo ") or die("Problemas en el select:" . mysqli_error($conexion));

                                    while ($reg = mysqli_fetch_array($registros)) {
                                        echo "<option value=\"$reg[ID_Vehiculo]\">$reg[T_vehiculos]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-12 mt-2">
                                <input type="tel" class="form-style form-control" name="telefono" placeholder="Telefono">
                            </div>
                            <div class="form-group col-12 mt-2">
                                <input type="text" class="form-style form-control" name="Placa" placeholder="Placa">
                            </div>
                            <button type="submit" name="registrar" class="btn mt-4">Register</button>
                        </div>
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
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Dejar Parqueadero</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
   <div class="contenedor">
      <h2>Clientes</h2>
      <div class="barra__buscador">
         <form action="" class="formulario" method="post">
            <input type="text" name="buscar" placeholder="Buscar Cliente"
            value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
            <input type="submit" class="btn" name="btn_buscar" value="Buscar">
            <a href="insert_cliente.php" class="btn btn__nuevo">Nuevo</a>
         </form>
      </div>
      <table>
        <tr class="head">
            <td>Documentos</td>
            <td>nombre</td>
            <td>apellido</td>
            <td colspan="2">Accion</td>
        </tr>
        <?php foreach($resultado_vehiculos as $fila):?>
            <tr>
                <td><?php echo $fila['Placa'];?></td>
                <td><?php echo $fila['contacto'];?></td>
                <td><?php echo $fila['Fk_Usuarios'];?></td>
                <td><?php echo $fila['FK_Servicios'];?></td>
                <td><?php echo $fila['FK_Vehiculos_T'];?></td>
                <td><?php echo $fila['Fecha_Ingreso'];?></td>
                <td><?php echo $fila['Hora_Sa'];?></td>
                <td><?php echo $fila['Hora_En'];?></td>
                <td><a href="update_cliente.php?documento_v=<?php echo $fila['documento_v']; ?>" class="btn__update" >editar</a></td>
                <td><a href="delete_cliente.php?documento_v=<?php echo $fila['documento_v']; ?>" class="btn__delete" >eliminar</a></td>
            </tr>
            <?php endforeach ?>
      </table>
   </div>
    
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