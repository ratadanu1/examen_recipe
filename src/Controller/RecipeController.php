<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;

date_default_timezone_set('Europe/Bucharest');
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\recipe;
use App\Form\recipeCreateType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\recipeService;

class ToDoController extends AbstractController
{
    private $recipeService;

    public function __construct(recipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    #[Route('/recipelist', name: 'app_recipe_list')]
    public function viewrecipeList(PaginatorInterface $paginator, Request $request): Response
    {
        $recipe_list = $this->recipeService->getrecipeList();

        $list = $paginator->paginate(
            $recipe_list,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('to_do/recipe_list.html.twig', [
            'recipelist' => $list,
        ]);
    }

    #[Route('/recipe/view/{id}', name: 'app_recipe')]
    public function viewrecipe(recipe $recipe): Response
    {
        return $this->render('to_do/recipe_view.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/delete/{id}', name: 'app_recipe_delete')]
    public function deleterecipe(int $id): Response
    {
        $recipe = $this->recipeService->deleterecipe($id);

        return $this->redirectToRoute('app_recipe_list');
    }

    #[Route('/recipe/create', name: 'app_recipe_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(recipeCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $date = $form->get('dueDate')->getData();
            $category = $form->get('category_id')->getData();

            $this->recipeService->createrecipe($title, $description, $date, $category);

            return $this->redirectToRoute('app_recipe_list');
        }

        return $this->render('to_do/index.html.twig', [
            'recipe_form' => $form->createView(),
        ]);

    }

    #[Route('/recipe/edit/{id}', name: 'app_recipe_edit')]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(recipeCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $date = $form->get('dueDate')->getData();
            $category = $form->get('category_id')->getData();

            $this->recipeService->editrecipe($id, $title, $description, $date, $category);

            return $this->redirectToRoute('app_recipe_list');
        }

        return $this->render('to_do/index.html.twig', [
            'recipe_form' => $form->createView(),
        ]);
    }
}