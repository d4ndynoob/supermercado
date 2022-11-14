<?php
session_start();

if (empty($_GET["pedido_id"])) header('location: home.php');
if (empty($_SESSION["id"])) header('location: index.php');

require('../scripts/conexion.php');
$pedido_id = $_GET["pedido_id"];
$sql = $conexion->query("SELECT productos.nombre AS 'producto', productos.precio AS 'precio', productos.img, pedidos.total, categorias.nombre AS 'categoria' FROM pedidos JOIN productos_pedidos ON pedidos.id = productos_pedidos.idPedido JOIN productos ON productos.id = productos_pedidos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE pedidos.id = '$pedido_id'");

$productos = array();
while ($row = $sql->fetch_array()) {
  $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles</title>

  <!-- css -->
  <link rel="stylesheet" href="../fonts.css">
  <link rel="stylesheet" href="../styles.css">

</head>

<body class="min-h-screen flex flex-col">
  <?php
  include('../components/header.php');
  ?>

  <!-- Inferior pedidos -->
  <div class="w-full flex-1 py-20 px-28 flex relative gap-x-10">
    <div class="w-full">
      <!-- En caso de que el usuario ya tenga pedidos los vamos a mostrar -->
      <?php
      if (!empty($productos)) {
        echo '
          <div class="w-full bg-[#F7F8F9] grid grid-cols-4 py-4 px-8">
            <p class="text-base font-semibold text-center">Producto:</p>
            <p class="text-base font-semibold text-center">Precio:</p>
            <p class="text-base font-semibold text-center">Categoría:</p>
            <p class="text-base font-semibold text-center">Imágen:</p>
            <div></div>
          </div>
          ';
        foreach ($productos as $producto) {
          echo '
              <div class="w-full border grid grid-cols-4 p-8 items-center text-center">
                <p class="w-full">' . $producto["producto"] . '</p>
                <p class="w-full">$' . $producto["precio"] . '</p>
                <p class="w-full">' . $producto["categoria"] . '</p>
                <div class="w-[50%] mx-auto">
                  <img src="../img/' . $producto["img"] . '.png" class="h-full w-full object-contain " />
                </div>
              </div>
              ';
        }
      }
      ?>

    </div>
  </div>
</body>

</html>