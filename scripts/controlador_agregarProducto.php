<?php
  if(isset($_POST["agregar"])){

      $id = $_SESSION["id"];
      $product_id = $_POST["product_id"];

      // Insertamos el producto en el carrito
      $sql2 = $conexion->query("insert into productos_carritos(idUsuario, idProducto) values ( '$id', '$product_id')");

      // 0 = error ; 1 = todo bien
      if($sql2 == 1) {
        echo 'se agrego el producto al carrito';
        header('location: home.php');
      } else {
        echo 'no se agrego el producto al carrito';
      }
  }
?>
