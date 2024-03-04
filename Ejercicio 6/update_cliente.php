<?php

include_once ('conexion.php');

if(isset($_GET['documento_v'])){
    $documento_v=(int) $_GET['documento_v'];

    $buscar_id=$con->prepare('SELECT * FROM cliente WHERE documento_v=:documento_v');

    $buscar_id->execute(array(
        ':documento_v'=>$documento_v
    ));
    $resultado=$buscar_id->fetch();
}else{
    header('Location: index_cliente.php');
}

if(isset($_POST['guardar'])){

     $nombre=$_POST['nombre'];
     $apellido=$_POST['apellido'];
     $documento_v=(int) $_GET['documento_v'];
     

     if(!empty($documento_v) && !empty($nombre) && !empty($apellido)) {
        $consulta_update=$con->prepare('UPDATE cliente SET 
         nombre=:nombre,
         apellido=:apellido
         
         WHERE documento_v=:documento_v'
         );

         $consulta_update->execute(array(
            ':nombre'=>$nombre,
            ':apellido'=>$apellido,
            ':documento_v'=>$documento_v
         ));
         header('Location: index_cliente.php');
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
        <h2>Editar informacion</h2>
        <form action="" method="post">
            <div class="form-group">
                <input readonly type="text" name="documento_v" value="<?php if($resultado) echo $resultado['documento_v'];?>" class="input__text">
                <input type="text" name="nombre" value="<?php if($resultado) echo $resultado['nombre'];?>" class="input__text">
            </div>
            <div class="form-group">
            <input type="text" name="apellido" value="<?php if($resultado) echo $resultado['apellido'];?>" class="input__text">
            </div>
            <div class="btn__group">
                <a href="index_cliente.php" class="btn btn__danger">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
            </div>
        </form>
    </div>
</body>
</html>
