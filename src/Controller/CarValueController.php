<?php

namespace App\Controller;

use App\Calculator\AverageCalculator;
use App\Calculator\Conversion\CurrencyConversion;
use App\Calculator\Conversion\OdomoterConversion;
use App\Calculator\LinearRegressionCalculator;
use App\Entity\Dealer;
use App\Entity\Inventory;
use App\Form\CarValueType;
use App\Repository\InventoryRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarValueController extends AbstractController
{
    #[Route('/', name: 'car_value_home')]
    public function index(
        Request $request,
        InventoryRepository $inventoryRepository,
        LoggerInterface $logger,
        ValidatorInterface $validator
    ): Response {

        // See https://symfony.com/doc/current/form/multiple_buttons.html
        $form = $this->createForm(CarValueType::class);
        $form->handleRequest($request);

        $errorMsg = [];

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/forms.html#processing-forms
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SubmitButton $submit */
            // Retrieve form data
            $formData = $form->getData();
            $this->cleanFormData($formData);

            $logger->debug(json_encode($formData));

            $carData = $inventoryRepository->findByCar($formData);

            try {
                // convert currency and odometer if no state/province set
                if (empty($formData[CarValueType::STATE])) {
                    $currencyConversion = new CurrencyConversion(CurrencyConversion::CURRENCY_CAD, CurrencyConversion::CURRENCY_USD);
                    foreach ($carData as &$carDatum) {
                        // assumes cars listed in canada are in CAD and KM
                        if ($carDatum[Dealer::DEALER_COUNTRY] === Dealer::COUNTRY_CAN) {
                            $carDatum[Inventory::LISTING_PRICE] = $carDatum[Inventory::LISTING_PRICE] * $currencyConversion->getExchangeRate();
                            $carDatum[Inventory::LISTING_MILEAGE] = $carDatum[Inventory::LISTING_MILEAGE] * OdomoterConversion::KM_TO_MILE;
                        }
                    }
                }

                if (empty($formData['mileage'])) {
                    $averageCalculator = new AverageCalculator($carData);
                    $carValue = $averageCalculator->calculate(null);
                } else {
                    $averageCalculator = new LinearRegressionCalculator($carData);
                    $carValue = $averageCalculator->calculate($formData['mileage']);
                }
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $errorMsg[] = $e->getMessage();
            }

            // Render car value results
            return $this->render('result/car_result.html.twig', [
                'carForm' => $formData,
                'carValue' => $carValue ?: 0,
                'carData' => array_slice($carData, 0, 100), // only show first 100 cars to the users
                'errorMsg' => $errorMsg,
                'stateOrProvinceMap' => Dealer::AMERICAN_STATE_MAP + Dealer::CANADIAN_PROV_MAP
            ]);
        }

        return $this->render('form/car_value.html.twig', [
            'form' => $form,
            'errorMsg' => $errorMsg,
        ]);
    }

    public function isValid() {


    }
    function cleanFormData(&$formData) {
        foreach ($formData as &$datum) {
            $datum = strtolower(trim($datum));
        }
    }
}
