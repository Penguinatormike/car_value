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
            throw new \Exception("No car data found");
        }
        $this->carData = $carData;
    }

    public function getCarData() : array {
        return $this->carData;
    }

    /**
     * convert currency and odometer if no state/province, set to USD and Miles.
     *
     * @param array|null $currencyConversionMap
     * @return void
     */
    public function convertCarData(?array $currencyConversionMap) : void {
        if (!empty($currencyConversionMap)) {
            foreach ($this->carData as &$carDatum) {
                if (isset($currencyConversionMap[$carDatum[Dealer::DEALER_COUNTRY]])
                    && $currencyConversionMap[$carDatum[Dealer::DEALER_COUNTRY]] instanceof CurrencyConversion
                ) {
                    // Assumes cars listed in Canada are in CAD and KM
                    $carDatum[Inventory::LISTING_PRICE] = $carDatum[Inventory::LISTING_PRICE] * $currencyConversionMap[$carDatum[Dealer::DEALER_COUNTRY]]->getExchangeRate();
                    $carDatum[Inventory::LISTING_MILEAGE] = $carDatum[Inventory::LISTING_MILEAGE] / OdomoterConversion::KM_TO_MILE;
                }
            }
        }
    }

    abstract public function calculate(int $targetMileage): float;
}