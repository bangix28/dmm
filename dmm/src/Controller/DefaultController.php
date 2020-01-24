<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/category/{category_title}", name="default_category")
     */
    public function category(ArticleRepository $repository, $category_title, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->findCategory($category_title);
        $article = $repository->findByCategory($category);

        return $this->render('default/category.html.twig', ['articles' => $article, 'category' => $category_title] );
    }

    /**
     * @Route("/category/{category_title}/{id}", name="default_article")
     */
    public function article(Article $article, $category_title, CategoryRepository $categoryRepository)
    {
        $categoryRepository->findCategory($category_title);
        return $this->render('default/article.html.twig', ['article' => $article]);
    }
}
