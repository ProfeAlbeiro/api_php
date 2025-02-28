<?php
    header('Content-Type: application/json');

    require_once "../config/DbConn.php";
    require_once("../models/Location.php");

    $location = new Location;

    // Función para manejar errores y enviar respuestas JSON consistentes
    function sendResponse($code, $message, $data = null) {
        http_response_code($code);
        echo json_encode(['message' => $message, 'datos' => $data]);
        exit;
    }

    $body = json_decode(file_get_contents("php://input"), true);

    // Rutas usando métodos HTTP (GET, POST, PUT, DELETE)
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                try {
                    $data = $location->getHousingLocationById($_GET['id']);
                    if ($data) {
                        sendResponse(200, "Ubicación de vivienda obtenida", $data);
                    } else {
                        sendResponse(404, "Ubicación de vivienda no encontrada");
                    }
                } catch (Exception $e) {
                    sendResponse(500, "Error al obtener la vivienda: " . $e->getMessage());
                }
            } else {
                try {
                    $data = $location->getAllHousingLocations();
                    sendResponse(200, "Viviendas y ubicación obtenidas", $data);
                } catch (Exception $e) {
                    sendResponse(500, "Error al obtener viviendas y ubicación: " . $e->getMessage());
                }
            }
            break;

        case 'POST':
            try {
                if (empty($body['name']) || empty($body['city']) || empty($body['state']) || empty($body['photo']) || empty($body['availableUnits']) || !isset($body['wifi']) || !isset($body['laundry'])) {
                    sendResponse(400, "Datos de entrada inválidos");
                }
                $data = $location->createHousingLocation(
                    $body['name'], 
                    $body['city'], 
                    $body['state'], 
                    $body['photo'], 
                    $body['availableUnits'], 
                    $body['wifi'], 
                    $body['laundry']);
                sendResponse(201, "Vivienda  creada", $data);
            } catch (Exception $e) {
                sendResponse(500, "Error al crear la vivienda: " . $e->getMessage());
            }
            break;

        // case 'PUT': // Actualizar una categoría existente
        //     try {
        //         // Validar data de entrada
        //         if (empty($body['cat_id']) || empty($body['cat_nom']) || empty($body['cat_obs'])) {
        //             enviarRespuesta(400, "data de entrada inválidos");
        //         }

        //         $data = $categoria->update_categoria($body['cat_id'], $body['cat_nom'], $body['cat_obs']);
        //         enviarRespuesta(200, "Categoría actualizada", $data);
        //     } catch (Exception $e) {
        //         enviarRespuesta(500, "Error al actualizar la categoría: " . $e->getMessage());
        //     }
        //     break;

        // case 'DELETE': // Eliminar una categoría
        //     try {
        //         // Validar data de entrada
        //         if (empty($body['cat_id'])) {
        //             enviarRespuesta(400, "ID de categoría inválido");
        //         }

        //         $categoria->delete_categoria($body['cat_id']);
        //         enviarRespuesta(204, "Categoría eliminada"); // 204 No Content
        //     } catch (Exception $e) {
        //         enviarRespuesta(500, "Error al eliminar la categoría: " . $e->getMessage());
        //     }
        //     break;

        // default:
        //     enviarRespuesta(405, "Método no permitido"); // 405 Method Not Allowed
        //     break;
    }
?>