<?php
class Classification {
    function __construct($db) {
        $this->db = $db;
    }

    public function addClass($name) {
        return $this->db->addClass($name);
    }

    public function addOrder($name, $class) {
        return $this->db->addOrder($name, $class);
    }

    public function addGenus($name, $order) {
        return $this->db->addGenus($name, $order);
    }

    public function addSpecies($name, $genus) {
        return $this->db->addSpecies($name, $genus);
    }

    public function getClasses() {
        return $this->db->getClasses();
    }

    public function getOrder() {
        return $this->db->getOrder();
    }

    public function getGenera() {
        return $this->db->getGenera();
    }

    public function getSpecies() {
        return $this->db->getSpecies();
    }

    public function getClassification($species) {
        return $this->db->getClassification($species);
    }

}