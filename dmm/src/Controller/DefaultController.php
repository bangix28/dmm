<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Services\Article\ArticleServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{

    public $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

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

    /**
     * @Route("/article/new", name="default_create_article")
     * @Route("/article/{id}/edit")
     */
    public function createArticle( ArticleServices $articleServices, Request $request, UserInterface $user, Article $article = null)
    {
        if (!$article) {
            $article = new Article();
        }
        $article = new Article();
        $form = $articleServices->formCreate($article, $request, $user);
        if ($form === true) {
            $category = $article->getCategory();
            return $this->redirectToRoute('default_article', ['id' => $article->getId(), 'category_title' => $category->getTitle() ]);
        }
            return $this->render('default/createArticle.html.twig',
                ['form' => $form->createView(),
                    'editMode' => $article->getId() !== null]);
    }

}
