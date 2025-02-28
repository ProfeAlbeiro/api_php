<?php
    header('Content-Type: application/json');

    require_once "../config/DataBase.php";
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
                    sendResponse(200, "Ubicación de viviendas obtenidas", $data);
                } catch (Exception $e) {
                    sendResponse(500, "Error al obtener la ubicación de las viviendas: " . $e->getMessage());
                }
            }
            break;

        case 'POST':
            try {
                if (empty($body['cat_nom']) || empty($body['cat_obs'])) {
                    sendResponse(400, "datos de entrada inválidos");
                }
                $data = $location->createHousingLocation($body['cat_nom'], $body['cat_obs']);
                enviarRespuesta(201, "Categoría creada", $data); // 201 Created
            } catch (Exception $e) {
                enviarRespuesta(500, "Error al crear la categoría: " . $e->getMessage());
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