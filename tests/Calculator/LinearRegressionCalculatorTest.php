<?php

namespace App\Tests\Calculator;

use App\Calculator\AverageCalculator;
use App\Calculator\LinearRegressionCalculator;

class LinearRegressionCalculatorTest extends BaseCalculatorTest
{
    /**
     * @dataProvider averageCalculatorProvider
     * @return void
     * @throws \Exception
     */
    public function testAverageCalculator(array $carData, bool $shouldConvert, float $expectedCarValue): void
    {
        $averageCalculator = new LinearRegressionCalculator($carData);
        $averageCalculator->convertCarData($shouldConvert ? $this->currencyConversionMap : null);
        $actualCarValue = $averageCalculator->calculate(null);

        $this->assertEquals($expectedCarValue, $actualCarValue);
    }

    public function averageCalculatorProvider()
    {
        return [
            [
                // No conversions
                [
                    [
                        'listingMileage' => 6,
                        'listingPrice'   => '30406.00',
                        'modelName'      => 'camry se sedan',
                        'makeName'       => 'toyota',
                        'trimName'       => 'se fwd',
                        'yearRelease'    => 2023,
                        'dealerCountry'  => 'can',
                        'dealerState'    => 'bc',
                        'dealerCity'     => 'vancouver',
                    ],
                    [
                        'listingMileage' => 6,
                        'listingPrice'   => '30406.00',
                        'modelName'      => 'camry se sedan',
                        'makeName'       => 'toyota',
                        'trimName'       => 'se fwd',
                        'yearRelease'    => 2023,
                        'dealerCountry'  => 'can',
                        'dealerState'    => 'bc',
                        'dealerCity'     => 'vancouver',
                    ]
                ],
                // convert to USD/Miles?
                false,
                // expected
                30406.00
            ],
            // test with conversions

            // test with positive b value

            // test with single use case

            // test with negative b value

            // test with no data
        ];
    }

}
