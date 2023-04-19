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
                //region test with no conversions
                [
                    0 =>
                        [
                            'listingMileage' => 20101,
                            'listingPrice'   => '27990.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ga',
                            'dealerCity'     => 'winder',
                        ],
                    2 =>
                        [
                            'listingMileage' => 34826,
                            'listingPrice'   => '26990.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'oh',
                            'dealerCity'     => 'heath',
                        ],
                    3 =>
                        [
                            'listingMileage' => 16841,
                            'listingPrice'   => '26998.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se fwd',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wa',
                            'dealerCity'     => 'puyallup',
                        ],
                    4 =>
                        [
                            'listingMileage' => 92567,
                            'listingPrice'   => '19998.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'co',
                            'dealerCity'     => 'parker',
                        ],
                    5 =>
                        [
                            'listingMileage' => 63015,
                            'listingPrice'   => '19574.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'tampa',
                        ],
                    6 =>
                        [
                            'listingMileage' => 40397,
                            'listingPrice'   => '19997.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wa',
                            'dealerCity'     => 'seattle',
                        ],
                    7 =>
                        [
                            'listingMileage' => 3545,
                            'listingPrice'   => '25998.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'royal palm beach',
                        ],
                    8 =>
                        [
                            'listingMileage' => 65109,
                            'listingPrice'   => '21999.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'az',
                            'dealerCity'     => 'phoenix',
                        ],
                    9 =>
                        [
                            'listingMileage' => 91878,
                            'listingPrice'   => '13999.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'west park',
                        ],
                ],
                // convert to USD/Miles?
                false,
                // expected
                22615.89
            ],
            //endregion

            //region test with conversions
            [
                [
                    0 =>
                        [
                            'listingMileage' => 20101,
                            'listingPrice'   => '27990.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ga',
                            'dealerCity'     => 'winder',
                        ],
                    1 =>
                        [
                            'listingMileage' => 0,
                            'listingPrice'   => '22995.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => '',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'can',
                            'dealerState'    => 'on',
                            'dealerCity'     => 'st catharines',
                        ],
                    2 =>
                        [
                            'listingMileage' => 34826,
                            'listingPrice'   => '26990.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'oh',
                            'dealerCity'     => 'heath',
                        ],
                    3 =>
                        [
                            'listingMileage' => 16841,
                            'listingPrice'   => '26998.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se fwd',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wa',
                            'dealerCity'     => 'puyallup',
                        ],
                    4 =>
                        [
                            'listingMileage' => 92567,
                            'listingPrice'   => '19998.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'xse',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'co',
                            'dealerCity'     => 'parker',
                        ],
                    5 =>
                        [
                            'listingMileage' => 63015,
                            'listingPrice'   => '19574.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'tampa',
                        ],
                    6 =>
                        [
                            'listingMileage' => 40397,
                            'listingPrice'   => '19997.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wa',
                            'dealerCity'     => 'seattle',
                        ],
                    7 =>
                        [
                            'listingMileage' => 3545,
                            'listingPrice'   => '25998.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'royal palm beach',
                        ],
                    8 =>
                        [
                            'listingMileage' => 65109,
                            'listingPrice'   => '21999.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'az',
                            'dealerCity'     => 'phoenix',
                        ],
                    9 =>
                        [
                            'listingMileage' => 91878,
                            'listingPrice'   => '13999.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'fl',
                            'dealerCity'     => 'west park',
                        ],
                ],
                // convert to USD/Miles?
                true,
                // expected
                22055.56
            ],
            //endregion

            //region test with single data point
            [
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
                ],
                // convert to USD/Miles?
                false,
                // expected
                30406.00
            ],
            //endregion
        ];
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testAverageCalculatorNoData(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("No car data found");

        $averageCalculator = new AverageCalculator([]);
        $averageCalculator->convertCarData(null);
        $averageCalculator->calculate(null);
    }
}
