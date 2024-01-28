<?php
class Pet {
    function __construct($db) {
        $this->db = $db;
    }
    
    public function addPet($name, $isMale, $date, $place, $cage, $comment, $species) {
       return $this->db->addPet($name, $isMale, $date, $place, $cage, $comment, $species);
    }

    public function updatePet($id, $name, $isMale, $date, $place, $cage, $comment, $species){
        return $this->db->updatePet($id, $name, $isMale, $date, $place, $cage, $comment, $species);
    }

    public function getPetAllInfo($id) {
        return $this->db->getPetAllInfo($id);
    }

    public function getPetbyId($id) {
        return $this->db->getPetbyId($id);
    }

    public function getPetbySpecies($species) {
        return $this->db->getPetbySpecies($species);
    }

    public function getPetbyCage($cage) {
        return $this->db->getPetbyCage($cage);
    }

    public function addPetParameters($petId, $weight, $height, $length, $date) {
        return $this->db->addPetParameters($petId, $weight, $height, $length, $date);
    }

    public function getLastPetParameters($pet) {
        return $this->db->getLastPetParameters($pet);
    }

    public function addDeathInfo($pet, $date, $cause) {
        $this->db->updatePetDeath($pet);
        return $this->db->addDeathInfo($pet, $date, $cause);
    }

    public function getAllDeadPetInfo() {
        return $this->db->getAllDeadPetInfo();
    }

}    