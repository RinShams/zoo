<?php
class Food {
    function __construct($db) {
        $this->db = $db;
    }

    public function addFoodType($name) {
        return $this->db->addFoodType($name);
    }

    public function getFoodType() {
        return $this->db->getFoodType();
    }

    public function addFood($name, $type, $proteins, $fats, $carbs, $calories, $price) {
        return $this->db->addFood($name, $type, $proteins, $fats, $carbs, $calories, $price);
    }

    public function getFoodByType($type) {
        return $this->db->getFoodByType($type);
    }

    public function getLastFoodRemainsById($id) {
        return $this->db->getLastFoodRemainsById($id);
    }

    public function addMeal($pet, $meal) {
        foreach ($meal as $dish) {
            $remains = $this->db->getLastFoodRemainsById($dish->id);
            $count = $remains->foodAmount - $dish->foodAmount;
            $this->db->addFoodRemains($dish->id, $count, $date);
            $this->db->addMeal($pet, $dish-id, $dish->foodAmount, $dish->date);
        }        
    }

    public function getMealsByPet($id)  {
        return $this->db->getMealsByPet($id);
    }

}