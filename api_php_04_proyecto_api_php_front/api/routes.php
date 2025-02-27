<?php
require_once 'controllers/LocationController.php';
require_once '../core/Router.php';
require_once 'config/conexion.php'; // Incluir el archivo conexion.php

$conn = conexion(); // Obtener la conexión a la base de datos
//Verificamos que la conexion se realizo correctamente.
if($conn){

    $router = new Router();

    $router->addRoute('GET', '/locations', 'LocationController', 'listarLocations', $conn);
    $router->addRoute('GET', '/locations/{id}', 'LocationController', 'obtenerLocation', $conn);
    $router->addRoute('POST', '/locations', 'LocationController', 'crearLocation', $conn);
    $router->addRoute('PUT', '/locations/{id}', 'LocationController', 'actualizarLocation', $conn);
    $router->addRoute('DELETE', '/locations/{id}', 'LocationController', 'eliminarLocation', $conn);

    $router->route();
}

?>