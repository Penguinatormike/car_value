<?php
namespace App\Calculator;

use App\Entity\Inventory;

class LinearRegressionCalculator extends BaseCalculator {

    /**
     * Finds the linear regression formula for the given data and uses the targetMileage to find the price
     *
     * We will be using these variables to represent:
     * x = mileage
     * y = price
     * b = slope
     * a = baseline
     * n = data #
     *
     * Ref: https://www.statisticshowto.com/probability-and-statistics/regression-analysis/find-a-linear-regression-equation/#FindaLinear
     * @param $targetMileage
     * @return float
     */
    public function calculate($targetMileage) : float {
        $carData = $this->getCarData();

        $n = count($carData);
        $sumX = 0;
        $sumY = 0;
        $sumXX = 0;
        $sumXY = 0;

        // it's not possible to find slope data based on one input, return the price of first listing
        if ($n === 1) {
            return $carData[0][Inventory::LISTING_PRICE];
        }

        foreach ($carData as $carDatum) {
            $x = $carDatum[Inventory::LISTING_MILEAGE];
            $y = $carDatum[Inventory::LISTING_PRICE];
            $xx = (float) $x * $x;
            $xy = (float) $x * $y;

            $sumX += $x;
            $sumY += $y;
            $sumXX += $xx;
            $sumXY += $xy;
        }

        $a = (($sumY * $sumXX) - ($sumX * $sumXY)) /
            (($n * $sumXX) - ($sumX * $sumX));

        $b = (($n * $sumXY) - ($sumX * $sumY)) /
            (($n * $sumXX) - ($sumX * $sumX));

        // b = slope, which should never increase. In the event the price goes up and the mileage goes up
        // this usually indicates that the car is new and doesn't have enough data to
        // create the slope variable. In this case, don't use this variable.
        if ($b > 0) {
            $carValue = $a;
        } else {
            // y = a + bx (x = targetMileage)
            $carValue = $a + ($b * $targetMileage);
        }

        return (float) number_format($carValue, 2, '.', '');
    }
}