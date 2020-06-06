<?php


namespace App\Services\Profil;

use App\Entity\Follow;
use App\Entity\User;
use App\Form\FollowType;
use App\Repository\FollowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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

    public function addFollow( Follow $follow, $user ,$followId)
    {
        $follow->setFollowedAt(new \DateTime('now'));
       $follow->setFollowedId($followId);
       $follow->setFollower($user);
       $this->manager->persist($follow);
       $this->manager->flush();
    }

}
