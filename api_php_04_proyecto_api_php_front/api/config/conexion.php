<?php
    $servername = "localhost";
    $username = "usuario";
    $password = "contraseña";
    $dbname = "basededatos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>