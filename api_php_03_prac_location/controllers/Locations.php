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
                if (empty($body['name']) ||
                    empty($body['city']) ||
                    empty($body['state']) ||
                    empty($body['photo']) ||
                    empty($body['availableUnits']) ||
                    !isset($body['wifi']) ||
                    !isset($body['laundry'])) {
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

        case 'PUT':
            try {
                if (empty($body['id']) ||
                    empty($body['name']) ||
                    empty($body['city']) ||
                    empty($body['state']) ||
                    empty($body['photo']) ||
                    empty($body['availableUnits']) ||
                    !isset($body['wifi']) ||
                    !isset($body['laundry'])) {
                        sendResponse(400, "Datos de entrada inválidos");
                }

                $data = $location->updateHousingLocation(
                            $body['id'],
                            $body['name'],
                            $body['city'],
                            $body['state'],
                            $body['photo'],
                            $body['availableUnits'],
                            $body['wifi'],
                            $body['laundry']);
                sendResponse(200, "Vivienda y ubicación actualizada", $data);
            } catch (Exception $e) {
                sendResponse(500, "Error al actualizar vivienda y ubicación: " . $e->getMessage());
            }
            break;

            case 'DELETE':
                try {
                    if (empty($body['id'])) {
                        sendResponse(400, "ID de vivienda inválido");
                    }

                    $location->deleteHousingLocation($body['id']);
                    sendResponse(200, "Vivienda eliminada");
                } catch (Exception $e) {
                    sendResponse(500, "Error al eliminar vivienda: " . $e->getMessage());
                }
                break;

        default:
            sendResponse(405, "Método no permitido");
            break;
    }
?>