<?php
namespace App\Calculator;

use App\Entity\Inventory;

class LinearRegressionCalculator extends BaseCalculator implements CalculatorInterface {

    /**
     * Finds the linear regression formula for the given data and uses the targetMileage to find the price
     *
     * We will be using these variables to represent:
     * x = mileage
     * y = price
     * b = slope
     * n = data #
     *
     * Ref: https://www.statisticshowto.com/probability-and-statistics/regression-analysis/find-a-linear-regression-equation/#FindaLinear
     * @param $targetMileage
     * @return float
     */
    public function calculate($targetMileage) : float {
        $carData = $this->getCarData();

        $formulaSums = [
            'sumN' => 0,
            'sumX' => 0,
            'sumY' => 0,
            'sumXX' => 0,
            'sumXY' => 0
        ];

        // it's not possible to find slope data based on one input, return the mileage
        if (count($carData) === 1) {
            return $carData[0][Inventory::LISTING_PRICE];
        }

        foreach ($carData as $carDatum) {
            $formulaSums['sumN']++;
            $formulaVars = [];
            $formulaVars['x'] = $carDatum[Inventory::LISTING_MILEAGE];
            $formulaVars['y'] = $carDatum[Inventory::LISTING_PRICE];
            $formulaVars['xx'] = (float) $formulaVars['x'] * $formulaVars['x'];
            $formulaVars['xy'] = (float) $formulaVars['x'] * $formulaVars['y'];

            $formulaSums['sumX'] += $formulaVars['x'];
            $formulaSums['sumY'] += $formulaVars['y'];
            $formulaSums['sumXX'] += $formulaVars['xx'];
            $formulaSums['sumXY'] += $formulaVars['xy'];
        }

        $a = (($formulaSums['sumY'] * $formulaSums['sumXX']) - ($formulaSums['sumX'] * $formulaSums['sumXY'])) /
            (($formulaSums['sumN'] * $formulaSums['sumXX']) - ($formulaSums['sumX'] * $formulaSums['sumX']));

        $b = (($formulaSums['sumN'] * $formulaSums['sumXY']) - ($formulaSums['sumX'] * $formulaSums['sumY'])) /
            (($formulaSums['sumN'] * $formulaSums['sumXX']) - ($formulaSums['sumX'] * $formulaSums['sumX']));

        // b = slope, which should never increase. In the event the price goes up and the mileage goes up
        // this usually indicates that the car is new and doesn't have enough data to
        // create the slope variable. In this case, don't use this variable.
        if ($b > 0) {
            return $a;
        } else {
            // y = a + bx (x = targetMileage)
            return $a + ($b * $targetMileage);
        }
    }
}