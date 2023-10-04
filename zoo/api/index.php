<?php
//header('Content-Type: text/html; charset=utf-8');
//header("Content-Type: application/json; charset=UTF-8");
require ('application\Application.php');

function router($params) {
    $method = $params['method'];
    if ($method) {
        $app = new Application();
        switch ($method) {

            /////для клеток/////////////

            case 'addCage' : return $app->addCage($params);
            case 'getCages' : return $app->getCages();
            case 'getCageById' : return $app->getCageById($params);

            ////для классификации///////////

            case 'addClass' : return $app->addClass($params);
            case 'addOrder' : return $app->addOrder($params);
            case 'addGenus' : return $app->addGenus($params);
            case 'addSpecies' : return $app->addSpecies($params);

            case 'getClasses' : return $app->getClasses();
            case 'getOrder' : return $app->getOrder();
            case 'getGenera' : return $app->getGenera();
            case 'getSpecies' : return $app->getSpecies();
            case 'getClassification' : return $app->getClassification($params);

            ////для питомцев//////////////

            case 'addPet' : return $app->addPet($params);
            case 'updatePet' : return $app->updatePet($params);
            case 'getPetAllInfo' : return $app->getPetAllInfo($params);
            case 'getPetbySpecies' : return $app->getPetbySpecies($params);
            case 'getPetbyCage' : return $app->getPetbyCage($params);
            case 'addPetParameters' : return $app->addPetParameters($params);
            case 'getLastPetParameters' : return $app->getLastPetParameters($params);
            case 'addDeathInfo' : return $app->addDeathInfo($params);
            case 'getAllDeadPetInfo' : return $app->getAllDeadPetInfo();

            ////для карантина//////////////

            case 'addQuarantineInfo' : return $app->addQuarantineInfo($params);
            case 'updateQuarantineEnd' : return $app->updateQuarantineEnd($params);
            case 'getPetMedicalHistory' : return $app->getPetMedicalHistory($params);
            case 'getPetsInQuarantine' : return $app->getPetsInQuarantine();

            ////для кормов///////////////////

            case 'addFoodType' : return $app->addFoodType($params);
            case 'getFoodType' : return $app->getFoodType();
            case 'addFood' : return $app->addFood($params);
            case 'getFoodByType' : return $app->getFoodByType($params);
            case 'getLastFoodRemainsById' : return $app->getLastFoodRemainsById($params);
            case 'getMealsByPet' : return $app->getMealsByPet($params);
            case 'addMeal' : return $app->addMeal($params);
            
        }
    }
    return false;
}

function answer($data) {
    if ($data) {
        return array (
            'result' => 'ok',
            'data' => $data
        );
    }
    return array('result' => 'error');
}

echo json_encode(answer(router($_GET)));
