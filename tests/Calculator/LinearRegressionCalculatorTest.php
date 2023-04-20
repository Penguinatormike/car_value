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
    public function testAverageCalculator(array $carData, bool $shouldConvert, float $expectedCarValue, int $targetMileage): void
    {
        $averageCalculator = new LinearRegressionCalculator($carData);
        $averageCalculator->convertCarData($shouldConvert ? $this->currencyConversionMap : null);
        $actualCarValue = $averageCalculator->calculate(null);

        $this->assertEquals($expectedCarValue, $actualCarValue);
    }

    public function averageCalculatorProvider()
    {
        return [
            //region test no conversions
            [
                [
                    0 =>
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
                    1 =>
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
                    2 =>
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
                    3 =>
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
                    4 =>
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
                    5 =>
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
                    6 =>
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
                    7 =>
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
                    8 =>
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
                ],
                // convert to USD/Miles?
                false,
                // expected
                28436.00,
                // mileage
                70000
            ],
            //endregion

            //region test with conversions
            [
                [
                    0 =>
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
                    1 =>
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
                    2 =>
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
                    3 =>
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
                    4 =>
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
                    5 =>
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
                    6 =>
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
                    7 =>
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
                    8 =>
                        [
                            'listingMileage' => 16841,
                            'listingPrice'   => '26998.00',
                            'modelName'      => 'corolla hatchback',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se fwd',
                            'yearRelease'    => 2019,
                            'dealerCountry'  => 'can',
                            'dealerState'    => 'on',
                            'dealerCity'     => 'london',
                        ],
                ],
                // convert to USD/Miles?
                true,
                // expected
                26078.53,
                // mileage
                70000
            ],
            //endregion

            //region test with positive b (slope) value
            [
                [
                    0 =>
                        [
                            'listingMileage' => 11608,
                            'listingPrice'   => '29981.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ca',
                            'dealerCity'     => 'oakland',
                        ],
                    1 =>
                        [
                            'listingMileage' => 7188,
                            'listingPrice'   => '28990.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'tx',
                            'dealerCity'     => 'blue mound',
                        ],
                    2 =>
                        [
                            'listingMileage' => 3,
                            'listingPrice'   => '21900.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wy',
                            'dealerCity'     => 'casper',
                        ],
                    3 =>
                        [
                            'listingMileage' => 4,
                            'listingPrice'   => '24620.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ms',
                            'dealerCity'     => 'moss point',
                        ],
                    4 =>
                        [
                            'listingMileage' => 7125,
                            'listingPrice'   => '26907.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ca',
                            'dealerCity'     => 'anaheim',
                        ],
                    5 =>
                        [
                            'listingMileage' => 3,
                            'listingPrice'   => '21970.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wy',
                            'dealerCity'     => 'casper',
                        ],
                    6 =>
                        [
                            'listingMileage' => 1,
                            'listingPrice'   => '24643.00',
                            'modelName'      => 'corolla',
                            'makeName'       => 'toyota',
                            'trimName'       => 'se fwd',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'ca',
                            'dealerCity'     => 'sunnyvale',
                        ],
                    7 =>
                        [
                            'listingMileage' => 1,
                            'listingPrice'   => '29657.00',
                            'modelName'      => 'corolla cross',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wi',
                            'dealerCity'     => 'milwaukee',
                        ],
                    8 =>
                        [
                            'listingMileage' => 901,
                            'listingPrice'   => '33990.00',
                            'modelName'      => 'corolla cross',
                            'makeName'       => 'toyota',
                            'trimName'       => 'l',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'in',
                            'dealerCity'     => 'greenfield',
                        ],
                    9 =>
                        [
                            'listingMileage' => 1,
                            'listingPrice'   => '27954.00',
                            'modelName'      => 'corolla cross',
                            'makeName'       => 'toyota',
                            'trimName'       => 'le awd',
                            'yearRelease'    => 2022,
                            'dealerCountry'  => 'usa',
                            'dealerState'    => 'wi',
                            'dealerCity'     => 'milwaukee',
                        ],
                ],
                // convert to USD/Miles?
                true,
                // expected
                26206.54,
                // mileage (will be disregarded)
                70000
            ],
            //endregion

            //region test with single data
            [
                [
                    0 =>
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
                ],
                // convert to USD/Miles?
                true,
                // expected
                19574.00,
                // mileage (will be disregarded)
                70000
            ],
            //endregion
        ];
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testLinearRegressionCalculatorNoData(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("No car data found");

        $averageCalculator = new LinearRegressionCalculator([]);
        $averageCalculator->convertCarData(null);
        $averageCalculator->calculate(null);
    }

}
