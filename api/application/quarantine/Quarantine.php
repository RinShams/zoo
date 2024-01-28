<?php
class Quarantine {
    function __construct($db) {
        $this->db = $db;
    }

    public function addQuarantineInfo($petId, $diagnosis, $start) {
        return $this->db->addQuarantineInfo($petId, $diagnosis, $start);
    }

    public function updateQuarantineEnd($petId, $end) {
        return $this->db->updateQuarantineEnd($petId, $end);
    }

    public function getSickPet($pet) {
        return $this->db->getSickPet($pet);
    }

    public function getPetMedicalHistory($pet) {
        return $this->db->getPetMedicalHistory($pet);
    }

    public function getPetsInQuarantine() {
        return $this->db->getPetsInQuarantine();
    }

}