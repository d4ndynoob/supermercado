<?php
  if(isset($_POST["eliminar"])){
      $producto_carrito_id = $_POST["producto_carrito_id"];

      // eliminamos el producto del carrito
      $sql = $conexion->query("delete from productos_carritos where id = '$producto_carrito_id'");

      // 0 = error ; 1 = todo bien
      if($sql == 1) {
        echo 'se elimino el producto del carrito';
        header('location: cart.php');
      } else {
        echo 'no se elimino el producto del carrito';
      }
  }
?>