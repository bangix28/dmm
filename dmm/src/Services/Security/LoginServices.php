<?php


namespace App\Services\Security;


use App\Entity\Follow;
use App\Form\RegistrationFormType;
use App\Form\RegistrationType;
use App\Form\UserType;
use App\Services\Profil\ProfilServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class LoginServices extends AbstractController
{
    private $manager;

    private $encoder;

    private $profilServices;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, ProfilServices $profilServices)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->profilServices = $profilServices;
    }

    public function formCreate(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->validationForm($user);
            $follow = new Follow();
            $followId = $user->getId();
            $this->profilServices->addFollow($follow, $user, $request, $followId);
            $form = true;
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
