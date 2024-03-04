<?php

include ('conexion.php');

if(isset($_GET['documento_v'])){
$documento_v=(int) $_GET['documento_v'];
$delete=$con->prepare('DELETE FROM cliente WHERE documento_v=:documento_v');
$delete->execute(array(
    ':documento_v'=>$documento_v
));
   header('Location: index_cliente.php');
}else{
    header('Location: index_cliente.php');
}
?>