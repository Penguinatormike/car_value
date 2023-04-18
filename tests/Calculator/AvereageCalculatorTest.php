<?php

namespace App\Tests\Calculator;

use App\Calculator\AverageCalculator;
use PHPUnit\Framework\TestCase;

class AvereageCalculatorTest extends TestCase
{
    public function testFormLoad(): void
    {
        $averageCalculator = new AverageCalculator([
            [
                'listingMileage' => 6,
                'listingPrice'   => '30406.00',
                'modelName'      => 'camry se sedan',
                'makeName'       => 'toyota',
                'trimName'       => 'se fwd',
                'yearRelease'    => 2023,
                'dealerCountry'  => 'usa',
                'dealerState'    => 'oh',
                'dealerCity'     => 'cincinnati',
            ]
        ]);
        $averageCalculator->convertCarData();

    }

}
