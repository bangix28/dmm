<?php


namespace App\Services\Security;


use App\Entity\User;
use App\Form\EditBirthdayType;
use App\Form\EditFirstNameType;
use App\Form\EditGenderType;
use App\Form\EditLastNameType;
use App\Form\EditMailType;
use App\Form\EditPasswordType;
use App\Form\EditPhoneType;
use App\Form\UsernameType;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserServices extends AbstractController
{
    private $manager;

    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    public function editUser(Request $request, User $user, $form)
    {   $password = false;
        switch ($form) {
            case '1':
                 $formType = EditMailType::class;
                break;
            case '2':
                $formType = EditPasswordType::class;
                $password = true;
                break;
            case '3':
                $formType = EditBirthdayType::class;
                break;
            case '4':
                $formType = EditPhoneType::class;
                break;
            case '5':
                $formType = EditGenderType::class;
                break;
            case '6':
                $formType = EditFirstNameType::class;
                break;
            case '7':
                $formType = EditLastNameType::class;
                break;

        }
        $form = $this->formCreate($request, $user, $formType, $password);
        return $form;
    }

    public function formCreate(Request $request, User $user, $formType, $password)
    {
        $form = $this->createForm($formType, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($password == true)
            {
                $this->setPassword($request, $user);
            }
            $this->manager->persist($user);
            $this->manager->flush();
        }
        return $form;
    }

    public function setPassword($request, User $user)
    {
        $pass_hach = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($pass_hach);

    }
}
