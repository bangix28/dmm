<?php

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{
    public function __construct( )
    {
    }

    /**
     * @Route("/", name="default")
     */
    public function index(UserInterface $user)
    {
        dump($user);
        return $this->render('default/index.html.twig', [
           'user' => $user
        ]);
    }

}
