<?php

namespace App\Controller;

use App\Services\Security\LoginServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('default_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(LoginServices $loginServices, Request $request )
    {
        $edit = false;
        $form = $loginServices->formCreate($request, $edit);
        if ($form === true)
        {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registrationView.html.twig', ['form' => $form->createView()]);
    }

/**
 * @Route("/logout", name="app_logout")
 */
public function logout()
{
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
}
}
