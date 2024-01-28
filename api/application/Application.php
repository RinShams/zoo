<?php
require ("db\DB.php");
require ("pet\Pet.php");
require ("cage\Cage.php");
require ("classification\Classification.php");
require ("food\Food.php");
require ("quarantine\Quarantine.php");

class Application {
    function __construct() {
        $config = json_decode(file_get_contents('api\config\config.json'), true);
        $db = new DB($config["DataBase"]);
        $this->pet = new Pet($db);
        $this->cage = new Cage($db);
        $this->classification = new Classification($db);
        $this->food = new Food($db);
        $this->quarantine = new Quarantine($db);
    }

    ////////для варианта интерфейса/////////

    public function getPetsList() {
        $pets = array();
        $species = $this->classification->getSpecies();        
        foreach ($species as $type) {   
            $petsOfType = $this->pet->getPetbySpecies($type->id);;
            $pets = array_merge($pets, $petsOfType);
        }
        return $pets;
    }

    public function getCages() {
        return $this->cage->getCages();
    }

    public function getPetbyCage($params) {
        return $this->pet->getPetbyCage($params);
    }

    ////////для клеток///////////////

    public function addCage($params) {
        [   'num' => $num,
            'area' => $area,
            'hasPool' => $hasPool,
            'hasFence' => $hasFence
        ] = $params;
        return $this->cage->addCage($num, $area, $hasPool, $hasFence);
    }

    // public function getCages() {
    //     return $this->cage->getCages();
    // }

    public function getCageById($params) {
        return $this->cage->getCageById($params['id']);
    }

    /////////для классификации/////////////////

    public function addClass($params) {
        return $this->classification->addClass($params['name']);
    }

    public function addOrder($params) {
        return $this->classification->addOrder($params['name'], $params['class']);
    }

    public function addGenus($params) {
        return $this->classification->addGenus($params['name'], $params['order']);
    }

    public function addSpecies($params)  {
        return $this->classification->addSpecies($params['name'], $params['genus']);
    }

    public function getClasses()  {
        return $this->classification->getClasses();
    }

    public function getOrder() {
        return $this->classification->getOrder();
    }

    public function getGenera() {
        return $this->classification->getGenera();
    }

    public function getSpecies() {
        return $this->classification->getSpecies();
    }

    public function getClassification($params) {
        return $this->classification->getClassification($params['species']);
    }

    ///////////для питомцев///////////////
    
    public function addPet($params) {
        [   'name' => $name,
            'isMale' => $isMale,
            'date' => $date,
            'place' => $place,
            'cage' => $cage,
            'comment' => $comment,
            'species' => $species
        ] = $params;
        return $this->pet->addPet($name, $isMale, $date, $place, $cage, $comment, $species) ;
    } 

    public function updatePet($params) {
        [   'id' => $id,
            'name' => $name,
            'isMale' => $isMale,
            'date' => $date,
            'place' => $place,
            'cage' => $cage,
            'comment' => $comment,
            'species' => $species
        ] = $params;
        return $this->pet->updatePet($id, $name, $isMale, $date, $place, $cage, $comment, $species) ;
    }
    
    public function getPetAllInfo($params) {
        return $this->pet->getPetAllInfo($params['id']);
    }

    public function getPetbySpecies($params) {
        return $this->pet->getPetbySpecies($params['species']);
    }

    // public function getPetbyCage($params) {
    //     return $this->pet->getPetbyCage($params['cage']);
    // }

    public function addPetParameters($params) {
        [   'petId' => $petId,
            'weight' => $weight,
            'height' => $height,
            'length' => $length,
            'date' => $date
        ] = $params;
        return $this->pet->addPetParameters($petId, $weight, $height, $length, $date);
    }

    public function getLastPetParameters($params) {
        return $this->pet->getLastPetParameters($params['id']);
    }

    public function addDeathInfo($params) {
        $sickPet = $this->quarantine->getSickPet($params['id']);
        if ($sickPet) {
            $this->quarantine->updateQuarantineEnd($params['id'], $params['date']);
        }
        return $this->pet->addDeathInfo($params['id'], $params['date'], $params['cause']);
    }

    public function getAllDeadPetInfo() {
        return $this->pet->getAllDeadPetInfo();
    }

    /////////////для карантина//////////////////////////////

    public function addQuarantineInfo($params) {
        return $this->quarantine->addQuarantineInfo($params['petId'], $params['diagnosis'], $params['start']);
    }

    public function updateQuarantineEnd($params) {
        return $this->quarantine->updateQuarantineEnd($params['id'], $params['end']);
    }

    public function getPetMedicalHistory($params) {
        return $this->quarantine->getPetMedicalHistory($params['id']);
    }

    public function getPetsInQuarantine() {
        return $this->quarantine->getPetsInQuarantine();
    }

    ///////////для кормов//////////////

    public function addFoodType($params) {
        return $this->food->addFoodType($params['name']);
    }

    public function getFoodType() {
        return $this->food->getFoodType();
    }

    public function addFood($params) {
        [   'name' => $name,
            'type' => $type,
            'proteins' => $proteins,
            'fats' => $fats,
            'carbs' => $carbs,
            'calories' => $calories,
            'price' => $price
        ] = $params;
        return $this->food->addFood($name, $type, $proteins, $fats, $carbs, $calories, $price);
    }

    public function getFoodByType($params) {
        return $this->food->getFoodByType($params['type']);
    }

    public function getLastFoodRemainsById($params) {
        return $this->food->getLastFoodRemainsById($params['id']);
    }

    public function getMealsByPet($params) {
        return $this->food->getMealsByPet($params['id']); 
    }

    public function addMeal($params) {
        $postBody = file_get_contents("php://input");
        try {
            $data = json_decode($postBody);
        } catch (Exception $e) {
            print_r($e->getMessage());
            die;
        }
        if ($data) {
            $this->food->addMeal($data->pet, $data->food);
        }
    }

}