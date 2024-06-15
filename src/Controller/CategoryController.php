<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SiteLocale;
use App\Entity\Translate\CategoryTranslate;
use App\Entity\Translate\DishTranslate;
use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use App\Repository\SiteLocaleRepository;
use App\Repository\Translate\CategoryTranslateRepository;
use App\Repository\Translate\DishTranslateRepository;
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
                          DishRepository $dishRepository, SiteLocaleRepository $siteLocaleRepository): Response
    {
        $localeRequest = $request->getLocale();
        $locale = $siteLocaleRepository->findOneBy(['name'=>$localeRequest]);
        $categories = $categoryRepository->findBy(['parent'=>null]);
        $dishes = $dishRepository->findAll();

        if ($locale !== "en" && isset($locale))
        {
            //category trans
            $repositoryTranslate = $entityManager->getRepository(CategoryTranslate::class);
            $this->translateCategories($categories, $repositoryTranslate, $locale);
            //dish trans
            $repositoryTranslate = $entityManager->getRepository(DishTranslate::class);
            $this->translateDishes($dishes, $repositoryTranslate, $locale);
        }

        $uploadsBasePath = $this->getParameter('uploads_base_path');
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'items' => $dishes,
            'uploads_base_path' => $uploadsBasePath
        ]);
    }

    #[Route('{_locale}/category/show/{id}', name: 'app_category_show')]
    public function show(Category $category, DishRepository $dishRepository, CategoryRepository $categoryRepository,
                         EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $localeRequest = $request->getLocale();
        $repositoryLocale = $entityManager->getRepository(SiteLocale::class);
        $locale = $repositoryLocale->findOneBy(['name' => $localeRequest]);

        $data = [];
        $dishes = $dishRepository->findBy(['category' => $category]);

        if ($locale !== "en" && isset($locale)) {
            $repositoryTranslate = $entityManager->getRepository(CategoryTranslate::class);
            $categoryTranslate = $repositoryTranslate->findOneBy(['locale' => $locale, 'category' => $category]);
            if ($categoryTranslate) {
                $category->setName($categoryTranslate->getName());
                $category->setDescription($categoryTranslate->getDescription());
            }

            $repositoryDishTranslate = $entityManager->getRepository(DishTranslate::class);
            $this->translateDishes($dishes, $repositoryDishTranslate, $locale);
        }

        $data['items'] = $this->formatDishes($dishes);
        $data['items'] = array_merge($data['items'], $this->getItemsFromChildrenCategories($category, $dishRepository, $locale, $entityManager));

        $subCategories = $categoryRepository->findBy(['parent' => $category]);
        $data['subCategories'] = [];
        foreach ($subCategories as $subCategory) {
            if ($locale !== "en" && isset($locale)) {
                $repositoryTranslate = $entityManager->getRepository(CategoryTranslate::class);
                $this->translateCategories($subCategories, $repositoryTranslate, $locale);
            }

            $data['subCategories'][] = [
                'id' => $subCategory->getId(),
                'name' => $subCategory->getName(),
                'description' => $subCategory->getDescription()
            ];
        }

        return new JsonResponse($data);
    }

    private function translateCategories(array $categories, CategoryTranslateRepository $categoryTranslateRepository, SiteLocale $locale)
    {
        foreach ($categories as $category)
        {
            $categoryTranslate = $categoryTranslateRepository->findBy(['locale' => $locale, 'category'=> $category]);
            if (isset($categoryTranslate[0])) {
                $category->setName($categoryTranslate[0]->getName());
                $category->setDescription($categoryTranslate[0]->getDescription());
            }
        }
        return $categories;
    }

    private function translateDishes(array $dishes, DishTranslateRepository $dishTranslateRepository, SiteLocale $locale)
    {
        foreach ($dishes as $dish)
        {
            $dishTranslate = $dishTranslateRepository->findBy(['locale' => $locale, 'dish'=> $dish]);
            if (isset($dishTranslate[0])) {
                $dish->setName($dishTranslate[0]->getName());
                $dish->setDescription($dishTranslate[0]->getDescription());
            }
        }
        return $dishes;
    }

    private function getItemsFromChildrenCategories(Category $category, DishRepository $dishRepository, $locale, EntityManagerInterface $entityManager): array
    {
        $items = [];
        $repositoryDishTranslate = $entityManager->getRepository(DishTranslate::class);

        foreach ($category->getChildren() as $childCategory) {
            $dishes = $dishRepository->findBy(['category' => $childCategory]);

            if ($locale !== "en" && isset($locale)) {
                foreach ($dishes as $dish) {
                    $dishTranslate = $repositoryDishTranslate->findOneBy(['locale' => $locale, 'dish' => $dish]);
                    if ($dishTranslate) {
                        $dish->setName($dishTranslate->getName());
                        $dish->setDescription($dishTranslate->getDescription());
                    }
                }
            }

            $items = array_merge($items, $this->formatDishes($dishes));
        }

        return $items;
    }

    private function formatDishes(array $dishes): array
    {
        $formattedDishes = [];

        foreach ($dishes as $dish) {
            $formattedDishes[] = [
                'id' => $dish->getId(),
                'name' => $dish->getName(),
                'description' => $dish->getDescription(),
                'price' => $dish->getPrice(),
                'discount' => $dish->getDiscount(),
                'photo' => $dish->getPhoto(),
            ];
        }

        return $formattedDishes;
    }

}
