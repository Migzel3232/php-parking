<?php
include("conexion.php");

 $sentencia_select=$con->prepare('SELECT * FROM cliente ORDER BY documento_v DESC');

 $sentencia_select->execute();
 $resultado=$sentencia_select->fetchALL();

 if(isset($_POST['btn_buscar'])){
    $buscar_text=$_POST['buscar'];
  
    $select_buscar=$con->prepare('SELECT * FROM cliente WHERE nombre LIKE :campo OR documento_v LIKE :campo ;');
    
  

 $select_buscar->execute(array(':campo' => "%". $buscar_text. "%"));
 $resultado=$select_buscar->fetchALL();

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
        <?php foreach($resultado as $fila):?>
            <tr>
                <td><?php echo $fila['documento_v'];?></td>
                <td><?php echo $fila['nombre'];?></td>
                <td><?php echo $fila['apellido'];?></td>
                <td><a href="update_cliente.php?documento_v=<?php echo $fila['documento_v']; ?>" class="btn__update" >editar</a></td>
                <td><a href="delete_cliente.php?documento_v=<?php echo $fila['documento_v']; ?>" class="btn__delete" >eliminar</a></td>
            </tr>
            <?php endforeach ?>
      </table>
   </div>
    
</body>
</html>