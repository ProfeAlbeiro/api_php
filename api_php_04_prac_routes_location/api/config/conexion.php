<?php
function conexion() {
    $servername = "localhost";
    $dbname = "db";
    $port = "3307";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}
?>