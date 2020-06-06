<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Entity\User;
use App\Repository\FollowRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\Post\PostServices;
use App\Services\Profil\ProfilServices;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilController extends AbstractController
{

    private $postRepository;

    private  $userRepository;

    private $followRepository;

    private $manager;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository, FollowRepository $followRepository, EntityManagerInterface $manager)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->followRepository = $followRepository;
        $this->manager = $manager;

    }

    /**
     * @Route("/profil", name="profil")
     * @param Request $request
     * @param UserInterface $user
     * @param PostServices $postServices
     * @return Response
     */
    public function index(Request $request, UserInterface $user, PostServices $postServices)
    {
            $id = $request->get('id');
            $form = $postServices->formCreate($request, $user);
            $follow = $this->followRepository->findOneBy(array('follower' => $this->getUser(), 'followedId' => $id));
        return $this->render('profil/index.html.twig', [
            'user' => $this->userRepository->find(array('id' => $id)),
            'post' => $this->postRepository->findBy(array('postFor' => $id), array('createdAt' => 'desc')),
            'form' => $form->createView(),
            'follow' => $follow
        ]);
    }

    /**
     * @Route("profil/add",name="profile_add_follow")
     * @param User $user
     * @param Request $request
     * @param ProfilServices $profilServices
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addFollow(UserInterface $user, Request $request, ProfilServices $profilServices)
    {
        $follow = new Follow();
        $followId = $request->get('id');
        $profilServices->addFollow($follow, $user, $followId );

        return $this->redirectToRoute('profil', array('id' => $followId));
    }

    /**
     * @Route("profil/delete/{$id}",name="profile_del_follow")

     */
    public function deleteFollow(UserInterface $user, Request $request)
    {
        $id = $request->get('id');
        $follow = $this->followRepository->find($id);
        $this->manager->remove($follow);
        $this->manager->flush();
        return $this->redirectToRoute('profil', array('id' => $request->get('pId') ));
    }

}
