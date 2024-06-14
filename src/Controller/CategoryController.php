<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\SiteLocale;
use App\Entity\Translate\CategoryTranslate;
use App\Entity\Translate\DishTranslate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('{_locale}/categories', name: 'app_category')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $localeRequest = $request->getLocale();
        $repositoryLocale = $entityManager->getRepository(SiteLocale::class);
        $locale = $repositoryLocale->findOneBy(['name'=>$localeRequest]);
        $categoriesRepo = $entityManager->getRepository(Category::class);
        $categories = $categoriesRepo->findBy(['parent'=>null]);
        $repositoryDish = $entityManager->getRepository(Dish::class);
        $dishes = $repositoryDish->findAll();

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
}
