<?php

if (isset($_POST["comprar"])) {
  $idUsuario = $_SESSION["id"];
  $pedidoDisponible = true;

  // Consulta para obtener la cantidad de productos del carrito sin repetir
  // bicicletas 2
  // telefonos 5
  $sql = $conexion->query("SELECT productos.id, productos.nombre as 'nombre', COUNT(productos.id) AS 'cont' FROM productos JOIN productos_carritos ON productos.id = productos_carritos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE productos_carritos.idUsuario = '$idUsuario' GROUP BY productos.id");

  // Por cada producto del carrito de compras (la consulta de arriba nos devuelve un array)
  while ($row = $sql->fetch_array()) {

    // imprimimos los datos del producto
    // echo $row['id']. ' '.$row['nombre']. ' ' .$row['cont'] .' ';
    $idProducto = $row['id'];

    // Ejecutamos consulta para obtener el stock del producto en la base de datos
    $sql2 = $conexion->query("SELECT stock FROM productos WHERE id = '$idProducto'");

    // La consulta nos devuelve un objeto y lo leemos con la siguente linea
    if ($datos = $sql2->fetch_object()) {
      // echo $datos->stock;

      // Aqui haremos una comparacion del stock con los productos que se pretenden comprar
      if ($row['cont'] <= $datos->stock) {
        // echo 'stock disponible para ' .$row['nombre'];
      } else {
        echo 'No hay stock disponible para ' . $row['nombre'];
        $pedidoDisponible = false;
        break;
      }
    }
    echo '<br>';
  }

  // Despues de haber recorrido cada producto del carrito se comprueba si esta disponible o no con la variable
  if ($pedidoDisponible) {

    // * * * * * * * * * * * * * * * CREAMOS PEDIDO * * * * * * * * * * * * * * * *
    date_default_timezone_set("America/Mexico_City");
    $fechaActual = date("Y-m-d");
    $sql4 = $conexion->query("INSERT INTO pedidos(total, fecha, idUsuario) VALUES ('$total', '$fechaActual', '$idUsuario')");
    $idPedido = $conexion->insert_id;

    // * * * * * * * * * * MODIFICAMOS STOCK DEL PRODUCTO EN BD * * * * * * * * * * * * * * * 
    $sql = $conexion->query("SELECT productos.id, productos.nombre as 'nombre', COUNT(productos.id) AS 'cont' FROM productos JOIN productos_carritos ON productos.id = productos_carritos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE productos_carritos.idUsuario = '$idUsuario' GROUP BY productos.id");

    // Modificamos cada producto que tiene el carrito
    while ($row = $sql->fetch_array()) {
      $idProducto = $row['id'];

      // Ejecutamos consulta para obtener el stock del producto en la base de datos
      $sql2 = $conexion->query("SELECT stock FROM productos WHERE id = '$idProducto'");

      // La consulta nos devuelve un objeto y lo leemos con la siguente linea
      if ($datos = $sql2->fetch_object()) {

        // Aqui quitaremos el stock necesario para la compra
        $nuevoStock = $datos->stock - $row['cont'];


        // * * * * * * * * * * * * * * * LLENAMOS TABLA PRODUCTOS PEDIDOS CON CADA PRODUCTO * * * * * * * * * * * * * * 
        for ($i=0; $i < $row['cont']; $i++) {
          // Creamos un registro en la tabla Productos_Pedidos por cada producto
          $sql5 = $conexion->query("INSERT INTO productos_pedidos (idProducto, idPedido) VALUES ('$idProducto', '$idPedido')");
        }

        // Consulta para actualizar stock en bd
        $sql3 = $conexion->query("UPDATE productos SET stock = '$nuevoStock' WHERE id = '$idProducto'");

      }
    }

    // * * * * * * * * * * * * * * * VACIAMOS CARRITO DE COMPRAS * * * * * * * * * * * * * *
    $sql6 = $conexion->query("DELETE FROM productos_carritos WHERE idUsuario = '$idUsuario'");

    echo 'Pedido realizado con exito';
    header('location: home.php');
  }
}
