<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\FollowRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{

    private $postRepo;

    private $followRepository;

    public function __construct(PostRepository $postRepo, FollowRepository $followRepository )
    {
        $this->postRepo = $postRepo;
        $this->followRepository = $followRepository;
    }

    /**
     * @Route("/", name="default")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserInterface $user)
    {
        return $this->render('default/index.html.twig', [
           'post' => $this->postRepo->findBy(array('user' => $this->followRepository->findBy(array('follower' => $user->getId()))))
        ]);
    }

}
