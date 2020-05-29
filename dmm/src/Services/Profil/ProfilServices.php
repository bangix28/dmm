<?php


namespace App\Services\Profil;


use App\Entity\Follow;
use App\Entity\User;
use App\Form\FollowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProfilServices extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function follow(Request $request, $user)
    {
        dump($request->get('id'));
        $follow = new Follow();
        $form = $this->createForm(FollowType::class, $follow);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $this->validationForm($follow,$user, $request);
        }
        return $form;
    }

    public function validationForm(Follow $follow,User $user, Request $request)
    {
        $follow->setFollowedAt(new \DateTime('now'));
       $follow->setFollowedId($request->get('id'));
       $follow->setFollower($user);
       $this->manager->persist($follow);
       $this->manager->flush();
       return $this->redirectToRoute('default');
    }
}
