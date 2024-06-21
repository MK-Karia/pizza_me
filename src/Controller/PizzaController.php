<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PizzaController extends AbstractController
{
    private PizzaRepository $pizzaRepository;

    public function __construct(PizzaRepository $pizzaRepository)
    {
        $this->pizzaRepository = $pizzaRepository;
        session_start();
    }

    public function viewPizza(int $pizzaId): Response
    {
        $pizza = $this->pizzaRepository->findById($pizzaId);
        if (!$pizza)
        {
            $mess = 'Такой пиццы у нас нет';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);       
        }

        return $this->render('pizza.html.twig', [
            'id' => $pizza->getId(),
            'name' => $pizza->getName(),
            'ingredients' => $pizza->getIngredients(),
            'discription' => $pizza->getDiscription(),
            'price' => $pizza->getPrice(),
            'imagePath' => $pizza->getImagePath(),
            'userName' => $_SESSION['user_name'],
            'userId' => $_SESSION['user_id'], 
        ]);
    }
}