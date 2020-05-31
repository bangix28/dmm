<?php


namespace App\Services\Profil;

use App\Entity\Follow;
use App\Entity\User;
use App\Form\FollowType;
use App\Repository\FollowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilServices extends AbstractController
{

    private $manager;

    private $followRepository;

    public function __construct(EntityManagerInterface $manager, FollowRepository $followRepository)
    {
        $this->manager = $manager;
        $this->followRepository = $followRepository;
    }

    public function follow(Request $request, $user)
    {
        $follow = new Follow();
        $form = $this->createForm(FollowType::class, $follow);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $followId = $request->get('id');
            $this->verification($user, $followId, $request, $follow);

        }
        return $form;
    }

    public function addFollow(Follow $follow,User $user, Request $request, $followId)
    {
        $follow->setFollowedAt(new \DateTime('now'));
       $follow->setFollowedId($followId);
       $follow->setFollower($user);
       $this->manager->persist($follow);
       $this->manager->flush();
       return $this->redirectToRoute('default');
    }

    public function verification( User $user, $followId, $request, $follow)
    {
        $verification = $this->followRepository->findBy(array('follower' => $this->getUser(), 'followedId' => $followId));
        dump($verification);
         if (empty($verification))
         {
             $this->addFollow($follow, $user, $request, $followId);
         }else{
            echo 'rempli !';
         }
    }
}
