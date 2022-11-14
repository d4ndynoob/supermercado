<?php
session_start();
if (empty($_SESSION["id"])) {
  header('location: index.php');
}
require('../scripts/conexion.php');

// Consultamos todos los productos de la bd
$sql = $conexion->query("select * from productos");

while ($row = $sql->fetch_object()) {
  $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <!-- css -->
  <link rel="stylesheet" href="../fonts.css">
  <link rel="stylesheet" href="../styles.css">

</head>

<body>
  <!-- Header -->
  <?php
  include('../components/header.php');
  require('../scripts/controlador_agregarProducto.php');
  ?>

  <div class="bg-white w-full">
    <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">Ofertas relampago</h2>

      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

        <!-- Tarjeta -->
        <?php
        foreach ($productos as $producto) {
          if ($producto->stock > 0) {
            echo '
            <form class="group relative flex flex-col justify-between mt-5" type="submit" method="POST" action="">
              <div class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                <img src="../img/' . $producto->img . '.png" alt="" class="h-full w-full object-contain object-center lg:h-full lg:w-full">
              </div>
              <div class="mt-4 flex justify-between space-x-1">
                <div class="w-3/5">
                  <h3 class="text-sm text-gray-700 font-semibold">
                    <a href="#">' . $producto->nombre . '</a>
                  </h3>
                  <p class="mt-1 text-sm text-gray-500 font-medium">Stock: ' . $producto->stock . '</p>
                </div>
                <p class="text-lg font-semibold text-gray-900 w-2/5 text-right">$' . $producto->precio . '</p>
              </div>
              <button type="submit" name="agregar" class="mt-8 w-full px-2 py-3 rounded-lg bg-[var(--colorPrimario)] text-white focus:opacity-70 hover:opacity-70" >Agregar al carrito</button>
              <input type="hidden" name="product_id" value="' . $producto->id . '"/>
            </form>
            ';
          }
        }
        ?>
      </div>
    </div>
  </div>

</body>

</html>