<?php
namespace App\Calculator;


class BaseCalculator {

    private $carData = [];
    public function __construct(array $carData) {
        if (empty($carData)) {
            throw new \Exception("No data on car data found");
        }
        $this->carData = $carData;
    }

    public function getCarData() {
        return $this->carData;
    }
}