<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Form\OrderFormType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends AbstractController
{
    private $security;
    private $entityManager;
    private $mailer;
    private $dishRepository;

    public function __construct(Security $security, EntityManagerInterface $entityManager, MailerInterface $mailer, DishRepository $dishRepository)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->dishRepository = $dishRepository;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->security->getUser();
            if ($currentUser) {
                $order->setOrderUser($currentUser);
            }
            $cartData = $request->request->get('cart');
            if ($cartData) {
                $cartItems = json_decode($cartData, true);

                foreach ($cartItems as $cartItem) {
                    $dish = $this->dishRepository->find($cartItem['id']);
                    if ($dish) {
                        $orderItem = new OrderItem();
                        $orderItem->setItem($dish);
                        $orderItem->setQuantity($cartItem['quantity']);
                        $orderItem->setOrderData($order);

                        $order->addOrderItem($orderItem);
                    }
                }
            }
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            $this->notifyAdminsAboutNewOrder($order);

            $this->addFlash('success', 'Order successfully made! Our manager will call you back soon.');
            return $this->redirectToRoute('app_cart_success');
        }

        return $this->render('cart/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/cart/success', name: 'app_cart_success')]
    public function success(): Response
    {
        return $this->render('reservation/success.html.twig');
    }

    #[Route('/cart/getItems', name: 'cart_items')]
    public function items(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);

        if (!isset($data['cart']) || !is_array($data['cart'])) {
            return new JsonResponse(['error' => 'Invalid cart data'], 400);
        }

        $formattedDishes = [];

        foreach ($data['cart'] as $item) {
            $dish = $this->dishRepository->find($item['id']);
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

        return new JsonResponse($formattedDishes);
    }

    private function notifyAdminsAboutNewOrder(Order $order): void
    {
//        $adminEmail = $this->getParameter('admin_email');
//
//        $email = (new NotificationEmail())
//            ->subject('New order')
//            ->htmlTemplate('email/order_notification.html.twig')
//            ->from(new Address($this->getParameter('email_from')))
//            ->to(new Address($adminEmail))
//            ->context(['order' => $order]);
//
//        $this->mailer->send($email);
    }
}
