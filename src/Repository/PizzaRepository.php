<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PizzaRepository
{

    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Pizza::class);
    }

    public function findById(int $id): ?Pizza
    {
        return $this->repository->findOneBy(['id' => (string) $id]);
    }

    public function store(Pizza $pizza): int
    {
        $this->entityManager->persist($pizza);
        $this->entityManager->flush();
        return $pizza->getId();
    }

    public function delete(Pizza $pizza): void
    {
        $this->entityManager->remove($pizza);
        $this->entityManager->flush();
    }

    /**
     * @return Pizza[]
     */
    public function listAll(): array
    {
        return $this->repository->findAll();
    }
}