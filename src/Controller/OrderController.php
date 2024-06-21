<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\PizzaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends AbstractController
{
    private PizzaRepository $pizzaRepository;
    private UserRepository $userRepository;
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository, PizzaRepository $pizzaRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->pizzaRepository = $pizzaRepository;
        $this->userRepository = $userRepository;
        session_start();
    }

    public function orderPage(int $pizzaId): Response
    {
        $pizza = $this->pizzaRepository->findById($pizzaId);
        if (!$pizza)
        {
            $mess = 'Такой пиццы у нас нет';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);       
        }

        if ($_SESSION['user'] != 'user') {
            return $this->redirectToRoute('login'); 
        }

        return $this->render('order_page.html.twig', [
            'id' => $pizza->getId(),
            'name' => $pizza->getName(),
            'ingredients' => $pizza->getIngredients(),
            'discription' => $pizza->getDiscription(),
            'price' => $pizza->getPrice(),
            'imagePath' => $pizza->getImagePath(),
            'user' => $_SESSION['user'],
            'userName' => $_SESSION['user_name'],
            'userId' => $_SESSION['user_id'], 
        ]);
    }

    public function makeOrder(Request $data): ?Response
    {

        $date = new \DateTime(date("Y-m-d H:i:s"));
        $orderDate = \DateTimeImmutable::createFromInterface($date);
        //$orderDate = \DateTimeImmutable::createFromFormat(date("Y-m-d H:i:s"), "Y-m-d H:i:s");

        if (($this->userRepository->findById((int)($data->get('user_id'))) == null) || 
                ($this->pizzaRepository->findById((int)($data->get('pizza_id'))) == null)) {
            $mess = 'The user with this email already exists';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);  
        } 

        $order = new Order(
            null, 
            (int)($data->get('user_id')),
            (int)($data->get('pizza_id')),
            $data->get('address'),
            (int)($data->get('price')),
            $orderDate,
        );

        $orderId = $this->orderRepository->store($order);
        return $this->redirectToRoute('thanks_page', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }
}