<?php
require_once '../controllers/LocationController.php';

$conn = require_once '../config/conexion.php'; // Obtener la conexión a la base de datos

$locationController = new LocationController($conn);

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

switch ($method . ' ' . $path) {
    case 'GET /locations':
        $locationController->listarLocations();
        break;
    case 'GET /locations/':
        $id = $_GET['id'];
        $locationController->obtenerLocation($id);
        break;
    case 'POST /locations':
        $data = json_decode(file_get_contents("php://input"), true);
        $locationController->crearLocation($data);
        break;
    case 'PUT /locations/':
        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);
        $locationController->actualizarLocation($id, $data);
        break;
    case 'DELETE /locations/':
        $id = $_GET['id'];
        $locationController->eliminarLocation($id);
        break;
    default:
        http_response_code(404);
        echo json_encode(['mensaje' => 'Ruta no encontrada']);
        break;
}
?>