<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SiteLocale;
use App\Entity\Translate\CategoryTranslate;
use App\Entity\Translate\DishTranslate;
use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('{_locale}/category', name: 'app_category')]
    public function index(EntityManagerInterface $entityManager, Request $request, CategoryRepository $categoryRepository,
                          DishRepository $dishRepository): Response
    {
        $localeRequest = $request->getLocale();
        $repositoryLocale = $entityManager->getRepository(SiteLocale::class);
        $locale = $repositoryLocale->findOneBy(['name'=>$localeRequest]);
        $categories = $categoryRepository->findBy(['parent'=>null]);
        $dishes = $dishRepository->findAll();

        if ($locale !== "en" && isset($locale))
        {
            //category trans
            $repositoryTranslate = $entityManager->getRepository(CategoryTranslate::class);
            foreach ($categories as $category)
            {
                $categoryTranslate = $repositoryTranslate->findBy(['locale' => $locale, 'category'=> $category]);
                if (isset($categoryTranslate[0])) {
                    $category->setName($categoryTranslate[0]->getName());
                    $category->setDescription($categoryTranslate[0]->getDescription());
                }
            }
            //dish trans
            $repositoryTranslate = $entityManager->getRepository(DishTranslate::class);
            foreach ($dishes as $dish)
            {
                $dishTranslate = $repositoryTranslate->findBy(['locale' => $locale, 'dish'=> $dish]);
                if (isset($dishTranslate[0])) {
                    $dish->setName($dishTranslate[0]->getName());
                    $dish->setDescription($dishTranslate[0]->getDescription());
                }
            }
        }

        $uploadsBasePath = $this->getParameter('uploads_base_path');
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'items' => $dishes,
            'uploads_base_path' => $uploadsBasePath
        ]);
    }

    #[Route('{_locale}/category/show/{id}', name: 'app_category_show')]
    public function show(Category $category, DishRepository $dishRepository, CategoryRepository $categoryRepository): JsonResponse
    {
        $dishes = $dishRepository->findBy(['category' => $category]);
        $subCategories = $categoryRepository->findBy(['parent'=>$category]);
        $data = [];

        foreach ($dishes as $dish) {
            $data['items'][] = [
                'name' => $dish->getName(),
                'description' => $dish->getDescription(),
                'price' => $dish->getPrice(),
                'photo' => $dish->getPhoto(),
            ];
        }
        foreach ($subCategories as $category) {
            $data['subCategories'][] = [
                'name' => $category->getName(),
                'description' => $category->getDescription()
            ];
        }

        return new JsonResponse($data);
    }
}
