<?php


namespace App\Services\Article;


use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;


class ArticleServices extends  AbstractController
{

    protected $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function formCreate( Article $article, Request $request,UserInterface $user)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
                $article->setAuthor($user->getUsername());
            }
            $this->formValidation($article);
            $form = true;
            return $form;
        }
        return $form;
    }

    public function formValidation($article)
    {
        $this->manager->persist($article);
        $this->manager->flush();
    }


}