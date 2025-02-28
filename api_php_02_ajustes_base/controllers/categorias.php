<?php
header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../models/categoria.php");

$categoria = new Categoria();

// Función para manejar errores y enviar respuestas JSON consistentes
function enviarRespuesta($codigo, $mensaje, $datos = null) {
    http_response_code($codigo);
    echo json_encode(['mensaje' => $mensaje, 'datos' => $datos]);
    exit; // Detener la ejecución del script después de enviar la respuesta
}

$body = json_decode(file_get_contents("php://input"), true);

// Rutas usando métodos HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Obtener categorías
        if (isset($_GET['id'])) { // Obtener una categoría por ID
            try {
                $datos = $categoria->get_categoria_x_id($_GET['id']);
                if ($datos) {
                    enviarRespuesta(200, "Categoría obtenida", $datos);
                } else {
                    enviarRespuesta(404, "Categoría no encontrada");
                }
            } catch (Exception $e) {
                enviarRespuesta(500, "Error al obtener la categoría: " . $e->getMessage());
            }
        } else { // Obtener todas las categorías
            try {
                $datos = $categoria->get_categoria();
                enviarRespuesta(200, "Categorías obtenidas", $datos);
            } catch (Exception $e) {
                enviarRespuesta(500, "Error al obtener las categorías: " . $e->getMessage());
            }
        }
        break;

    case 'POST': // Insertar una nueva categoría
        try {
            // Validar datos de entrada
            if (empty($body['cat_nom']) || empty($body['cat_obs'])) {
                enviarRespuesta(400, "Datos de entrada inválidos");
            }

            $datos = $categoria->insert_categoria($body['cat_nom'], $body['cat_obs']);
            enviarRespuesta(201, "Categoría creada", $datos); // 201 Created
        } catch (Exception $e) {
            enviarRespuesta(500, "Error al crear la categoría: " . $e->getMessage());
        }
        break;

    case 'PUT': // Actualizar una categoría existente
        try {
            // Validar datos de entrada
            if (empty($body['cat_id']) || empty($body['cat_nom']) || empty($body['cat_obs'])) {
                enviarRespuesta(400, "Datos de entrada inválidos");
            }

            $datos = $categoria->update_categoria($body['cat_id'], $body['cat_nom'], $body['cat_obs']);
            enviarRespuesta(200, "Categoría actualizada", $datos);
        } catch (Exception $e) {
            enviarRespuesta(500, "Error al actualizar la categoría: " . $e->getMessage());
        }
        break;

    case 'DELETE': // Eliminar una categoría
        try {
            // Validar datos de entrada
            if (empty($body['cat_id'])) {
                enviarRespuesta(400, "ID de categoría inválido");
            }

            $categoria->delete_categoria($body['cat_id']);
            enviarRespuesta(204, "Categoría eliminada"); // 204 No Content
        } catch (Exception $e) {
            enviarRespuesta(500, "Error al eliminar la categoría: " . $e->getMessage());
        }
        break;

    default:
        enviarRespuesta(405, "Método no permitido"); // 405 Method Not Allowed
        break;
}
?>