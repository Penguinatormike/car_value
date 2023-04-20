<?php
namespace App\Service;

use App\Calculator\CalculatorFactory;
use App\Calculator\Conversion\CurrencyConversion;
use App\Entity\Dealer;
use App\Type\CarValueType;
use App\Repository\InventoryRepository;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CarValueService
{
    private CalculatorFactory $calculatorFactory;
    private InventoryRepository $inventoryRepository;
    private LoggerInterface $logger;
    private RequestStack $requestStack;

    public function __construct(
        CalculatorFactory $calculatorFactory,
        InventoryRepository $inventoryRepository,
        RequestStack $requestStack,
        LoggerInterface $logger
    ) {
        $this->calculatorFactory = $calculatorFactory;
        $this->inventoryRepository = $inventoryRepository;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    #[ArrayShape(['carValue' => "float|int", 'carData' => "mixed", 'errorMsg' => "string"])]
    public function doCalculation(): array
    {
        $errorMsg = '';
        $carData = [];
        $carValue = 0;
        try {
            $formData = $this->requestStack->getCurrentRequest()->get(CarValueType::TYPE);
            $carData = $this->inventoryRepository->findByCar($formData);

            $this->calculatorFactory->create($carData, $formData[CarValueType::MILEAGE] ?? null);
            $calculator = $this->calculatorFactory->getCalculator();

            $conversionMap = [Dealer::COUNTRY_CAN => new CurrencyConversion(CurrencyConversion::CURRENCY_CAD, CurrencyConversion::CURRENCY_USD)];
            $calculator->convertCarData($formData[CarValueType::STATE] ? null : $conversionMap);
            $carValue = $calculator->calculate($formData[CarValueType::MILEAGE] ?? null);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $errorMsg = $e->getMessage();
        }

        return [
            'carValue' => $carValue,
            'carData' => $carData,
            'errorMsg' => $errorMsg
        ];
    }
}