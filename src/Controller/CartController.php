<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            $this->addFlash('success', 'Order successfully made! Our manager will call you back soon.');
            // Redirect to a success route or page
            return $this->redirectToRoute('app_home'); // Adjust to your route
        }

        return $this->render('cart/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cart/getItems', name: 'cart_items')]
    public function items(Request $request, DishRepository $dishRepository): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);

        if (!isset($data['cart']) || !is_array($data['cart'])) {
            return new JsonResponse(['error' => 'Invalid cart data'], 400);
        }
        $formattedDishes = [];

        foreach ($data['cart'] as $item) {
            if (isset($item['id']) && isset($item['quantity'])) {
                $dish = $dishRepository->findOneBy(['id' => $item['id']]);
                if ($dish) {
                    $formattedDishes[] = [
                        'id' => $dish->getId(),
                        'name' => $dish->getName(),
                        'description' => $dish->getDescription(),
                        'price' => $dish->getPrice(),
                        'discount' => $dish->getDiscount(),
                        'photo' => $dish->getPhoto(),
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }
        return new JsonResponse($formattedDishes);
    }

}
