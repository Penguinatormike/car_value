<?php

namespace App\Tests\Calculator;

use App\Calculator\AverageCalculator;

class AvereageCalculatorTest extends BaseCalculatorTest
{
    /**
     * @dataProvider averageCalculatorProvider
     * @return void
     * @throws \Exception
     */
    public function testAverageCalculator(array $carData, bool $shouldConvert, float $expectedCarValue): void
    {
        $averageCalculator = new AverageCalculator($carData);
        $averageCalculator->convertCarData($shouldConvert ? $this->currencyConversionMap : null);
        $actualCarValue = $averageCalculator->calculate(null);

        $this->assertEquals($expectedCarValue, $actualCarValue);
    }

    public function averageCalculatorProvider()
    {
        return [
            [
                // test with no conversions
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
            [
                // test with no conversions
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
                        'dealerCountry'  => 'usa',
                        'dealerState'    => 'tx',
                        'dealerCity'     => 'el paso',
                    ]
                ],
                // convert to USD/Miles?
                true,
                // expected
                26450.741911
            ],
            // test with no data
        ];
    }

}
