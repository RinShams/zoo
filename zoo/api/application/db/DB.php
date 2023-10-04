<?php
class DB {

    function __construct($config) {
        $host = $config["host"];
        $port = $config["port"];
        $name = $config["name"];
        $user = $config["user"];
        $password = $config["password"];

        try {
            $this->db = new PDO(
                'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $name . ';charset=utf8mb4',
                $user,
                $password                
               // [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
            );           
            //$this->db->exec('set names utf8 COLLATE utf8mb4_unicode_ci');
        } catch (Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }

    function __destruct() {
        $this->db = null;
    }

    private function getArray($query) {
        $stmt = $this->db->query($query);
        if ($stmt) {
            $result = array();
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $result[] = $row;
            }
            return $result;
        }
    }
    /////////////////////////////////////
    /////////////////////////////////////
    ///////////клетки////////////////////

    public function addCage($num, $area, $hasPool, $hasFence) {
        $query = '
                INSERT INTO cages (number, area, hasPool, hasStrongerFence) 
                VALUES (' . $num . ',' . $area . ',' . $hasPool . ',' . $hasFence . ')';
        $this->db->query($query);
        return true;
    }

    public function getCages() {
        $query = 'SELECT c.id, c.number, c.area, c.hasPool, c.hasStrongerFence, COUNT(pets.cageId) as petAmount
                FROM cages AS c LEFT JOIN pets
                ON c.id = pets.cageId AND pets.isAlive = 1
                GROUP BY c.id;';   
        return $this->getArray($query);
    }

    public function getCageById($id) {
        $query = 'SELECT c.number, c.area, c.hasPool, c.hasStrongerFence, COUNT(pets.cageId) as petAmount 
                FROM cages AS c LEFT JOIN pets 
                ON c.id = pets.cageId AND pets.isAlive = 1
                WHERE c.id = ' . $id . '
                GROUP BY c.id;';  
        return $this->getArray($query);
    }
    

    /////////////классификация/////////////////////////         

    public function addClass($name) {
        $query = 'INSERT INTO animal_classes (name) VALUES (' . $name .')';
        $this->db->query($query);
        return true;
    }

    public function addOrder($name, $class) {
        $query = 'INSERT INTO animal_order (name, classId) 
                VALUES (' . $name . ',' . $class .')';
        $this->db->query($query);
        return true;
    }

    public function addGenus($name, $order) {
        $query = 'INSERT INTO animal_genera (name, orderId) 
                VALUES (' . $name . ',' . $order .')';
        $this->db->query($query);
        return true;
    }

    public function addSpecies($name, $genus) {
        $query = 'INSERT INTO animal_species (name, genusId)
                VALUES (' . $name . ',' . $genus .')';
        $this->db->query($query);
        return true;
    } 
    
    public function getClasses() {
        $query = 'SELECT id, name FROM animal_classes ';
        return $this->getArray($query);         
    }
    
    public function getOrder() {
        $query = 'SELECT id, name FROM animal_order ';
        return $this->getArray($query);         
    }
    public function getGenera() {
        $query = 'SELECT id, name FROM animal_genera ';
        return $this->getArray($query);         
    }
    public function getSpecies() {
        $query = 'SELECT id, name FROM animal_species ';
        return $this->getArray($query);         
    }

    public function getClassification($species) {
        $query = 'SELECT sp.name as species, gen.name as genus, ord.name as order_, cl.name as class        
                FROM animal_species as sp 
                JOIN animal_genera as gen ON sp.genusId = gen.id
                JOIN animal_order as ord ON gen.orderId = ord.id
                JOIN animal_classes as cl ON ord.classId = cl.id
                WHERE sp.id = ' . $species ;
        return $this->getArray($query);
    }

    ///////////питомцы////////////////////////

    public function addPet($name, $isMale, $date, $place, $cage, $comment, $species) {
        $query = 'INSERT INTO `pets` (`name`, `isMale`, `birthDate`, `birthPlace`, `cageId`, `comment`, `speciesId`) 
                VALUES (' . $name . ',' . $isMale . ',' . $date . ',' . $place . ',' . $cage . ',' . $comment . ',' . $species . ')';
        $this->db->query($query);
        return true;
    }

    public function updatePet($id, $name, $isMale, $date, $place, $cage, $comment, $species) {
            $query = 'UPDATE `pets` SET name = ' . $name .
                    ', isMale =' . $isMale . 
                    ', birthDate =' . $date . 
                    ', birthPlace =' . $place . 
                    ', cageId =' . $cage . 
                    ', comment =' . $comment . 
                    ', speciesId =' . $species . 
                    ' WHERE id =' . $id;
            $this->db->query($query);
            return true;
    }

    public function getPetAllInfo($id) {    
        $query = 'SELECT p.*, c.number AS cageNumber, sp.name as species, gen.name as genus, ord.name as order_, cl.name as class
                FROM pets AS p 
                LEFT JOIN cages AS c ON p.cageId = c.id  
                LEFT JOIN animal_species as sp ON p.speciesId = sp.id
                LEFT JOIN animal_genera as gen ON sp.genusId = gen.id
                LEFT JOIN animal_order as ord ON gen.orderId = ord.id
                LEFT JOIN animal_classes as cl ON ord.classId = cl.id
                WHERE p.isAlive = 1 AND p.id =' . $id;
        return $this->getArray($query);         
    }
    

    public function getPetbyId($id) {                                       
        $query = 'SELECT p.*, c.number AS cageNumber, sp.name AS species 
                FROM pets AS p  
                LEFT JOIN cages AS c ON p.cageId = c.id  
                LEFT JOIN animal_species as sp ON p.speciesId = sp.id
                WHERE p.id = ' . $id;
        return $this->getArray($query);         
    }

    public function getPetbySpecies($species) {
        $query = 'SELECT p.*, c.number AS cageNumber, sp.name AS species 
                FROM pets AS p  
                LEFT JOIN cages AS c ON p.cageId = c.id  
                LEFT JOIN animal_species as sp ON p.speciesId = sp.id
                WHERE p.isAlive = 1, p.speciesId = ' . $species;
        return $this->getArray($query);         
    }

    public function getPetbyCage($cage) {
        $query = 'SELECT p.*, sp.name AS species 
                FROM pets AS p  
                LEFT JOIN animal_species as sp ON p.speciesId = sp.id
                WHERE p.isAlive = 1, p.cageId = ' . $cage;
        return $this->getArray($query);         
    }    

    public function addPetParameters($petId, $weight, $height, $length, $date) {      
        $query = 'INSERT INTO pet_parameters (petId, weight, height, length, date) 
                VALUES (' . $petId . ',' . $weight . ',' . $height . ',' . $length . ',' . $date . ')';
        $this->db->query($query);
        return true;
    } 	

    public function getLastPetParameters($pet) {
        $query = 'SELECT * FROM pet_parameters WHERE petId = ' . $pet . ' ORDER BY date DESC LIMIT 1';
        return $this->getArray($query);         
    }

    /////////когда-нибудь тут будет вывод нескольких записей о параметрах для последующего анализа

    public function updatePetDeath($id) {
        $query = 'UPDATE `pets` SET isAlive = 0
                WHERE id =' . $id;
        $this->db->query($query);
        return true;
    }

    public function addDeathInfo($pet, $date, $cause) {
        $query = 'INSERT INTO dead_pets (petId,	deathDate, deathCause)
                VALUES (' . $pet . ',' . $date . ',' . $cause . ')';
        $this->db->query($query);
        return true;        
    }

    public function getAllDeadPetInfo() {                       
        $query = 'SELECT p.*, c.number AS cageNumber, sp.name AS species, gen.name AS genus, ord.name AS order_, cl.name AS class, d.deathDate, d.deathCause
                FROM pets AS p 
                LEFT JOIN cages AS c ON p.cageId = c.id
                LEFT JOIN dead_pets AS d ON d.petId = p.id
                LEFT JOIN animal_species as sp ON p.speciesId = sp.id
                LEFT JOIN animal_genera as gen ON sp.genusId = gen.id
                LEFT JOIN animal_order as ord ON gen.orderId = ord.id
                LEFT JOIN animal_classes as cl ON ord.classId = cl.id
                WHERE p.isAlive = 0;
        ';
        return $this->getArray($query);
    }

    //////////карантин////////////        тут могут быть запросы с лекарствами

    public function addQuarantineInfo($petId, $diagnosis, $start) {
        $query = 'INSERT INTO quarantine (petId, diagnosis, startDate) 
                VALUES (' . $petId . ',' . $diagnosis . ',' . $start . ')';
        $this->db->query($query);
        return true;
    } 
    
    public function updateQuarantineEnd($petId, $end) {                          
        $query = 'UPDATE `quarantine` 
                SET endDate = ' . $end . 
                'WHERE petId = ' . $petId . ' AND endDate IS NULL';
        $this->db->query($query);
        return true;
    } 

    public function getSickPet($pet) {
        $query = 'SELECT *
                FROM quarantine  
                WHERE petId =' . $pet . 'AND endDate IS NULL';
        return $this->getArray($query);         
    } 

    public function getPetMedicalHistory($pet) {
        $query = 'SELECT diagnosis, endDate, startDate 
                FROM quarantine  
                WHERE petId =' . $pet . 'ORDER BY startDate DESC ';
        return $this->getArray($query);         
    }   
    
    public function getPetsInQuarantine() {
        $query = 'SELECT p.name, p.id, sp.name, q.* 
                FROM quarantine AS q 
                INNER JOIN pets as p ON q.petId = p.id 
                INNER JOIN animal_species AS sp ON p.speciesId = sp.id 
                WHERE q.endDate IS NULL';
        return $this->getArray($query);         
    }     

    /////////////корм///////////////

    public function addFoodType($name) {
        $query = 'INSERT INTO foodtypes (name) VALUES (' . $name .')';
        $this->db->query($query);
        return true;
    }

    public function getFoodType() {
        $query = 'SELECT id, name FROM foodtypes';
        return $this->getArray($query);         
    }

    public function addFood($name, $type, $proteins, $fats, $carbs, $calories, $price) {
        $query = 'INSERT INTO food (name, typeId, proteins, fats, carbs, calories, currentPricePerKilo) 
                VALUES (' . $name . ',' . $type . ',' . $proteins . ',' . $fats . ',' . $carbs . ',' . $calories . ',' . $price . ')';
        $this->db->query($query);
        return true;
    }

    public function getFoodByType($type) {
        $query = 'SELECT f.* 
                FROM food AS f 
                INNER JOIN foodtypes AS t ON f.typeId = t.id
                WHERE t.id = ' . $type;
        return $this->getArray($query);         
    }
   
    public function addFoodRemains($foodId, $amount, $date) {
        $query = 'INSERT INTO food_supplies (foodId, foodAmount, date) 
                VALUES (' . $id . ',' . $amount . ',' . $date . ')';
        $this->db->query($query);
        return true;
    }

    public function getFoodRemainsById($id) {
        $query = 'SELECT * FROM food_supplies 
                WHERE foodId = ' . $id . ' ORDER BY date DESC';
        return $this->getArray($query);         
    }

    public function getLastFoodRemainsById($id) {
        $query = 'SELECT * FROM food_supplies 
                WHERE foodId = ' . $id . ' ORDER BY date DESC LIMIT 1';
        return $this->getArray($query);         
    }
    
    public function addMeal($petId, $foodId, $amount, $date) {
        $query = 'INSERT INTO taking_petmeals (petId, foodId, foodAmount, mealDate) 
                VALUES (' . $petId . ',' . $foodId . ',' . $amount . ',' . $date . ')';
        $this->db->query($query);
        return true;
    }

    public function getMealsByPet($id) {
        $query = 'SELECT * FROM taking_petmeals
                 WHERE petId = ' . $id . ' ORDER BY mealDate DESC';
        return $this->getArray($query);         
    }

/*C Nuestro que estas en la Memoria,
Compilado sea tu código,
venga a nosotros tu software,
carguense tus punteros.
así en la RAM como en el Disco Duro,
Danos hoy nuestro Array de cada día,
Perdona nuestros Warnings,
así como nosotros también los eliminamos,
no nos dejes caer en Bucles,
y libranos del Windows, Enter.*/
    
} 
