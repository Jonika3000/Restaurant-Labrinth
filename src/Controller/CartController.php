<?php

namespace App\Controller;

use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
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
