<?php

namespace App\Controller;

use App\Services\Security\LoginServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;


class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login( )
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(LoginServices $loginServices, Request $request )
    {
        $form = $loginServices->formCreate($request);
        if ($form === true)
        {
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registrationView.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}
}
