<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Services\Post\PostServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilController extends AbstractController
{

    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/profil", name="profil")
     * @param Request $request
     * @param Post $post
     * @param UserInterface $user
     * @param PostServices $postServices
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserInterface $user,PostServices $postServices)
    {
            $form = $postServices->formCreate($request, $user);

        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser(),
            'post' => $user->getPosts(),
            'form' => $form->createView()
        ]);
    }

     /**
      * @Route("/profil/post", name="post")
      */
    public function postForm(Request $request, UserInterface $user,PostServices $postServices)
    {
        $form = $postServices->formCreate($request, $user);
        return $this->render('profil/_form.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
