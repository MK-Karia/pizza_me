<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pizza;
use App\Entity\Order;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StorefrontController extends AbstractController
{
    private UserRepository $userRepository;
    private PizzaRepository $pizzaRepository;
    private OrderRepository $orderRepository;

    public function __construct(UserRepository $userRepository, PizzaRepository $pizzaRepository, OrderRepository $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->pizzaRepository = $pizzaRepository;
        $this->orderRepository = $orderRepository;
        session_start();
        //$_SESSION['user'] = null;
        //$_SESSION['user_id'] = null;
        //$_SESSION['user_name'] = null;
    }

    public function index(): Response
    {
        return $this->render('home.html.twig', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function registration(): Response
    {
        return $this->render('registration.html.twig', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function login(): Response
    {
        return $this->render('login.html.twig', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function errorPage(string $mess): Response
    {
        return $this->render('error_page.html.twig', ['mess' => $mess, 'userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function userList(): Response
    {
        $userList = $this->userRepository->listAll();
        return $this->render('user_list.html.twig', ['userList' => $userList, 'userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function catalog(): Response
    {
        $pizzaList = $this->pizzaRepository->listAll();
        return $this->render('catalog.html.twig', ['pizzaList' => $pizzaList, 'userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function thanksPage(): Response
    {
        return $this->render('thanks_page.html.twig', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }
}