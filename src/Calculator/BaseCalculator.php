<?php
namespace App\Calculator;


use App\Calculator\Conversion\CurrencyConversion;
use App\Calculator\Conversion\OdomoterConversion;
use App\Entity\Dealer;
use App\Entity\Inventory;

abstract class BaseCalculator implements CalculatorInterface {

    private array $carData = [];

    public function __construct(array $carData) {
        if (empty($carData)) {
            throw new \Exception("No data on car data found");
        }
        $this->carData = $carData;
    }

    public function getCarData() : array {
        return $this->carData;
    }

    /**
     * convert currency and odometer if no state/province, set to USD and Miles.
     * Assumes cars listed in Canada are in CAD and KM
     *
     * @param $state
     * @return void
     */
    public function convertCarData($state = null) : void {
        if (empty($state)) {
            $currencyConversion = new CurrencyConversion(CurrencyConversion::CURRENCY_CAD, CurrencyConversion::CURRENCY_USD);
            foreach ($this->carData as &$carDatum) {
                if ($carDatum[Dealer::DEALER_COUNTRY] === Dealer::COUNTRY_CAN) {
                    $carDatum[Inventory::LISTING_PRICE] = $carDatum[Inventory::LISTING_PRICE] * $currencyConversion->getExchangeRate();
                    $carDatum[Inventory::LISTING_MILEAGE] = $carDatum[Inventory::LISTING_MILEAGE] * OdomoterConversion::KM_TO_MILE;
                }
            }
        }
    }

    abstract public function calculate(int $targetMileage): float;
}