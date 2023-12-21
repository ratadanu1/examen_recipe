<?php

namespace App\Service;

use App\Entity\recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class recipeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createrecipe($title, $description, $date, $category): recipe
    {
        $recipe = new recipe();
        $recipe->setTitle($title);
        $recipe->setDescription($description);
        $recipe->setDueDate($date);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->setCategoryId($category);

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return $recipe;
    }

    //edit recipe method
    public function editrecipe($id, $title, $description, $date, $category): recipe
    {
        $recipe = $this->entityManager->getRepository(recipe::class)->find($id);

        $recipe->setTitle($title);
        $recipe->setDescription($description);
        $recipe->setDueDate($date);
        $recipe->setCategoryId($category);

        $this->entityManager->flush();

        return $recipe;
    }

    //recipe list method
    public function getrecipeList()
    {
        $recipeRepository = $this->entityManager->getRepository(recipe::class);
        $recipes = $recipeRepository->findAll();

        return $recipes;
    }

    // delete recipe method
    public function deleterecipe($id): void
    {
        $recipe = $this->entityManager->getRepository(recipe::class)->find($id);

        $this->entityManager->remove($recipe);
        $this->entityManager->flush();
    }
}
