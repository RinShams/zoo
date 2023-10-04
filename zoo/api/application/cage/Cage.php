<?php 
class Cage {
    function __construct($db) {
        $this->db = $db;
    }

    public function addCage($num, $area, $hasPool, $hasFence) {
        return $this->db->addCage($num, $area, $hasPool, $hasFence);
    }

    public function getCages() {
        return $this->db->getCages();
    }

    public function getCageById($id) {
        return $this->db->getCageById($id);
    }
    
}