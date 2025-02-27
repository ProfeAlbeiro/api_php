<?php
require_once '../models/Location.php';

class LocationController {
    private $location;

    public function __construct($db) {
        $this->location = new Location($db);
    }

    public function listarLocations() {
        $locations = $this->location->obtenerTodos();
        echo json_encode($locations);
    }

    public function obtenerLocation($id) {
        $location = $this->location->obtenerPorId($id);
        echo json_encode($location);
    }

    public function crearLocation($data) {
        if ($data) {
            $name = $data['name'];
            $city = $data['city'];
            $state = $data['state'];
            $photo = $data['photo'];
            $availableUnits = $data['availableUnits'];
            $wifi = $data['wifi'];
            $laundry = $data['laundry'];
            $resultado = $this->location->crear($name, $city, $state, $photo, $availableUnits, $wifi, $laundry);
            echo json_encode(['success' => $resultado]);
        } else {
            http_response_code(400);
            echo json_encode(['mensaje' => 'Datos inválidos']);
        }
    }

    public function actualizarLocation($id, $data) {
        if ($data && $id) {
            $name = $data['name'];
            $city = $data['city'];
            $state = $data['state'];
            $photo = $data['photo'];
            $availableUnits = $data['availableUnits'];
            $wifi = $data['wifi'];
            $laundry = $data['laundry'];
            $resultado = $this->location->actualizar($id, $name, $city, $state, $photo, $availableUnits, $wifi, $laundry);
            echo json_encode(['success' => $resultado]);
        } else {
            http_response_code(400);
            echo json_encode(['mensaje' => 'Datos inválidos']);
        }
    }

    public function eliminarLocation($id) {
        $resultado = $this->location->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }
}
?>