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
     * @Route("/{category_id}", name="default_category")
     */
    public function category(ArticleRepository $repository, $category_id, CategoryRepository $categoryRepository)
    {
        $article = $repository->findByCategory($category_id);
        dump($category = $categoryRepository->find($category_id));
        return $this->render('frontend/category.html.twig', ['article' => $article, 'category' => $category] );
    }

    /**
     * @Route("/{category_id}/{id}", name="default_article")
     */
    public function article(Article $article)
    {
        return $this->render('frontend/article.html.twig', ['article' => $article]);
    }
}
