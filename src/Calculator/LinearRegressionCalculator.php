<?php
namespace App\Calculator;

use App\Entity\Inventory;

class LinearRegressionCalculator extends BaseCalculator implements CalculatorInterface {

    // Ref: https://www.statisticshowto.com/probability-and-statistics/regression-analysis/find-a-linear-regression-equation/#FindaLinear
    public function calculate($targetMileage) : float {
        $carData = $this->getCarData();

        $formulaSums = [
            'sumX' => 0,
            'sumY' => 0,
            'sumXX' => 0,
            'sumXY' => 0
        ];
        $n = 0;
        foreach ($carData as $key => $carDatum) {
            // let x = mileage
            // let y = price
            $n++;
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
            (($n * $formulaSums['sumXX']) - ($formulaSums['sumX'] * $formulaSums['sumX']));

        $b = (($n * $formulaSums['sumXY']) - ($formulaSums['sumX'] * $formulaSums['sumY'])) /
            (($n * $formulaSums['sumXX']) - ($formulaSums['sumX'] * $formulaSums['sumX']));

        // y = a + bx (x = targetMileage)
        return $a + ($b * $targetMileage);
    }
}