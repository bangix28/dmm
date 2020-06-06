<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager )
    {
        $faker = Factory::create('fr_FR');

        for ($i=1; $i <= 30; $i++)
        {
            //create user
            $user = new User();
            $password = $this->encoder->encodePassword($user, 'pass_1234');
            $user->setPassword($password)
                 ->setImages('user.png')
                ->setEmail($faker->email)
                ->setRoles(array('ROLES_USER'))
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName);
            $manager->persist($user);

            //create 5 post
            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

            for ($j = 1; $j <= mt_rand(4,6); $j++)
            {
                $post = new Post();
                $post->setPostFor(mt_rand(1,30))
                    ->setUser($user)
                    ->setShare(mt_rand(1,30))
                    ->setComment(mt_rand(1,30))
                    ->setLike1(mt_rand(1,30))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                    ->setContent($content);
                $manager->persist($post);

            }

        }

        $manager->flush();
    }
}
