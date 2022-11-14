<?php

  // Iniciamos sesion 
  session_start();

  if (!empty($_POST["btnLogin"])) {
    // Si no estan vacios los campos...
    if(!empty($_POST["correo"]) and !empty($_POST["password"])) {
      // Almacenamos los datos del formulario
      $email = $_POST["correo"];
      $password = md5($_POST["password"]);

      // Consulta
      $sql = $conexion->query("select * from usuarios where email = '$email' and password = '$password'");

      // Si el usuario existe...
      if ($datos = $sql->fetch_object()) {

        // Guardamos el usuario en variables de sesion
        $_SESSION["id"] = $datos->id;
        $_SESSION["email"] = $datos->email;
        $_SESSION["password"] = $datos->password;
        $_SESSION["nombre"] = $datos->nombre;
        $_SESSION["apellido"] = $datos->apellido;

        header("location: home.php");
      } else {
        echo "acceso denegado";
      }
      
    } else {
      echo "campos vacios";
    }
  }
?>