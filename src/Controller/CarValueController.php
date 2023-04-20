<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Service\CarValueService;
use App\Type\CarValueType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarValueController extends AbstractController
{
    #[Route('/', name: 'car_value_home')]
    public function index(
        Request $request,
        CarValueService $calculationService,
        LoggerInterface $logger
    ): Response {
        $form = $this->createForm(CarValueType::class);
        $form->handleRequest($request);
        $errorMsg = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $logger->debug(json_encode($formData));

            $carValueData = $calculationService->doCalculation();

            // Render car value results
            return $this->render('result/car_result.html.twig', [
                'carForm' => $formData,
                // round the car value by the hundreds
                'carValue' => !empty($carValueData['carValue']) ? round(floor(intval($carValueData['carValue']) / 100) * 100) : 0,
                // only show first 100 cars to the users
                'carData' => !empty($carValueData['carData']) ? array_slice($carValueData['carData'], 0, 100) : [],
                'errorMsg' => !empty($carValueData['errorMsg']) ? $carValueData['errorMsg'] : [],
                'stateOrProvinceMap' => Dealer::AMERICAN_STATE_MAP + Dealer::CANADIAN_PROV_MAP,
            ]);
        }

        return $this->render('form/car_value.html.twig', [
            'form' => $form,
            'errorMsg' => $errorMsg,
        ]);
    }
}
