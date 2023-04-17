<?php
namespace App\Calculator;

use App\Entity\Inventory;
use Exception;

class AverageCalculator extends BaseCalculator implements CalculatorInterface {

    public function calculate($targetMileage) : float {
        $carData = $this->getCarData();

        $totalCars = count($carData);
        $totalCarPrices = array_sum(array_column($carData, Inventory::LISTING_PRICE));

        return (float) $totalCarPrices / $totalCars;
    }
}