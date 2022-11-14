<?php
  $idUsuario = $_SESSION["id"];

  $cont = $conexion->query("SELECT COUNT(productos.id) AS 'cont' FROM productos JOIN productos_carritos ON productos.id = productos_carritos.idProducto JOIN categorias ON categorias.id = productos.idCategoria WHERE productos_carritos.idUsuario = '$idUsuario'");

  $res = $cont->fetch_array();
  $cont_productos = $res['cont'];
?>

<html>
  <link rel="stylesheet" href="../fa/css/all.css">

<header class="w-full h-[80px] bg-[var(--colorPrimario)] px-10 flex justify-between items-center gap-x-16 shadow-lg sticky top-0 z-50">
  
  <!-- Logo -->
  <a href="../pages/home.php" class="text-2xl font-semibold text-white tracking-wider">Supermercado</a>
  
  <!-- Pedidos -->
  <a href="../pages/pedidos.php" class="flex justify-center items-center gap-x-2">
    <i class="fa-solid fa-basket-shopping text-white text-2xl"></i>
    <h3 class="text-2xl font-medium text-white">Pedidos</h3>
  </a>

  <!-- Buscador -->
  <div class="flex-1 w-full flex justify-center items-center relative">
    <i class="fa-solid fa-magnifying-glass absolute right-5 text-xl text-gray-600"></i>
    <input type="text" name="buscar" id="buscar" placeholder="Buscar" class="w-full py-3 px-6 text-base pr-10 rounded-xl outline-none">
  </div>

  <!-- Hola / Perfil menú -->
  <div class="text-white flex flex-col items-end">
    <p>Hola <span class="font-semibold capitalize"><?php echo $_SESSION["nombre"]. ' '. $_SESSION["apellido"]; ?></span></p>
    <a href="../scripts/controlador_logout.php" class="w-max text-sm flex justify-end items-center gap-x-2 relative">
      <span class="text-base text-white font-bold">Salir</span>
      <i class="fa-solid fa-right-from-bracket"></i>
    </a>
  </div>

  <!-- Carrito -->
  <a href="../pages/cart.php" class="relative">
    <span class="absolute top-[-15px] right-[-12px] font-bold text-black text-xl"><?php echo $cont_productos ?></span>
    <i class="fa-solid fa-cart-shopping text-white text-2xl"></i>
  </a>

</header>
</html>