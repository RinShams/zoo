<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
require __DIR__ . '/vendor/autoload.php';
require ('api\application\Application.php');

function router($params) {
$loader = new FilesystemLoader('public/templates');
$twig = new Environment($loader);
$app = new Application();

    $method = $params['method'];
    if (!$method) {
        echo $twig->render('index.twig');
     } else {        
        switch ($method) {

            /////для варианта интерфейса///////////

            case 'getPets' : {
                $data = $app->getPetsList();                
                echo $twig->render('petsList.twig', ['data' => $data]); 
                break;         
            }
            case 'getPetAllInfo' : {
                $data = $app->getPetAllInfo($params);
                echo $twig->render('petInfoPage.twig', ['pet' => $data[0]]);
                break;
            }
            case 'getCages' : {
                $data = $app->getCages();
                echo $twig->render('cagesList.twig', ['data' => $data]);
                break;
            }
            case 'getCageAllInfo' : {
                $cageInfo = $app->getCageById($params); 
                $petsInCage = $app->getPetbyCage($cageInfo[0]->id);
                echo $twig->render('cageInfoPage.twig', ['cage' => $cageInfo[0], 'pets' => $petsInCage]);
                break;
            }
            case 'getFoodInfo' : {
                echo $twig->render('foodList.twig');
                break;
            }

            /////для клеток/////////////

            case 'addCage' : return $app->addCage($params);
            //case 'getCages' : return $app->getCages();
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
            //case 'getPetAllInfo' : return $app->getPetAllInfo($params);
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

router($_GET);

//echo json_encode(answer(router($_GET)));

//echo json_encode((router($_GET)));
//echo json_encode(answer(router($_POST)));

// $loader = new vendor\twig\twig\src\Loader\ArrayLoader([
//     'index' => 'Hello {{ name }}!',
// ]);
// $twig = new vendor\twig\twig\src\Environment($loader);

// echo $twig->render('index', ['name' => 'Fabien']);