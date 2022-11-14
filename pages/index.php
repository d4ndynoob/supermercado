<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Supermercado</title>

  <!-- css -->
  <link rel="stylesheet" href="../fonts.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="flex flex-col min-h-screen">

<?php
  require('../scripts/conexion.php');
  require('../scripts/controlador_login.php');
?>

  <!-- header -->
  <header class="w-full bg-[var(--colorPrimario)] h-[60px] px-16 flex items-center">
    <h2 class="text-2xl font-semibold text-white tracking-wider">Supermercado</h2>
  </header>

  <!-- resto de la pagina -->
  <div class="bg-white w-full flex-1 flex justify-center items-center py-16">
    <form action="" class="w-[400px]" method="POST">
      <h1 class="text-2xl font-medium mb-3">Inicia sesión</h1>
      <input type="email" name="correo" id="correo" placeholder="Correo electrónico*" class="w-full px-3 py-4 text-black text-base font-light border border-gray-300 rounded-md mb-4 outline-none duration-300 focus:border-[var(--colorPrimario)] focus:shadow-lg">
      <input type="password" name="password" id="password" placeholder="Contraseña* (8 caracteres mínimo)" class="w-full px-3 py-4 text-black text-base font-light border border-gray-300 rounded-md mb-4 outline-none duration-300 focus:border-[var(--colorPrimario)] focus:shadow-lg">
      <a href="/" class="text-[var(--colorPrimario)] mb-7 inline-block text-sm">¿Olvidaste tu contraseña?</a>
      <input type="submit" name="btnLogin" value="Iniciar sesión" class="w-full h-[50px] bg-[var(--colorPrimario)] rounded-md text-white font-medium mb-4 duration-300 hover:opacity-70 outline-none focus:opacity-70 cursor-pointer">
      <p class="text-sm text-center">¿Aun no tienes una cuenta? <a href="./register.php" class="text-[var(--colorPrimario)]">Crea una</a></p>
    </form>
  </div>

</body>

</html>