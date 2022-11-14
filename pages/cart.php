<?php

session_start();
if (empty($_SESSION["id"])) {
  header('location: index.php');
}
require('../scripts/conexion.php');

// Consultamos todos los productos del carrito de la bd
$idUsuario = $_SESSION["id"];

$sql = $conexion->query("SELECT productos_carritos.id AS 'producto_carrito_id', productos.nombre AS 'producto', productos.precio, productos.img, categorias.nombre AS 'categoria' FROM productos JOIN productos_carritos ON productos.id = productos_carritos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE productos_carritos.idUsuario = '$idUsuario'");

$suma = $conexion->query("SELECT SUM(productos.precio) AS 'suma' FROM productos JOIN productos_carritos ON productos.id = productos_carritos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE productos_carritos.idUsuario = '$idUsuario'");

$res = $suma->fetch_array();
$total = $res['suma'];

$productos_carrito = array();
while ($row = $sql->fetch_object()) {
  $productos_carrito[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito</title>

  <!-- css -->
  <link rel="stylesheet" href="../fonts.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="min-h-screen flex flex-col">
  <!-- Header -->
  <?php
  include('../components/header.php');
  require('../scripts/controlador_eliminarProducto.php');
  require('../scripts/controlador_comprar.php');
  ?>

  <!-- Contenedor inferior -->
  <div class="w-full flex-1 p-16 flex relative gap-x-10">

    <!-- Contenedor izquierdo donde aparecen los productos -->
    <div class="w-3/5">

      <?php
      if (empty($productos_carrito)) {
        echo '
            <div class="w-full h-[200px] bg-[#F5F5F5] px-16 py-8 rounded flex flex-col items-start justify-center">
              <p class="text-lg font-semibold">No tienes productos en tu carrito</p>
              <a href="./home.php" class="w-1/3 text-center rounded-sm bg-[var(--colorPrimario)] py-2 text-white font-medium hover:opacity-75 mt-5">Ir a comprar</a>
            </div>
          ';
      } else {
        foreach ($productos_carrito as $producto) {
          echo '
            <!-- Card -->
            <form  action="" method="post" class="w-full h-[230px] bg-[#F5F5F5] mb-[20px] flex justify-between items-center py-5 px-16 gap-x-10 rounded duration-300 hover:shadow-md">
              <!-- Contenedor izq -->
              <div class="w-2/5 h-full overflow-hidden">
                <img src="../img/' . $producto->img . '.png" alt="" class="object-contain w-full h-full">
              </div>
      
              <!-- Contenedor derecho con los datos -->
              <div class="w-3/5 h-full flex flex-col justify-between items-start">
                <!-- Datos -->
                <div class="flex flex-col">
                  <h2 class="text-2xl font-semibold mt-2">' . $producto->producto . '</h2>
                  <h3 class="text-sm font-light mt-2">' . $producto->categoria . '</h3>
                  <h4 class="text-lg font-semibold mt-2">$' . $producto->precio . '</h4>
                </div>
      
                <!-- Boton -->
                <button type="submit" name="eliminar" class="w-full rounded-sm bg-[var(--colorPrimario)] py-2 text-white font-medium hover:opacity-75">Eliminar</button>
                <input type="hidden" name="producto_carrito_id" value="' . $producto->producto_carrito_id . '"/>
                </div>
            </form>
            ';
        }
      }
      ?>

    </div>

    <!-- Contenedor derecho donde aparece el total y boton pagar -->
    <?php
    if (!empty($productos_carrito)) {
      echo '
        <form class="w-[420px] h-max py-8 px-16 rounded bg-[#F5F5F5] fixed right-16" action="" method="post">
        <h3 class="mb-3 text-base font-medium">Resumen de compra</h3>
        <hr>
        <div class="w-full flex justify-between items-center py-5 text-lg">
          <p>Total</p>
          <span class="font-semibold">$' . $total . '</span>
        </div>
        <button type="submit" name="comprar" class="mt-8 w-full rounded-sm bg-[var(--colorPrimario)] py-2 text-white font-medium hover:opacity-75">Comprar</button>
      </form>
          ';
    }
    ?>
  </div>
  </div>
</body>

</html>