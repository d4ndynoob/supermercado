<?php
  session_start();
  
  if(!empty($_POST["btnRegister"])) {

    // Si no estan vacios los campos...
    if(!empty($_POST["nombre"]) and !empty($_POST["ap_paterno"]) and !empty($_POST["correo"]) and !empty($_POST["password"])) {
      
      // Almacenamos los datos del formulario
      $nombre = $_POST["nombre"];
      $ap_paterno = $_POST["ap_paterno"];
      $correo = $_POST["correo"];
      $password = md5($_POST["password"]);

      // Creamos la consulta
      $sql = $conexion->query("insert into usuarios(email, password, nombre, apellido) values ('$correo', '$password', '$nombre', '$ap_paterno')");
      
      // 0 = error ; 1 = todo bien
      if($sql == 1) {
        // Obtenemos el usuario que registramos para tener su id
        $sql2 = $conexion->query("select * from usuarios where email = '$correo'");

        
        // Si la consulta de arriba se realiza con exito
        if($datos = $sql2->fetch_object()) {
          
          // Guardamos el usuario en variables de sesion
          $_SESSION["id"] = $datos->id;
          $_SESSION["email"] = $datos->email;
          $_SESSION["password"] = $datos->password;
          $_SESSION["nombre"] = $datos->nombre;
          $_SESSION["apellido"] = $datos->apellido;
          
          // Creamos un carrito insertando como llave foranea el id del usuario creado
          $sql3 = $conexion->query("insert into carritos(total, idUsuario) values ('0', '$datos->id')");

          // Redireccionamos a Home
          header("location: home.php");
        }

      } else {
        echo 'error';
      }
    } else {
      echo 'campos vacios';
    }
  }
?>