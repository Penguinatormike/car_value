<?php

namespace App\Controller;

use App\Calculator\CalculatorFactory;
use App\Calculator\Conversion\CurrencyConversion;
use App\Entity\Dealer;
use App\Form\CarValueType;
use App\Repository\InventoryRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarValueController extends AbstractController
{
    #[Route('/', name: 'car_value_home')]
    public function index(
        Request $request,
        InventoryRepository $inventoryRepository,
        CalculatorFactory $calculatorFactory,
        LoggerInterface $logger
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
            $logger->debug(json_encode($formData));

            try {
                $carData = $inventoryRepository->findByCar($formData);

                $calculatorFactory->create($carData, $formData[CarValueType::MILEAGE] ?? null);
                $calculator = $calculatorFactory->getCalculator();

                $conversionMap = [Dealer::COUNTRY_CAN => new CurrencyConversion(CurrencyConversion::CURRENCY_CAD, CurrencyConversion::CURRENCY_USD)];
                $calculator->convertCarData($formData[CarValueType::STATE] ? null : $conversionMap);
                $carValue = $calculator->calculate($formData[CarValueType::MILEAGE] ?? null);
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
}
