<?php
session_start();
include('Conexion.php');



$idusuario=$_SESSION['id_registro'];

$Sql1="SELECT id,nombre FROM usuarios WHERE id='$idusuario' ";
$Resultado=$conexion->query($Sql1); 
$Row=$Resultado->fetch_assoc();



 $select_vehiculos=$conection->prepare('SELECT * FROM vehiculos,servicios,tipo_vehiculo WHERE ID_SERVICIOS=FK_Servicios AND ID_Vehiculo=FK_Vehiculos_T ORDER BY ID_Vehiculos DESC');
 $select_vehiculos->execute();
 $resultado_vehiculos=$select_vehiculos->fetchALL();

 if(isset($_POST['btn_buscar'])){
    $buscar_texto=$_POST['buscar'];

    if (isset($_POST['btn_buscar'])) {
        $buscar_texto = $_POST['buscar'];
    
        if (!empty($buscar_texto) && strtolower($buscar_texto) != 'placa' && !empty($resultado_vehiculos)) {

            $select_buscar = $conection->prepare('SELECT * FROM vehiculos, servicios, tipo_vehiculo 
                                                WHERE ID_SERVICIOS=FK_Servicios AND ID_Vehiculo=FK_Vehiculos_T 
                                                AND LOWER(Placa) LIKE :campo;');
            $select_buscar->execute(array(':campo' => "%" . strtolower($buscar_texto) . "%"));
            $resultado_vehiculos = $select_buscar->fetchAll();
    
            // Verifica si no se encontraron resultados
            if (empty($resultado_vehiculos)) {
                echo "<script>alert('Placa no encontrada');
                window.location.href = 'CRUD_CLIENTE.php';

                
                </script>";
            }
             
        } else {
            echo '<script>alert("Placa inválida y placa no encontrada");
            
            </script>';
        }
    }
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rB9Do1vvNTdPDfiEhFff6V04vcwMvp4PbDYY0RX+8bI/JqjI93u6t/dW5lZiCzX2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Diseñov3.css">
    <title>Document</title>
</head>
<body>
    
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="Cliente.php"><?php  echo utf8_decode($Row['nombre']);?></a>
 
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="CRUD_CLIENTE.php">Regresar</a>
      </li>
    </ul>
  </div>
</nav>

<div class="Fondo">
   <div class="contenedor">
      <h2>Clientes</h2>
      <div class="barra__buscador">
         <form action="" class="formulario" method="post">
            <input type="text" name="buscar" placeholder="Buscar Placa"
            value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
            <input type="submit" class="btn" name="btn_buscar" value="Buscar">
         </form>
      </div>
      <table>
        <tr class="head">
            <td>Placa</td>
            <td>Tipo servicio</td>
            <td>Tipo vehiculo</td>
            <td>Fecha ingreso</td>
            <td>Hora entrada</td>
            <td>Hora salida</td>
            <td colspan="2">Accion</td>
        </tr>
        <?php foreach($resultado_vehiculos as $fila):?>
            <tr>
                <td><?php echo $fila['Placa'];?></td>
                <td><?php echo $fila['T_Servicios'];?></td>
                <td><?php echo $fila['T_vehiculos'];?></td>
                <td><?php echo $fila['Fecha_Ingreso'];?></td>
                <td><?php echo $fila['Hora_Sa'];?></td>
                <td><?php echo $fila['Hora_En'];?></td>
                <td><a href="delete_cliente.php?documento_v= ?>" class="btn__delete" >sacar vehiculo</a></td>
            </tr>
            <?php endforeach ?>
      </table>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>