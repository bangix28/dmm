<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchType;
use App\Repository\UserRepository;
use App\Services\Security\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $session;

    private $repo;

    public function __construct(SessionInterface $session, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->repo = $userRepository;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */

    public function index(): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $this->getUser(),
            ]);
    }

    /**
     * @Route("/edit", name="user_edit")
     * @param Request $request
     * @param UserServices $userServices
     * @param User $user
     * @return Response
     */
    public function edit(Request $request,UserInterface $user,UserServices $userServices)
    {
        $form = $request->get('f');
        $form = $userServices->editUser($request, $user, $form);
        return $this->render('user/edit.html.twig',  [
            'form' => $form->createView(),
            'user'=> $user
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    public function search(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('search', SearchType::class)
            ->getForm();
        $form->handleRequest($request);
      return $this->render('_form.html.twig',[
          'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/search", name="handleSearch")
     * @return Response
     */
    public function handleSearch(Request $request)
    {
       $query = $request->request->get('form')['search'];
        if ($query)
        {
            $user = $this->repo->findUser($query);
            dump($user);
        }
        return $this->render('user/user_search.html.twig', [
            'user' => $user,
            'query' => $query
        ]);
    }
}
