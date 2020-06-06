<?php


namespace App\Services\Security;


use App\Entity\Follow;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Services\Profil\ProfilServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class LoginServices extends AbstractController
{
    private $manager;

    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    public function formCreate(Request $request,ProfilServices $profileServices)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->validationForm($user);
            $form = true;
            $follow = new Follow();
            $followId = $user->getId();
            $profileServices->addFollow($follow, $user,$followId);
            return $form;
        }
        return $form;
    }

    public function validationForm(User $user)
    {
        $pass_hach = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($pass_hach);
        $user->setRoles(['ROLES_USER']);
        $user->setImages('user.png');
        $this->manager->persist($user);
        $this->manager->flush();
    }



}
