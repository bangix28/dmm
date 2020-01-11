<?php

namespace App\Controller;

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
     * @Route("/{category}", name="default_categorie")
     */
    public function category(ArticleRepository $repository, CategoryRepository $categoryRepository, Request $request )
    {
        $articles = $repository->findAll();

        return $this->render('frontend/category.html.twig', 'article' => $article);
    }
}
