<?php
require_once '../api/controllers/LocationController.php';
require_once '../core/Router.php';
require_once '../api/config/DbConn.php';

$conn = DbConn::connection();

if ($conn) {
    $router = new Router();

    $router->addRoute('GET', '/locations', 'LocationController', 'listarLocations', $conn);
    $router->addRoute('GET', '/locations/{id}', 'LocationController', 'obtenerLocation', $conn);
    $router->addRoute('POST', '/locations', 'LocationController', 'crearLocation', $conn);
    $router->addRoute('PUT', '/locations/{id}', 'LocationController', 'actualizarLocation', $conn);
    $router->addRoute('DELETE', '/locations/{id}', 'LocationController', 'eliminarLocation', $conn);

    $router->route();
} else {
    http_response_code(500);
    echo json_encode(['mensaje' => 'Error de conexión a la base de datos']);
}
?>