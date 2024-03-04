<?php
   include_once('conexion.php');

   if(isset($_POST['guardar'])){
    $documento_v=$_POST['documento_v'];
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];

      if(!empty($documento_v) && !empty($nombre) && !empty($apellido)){

            $consulta_insert=$con->prepare('INSERT INTO cliente(documento_v,nombre,apellido) VALUES (:documento_v,:nombre,:apellido)');
            $consulta_insert->execute(array(':documento_v'=>$documento_v,
            ':nombre'=>$nombre,
            ':apellido'=>$apellido
      ));
      header('Location:index_cliente.php');
    }else{
        echo"<script> alert('Los campos estan vacios');</script>";
     }
   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/estilo.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor">
        <h2>Crear cliente</h2>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="documento_v" placeholder="documento" class="input__text">
                <input type="text" name="nombre" placeholder="Nombre" class="input__text">
            </div>

            <div class="form-group">
                 <input type="text" name="apellido" placeholder="apellido" class="input__text">
            </div>

            <div class="btn__group">
                 <a href="index_cliente.php" class="btn btn__danger">cancelar</a>
                 <input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
            </div>

        </form>
    </div>
    
</body>
</html>