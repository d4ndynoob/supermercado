<?php
session_start();
if (empty($_SESSION["id"])) {
  header('location: index.php');
}
require('../scripts/conexion.php');
$idUsuario = $_SESSION["id"];
$sql = $conexion->query("SELECT * FROM pedidos WHERE idUsuario = '$idUsuario'");

$pedidos = array();
while ($row = $sql->fetch_object()) {
  $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos</title>

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
        if(!empty($pedidos)) {
          echo '
          <div class="w-full bg-[#F7F8F9] grid grid-cols-4 py-4 px-8">
            <p class="text-base font-semibold text-center">Número de pedido:</p>
            <p class="text-base font-semibold text-center">Fecha del pedido:</p>
            <p class="text-base font-semibold text-center">Precio total:</p>
            <div></div>
          </div>
          ';

          foreach ($pedidos as $pedido) {
            echo '
              <!-- Pedidos card -->
              <form action="detalles.php" method="GET" class="w-full h-[150px] border grid grid-cols-4 px-8 items-center text-center">
                <p>'.$pedido->id .'</p>
                <p>'.$pedido->fecha .'</p>
                <p>$'.$pedido->total .'</p>
                <button type="submit" name="detalles" class="mx-auto w-1/2 px-2 py-3 rounded-lg bg-[var(--colorPrimario)] text-white focus:opacity-70 hover:opacity-70" >Ver detalles</button>
                <input type="hidden" name="pedido_id" value="'.$pedido->id.'">
              </form>
              ';
          }
        } else {
          echo '
            <p>No tienes pedidos</p>
          ';
        }
      ?>
    </div>
  </div>
</body>

</html>