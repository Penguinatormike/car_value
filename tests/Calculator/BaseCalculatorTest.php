<?php

namespace App\Tests\Calculator;

use App\Calculator\Conversion\CurrencyConversion;
use App\Entity\Dealer;
use Mockery;
use PHPUnit\Framework\TestCase;

class BaseCalculatorTest extends TestCase
{
    public $currencyConversionMap;

    public function setUp(): void
    {
        $currencyConversionMock = Mockery::mock(CurrencyConversion::class);
        $currencyConversionMock->expects('getExchangeRate')
            ->andReturn(CurrencyConversion::CAD_TO_USD);
        $this->currencyConversionMap = [Dealer::COUNTRY_CAN => $currencyConversionMock];

        parent::setUp(); // TODO: Change the autogenerated stub
    }

}
