<?php


namespace App\Services\Post;


use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostServices extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function formCreate(Request $request, $user)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->validationForm($post, $user, $request);
        }
        return $form;
    }

    public function validationForm(Post $post, User $user, Request $request)
    {
        if ($request->get('id') === null)
        {
            $postFor = $user->getId();
        }else{
            $postFor = $request->get('id');
        }
        $post->setPostFor($postFor);
        $post->setCreatedAt(new \DateTime('now'));
        $post->setLike1('0');
        $post->setComment('0');
        $post->setShare('0');
        $post->setUser($user);
        $this->manager->persist($post);
        $this->manager->flush();
    }
}
