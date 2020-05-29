<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\Post\PostServices;
use App\Services\Profil\ProfilServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilController extends AbstractController
{

    private $postRepository;
    private  $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/profil", name="profil")
     * @param Request $request
     * @param UserInterface $user
     * @param PostServices $postServices
     * @return Response
     */
    public function index(Request $request, UserInterface $user, PostServices $postServices, ProfilServices $profilServices)
    {
            $id = $request->get('id');
            $form = $postServices->formCreate($request, $user);
            $follow = $profilServices->follow($request, $user);
        return $this->render('profil/index.html.twig', [
            'user' => $this->userRepository->find(array('id' => $id)),
            'post' => $this->postRepository->findBy(array('postFor' => $id), array('createdAt' => 'desc')),
            'form' => $form->createView(),
            'follow' => $follow->createView()
        ]);
    }

}
