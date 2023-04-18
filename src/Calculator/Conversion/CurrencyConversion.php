<?php
namespace App\Calculator\Conversion;

use Exception;

class CurrencyConversion {

    const CURRENCY_CAD = 'cad';
    const CURRENCY_USD = 'usd';
    const CAD_TO_USD = 0.739837;

    const OFFLINE_CURRENCY_MAP = [
        'cad-usd' => self::CAD_TO_USD
    ];

    private $exchangeRate = '1';

    // public currency api courtesy of https://github.com/fawazahmed0/currency-api#readme
    const CURRENCY_API = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/%s/%s.json";

    public function __construct($fromCurrency, $toCurrency)
    {
        try {
            if($exchangeRateJson = $this->getExchangeRateJson($fromCurrency, $toCurrency)) {
                $exchangeRate = json_decode($exchangeRateJson, true);
                $this->exchangeRate =  $exchangeRate[$toCurrency] ?: 1;
            }
        } catch (Exception $e) {
            if (self::OFFLINE_CURRENCY_MAP["$fromCurrency-$toCurrency"]) {
                $this->exchangeRate = self::OFFLINE_CURRENCY_MAP["$fromCurrency-$toCurrency"];
            }
        }
    }

    public function getExchangeRate() {
        return $this->exchangeRate;
    }

    protected function getExchangeRateJson($fromCurrency, $toCurrency) {
        return file_get_contents(sprintf(self::CURRENCY_API, $fromCurrency, $toCurrency));
    }
}