<?php

namespace App\Calculator;

class CalculatorFactory {

    /** @var AverageCalculator|LinearRegressionCalculator $calculator */
    private $calculator;

    /**
     * @param AverageCalculator|LinearRegressionCalculator $calculator
     */
    public function setCalculator(AverageCalculator|LinearRegressionCalculator $calculator) : void{
        $this->calculator = $calculator;
    }

    public function getCalculator() : AverageCalculator|LinearRegressionCalculator {
        return $this->calculator;
    }

    public function create($carData, $mileage) : void {
        if (empty($mileage)) {
            $this->setCalculator(new AverageCalculator($carData));
        } else {
            $this->setCalculator(new LinearRegressionCalculator($carData));
        }
    }
}