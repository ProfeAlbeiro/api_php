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
        $name = $data['name'];
        $city = $data['city'];
        $state = $data['state'];
        $photo = $data['photo'];
        $availableUnits = $data['availableUnits'];
        $wifi = $data['wifi'];
        $laundry = $data['laundry'];
        $resultado = $this->location->crear($name, $city, $state, $photo, $availableUnits, $wifi, $laundry);
        echo json_encode(['success' => $resultado]);
    }

    public function actualizarLocation($id, $data) {
        $name = $data['name'];
        $city = $data['city'];
        $state = $data['state'];
        $photo = $data['photo'];
        $availableUnits = $data['availableUnits'];
        $wifi = $data['wifi'];
        $laundry = $data['laundry'];
        $resultado = $this->location->actualizar($id, $name, $city, $state, $photo, $availableUnits, $wifi, $laundry);
        echo json_encode(['success' => $resultado]);
    }

    public function eliminarLocation($id) {
        $resultado = $this->location->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }
}
?>