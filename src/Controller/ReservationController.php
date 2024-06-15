<?php

namespace App\Controller;

use App\Entity\TableReserved;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('{_locale}/reservation', name: 'app_reservation')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new TableReserved();
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Reservation successfully made! Our manager will call you back soon.');
            return $this->redirectToRoute('app_reservation_success');
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('{_locale}/reservation/success', name: 'app_reservation_success')]
    public function success(): Response
    {
        return $this->render('reservation/success.html.twig');
    }
}
