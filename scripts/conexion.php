<?php
    $conexion = new mysqli("localhost","root","","supermercado");
    $conexion->set_charset("utf8");

    if (mysqli_connect_errno()){
        echo "Error: " . mysqli_connect_error();
    }
?>