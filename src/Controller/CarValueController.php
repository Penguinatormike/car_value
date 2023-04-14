<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\CarValueType;
use App\Form\PostType;
use App\Form\Table\CarTable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarValueController extends AbstractController
{
    #[Route('/', name: 'car_value_home')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {

        // See https://symfony.com/doc/current/form/multiple_buttons.html
        $form = $this->createForm(CarValueType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/forms.html#processing-forms
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SubmitButton $submit */
            // Retrieve form data
            $formData = $form->getData();


            $data = [];
            // Render valuation results
            return $this->render('result/car_result.html.twig', [
                'valuation' => 10000, // Replace with actual valuation value
                'data' => $data
            ]);
        }

        return $this->render('form/car_value.html.twig', [
            'form' => $form,
        ]);
    }
}
