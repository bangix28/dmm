<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // Créer 3 catégorie Faker
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
            $manager->persist($category);
            //on créer 5 articles
            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
            for ($j = 1;$j <= mt_rand(4, 6) ; $j++) {
                $article = new Article();
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setAuthor($faker->name())
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                    ->setCategory($category);
                $manager->persist($article);
            }
        }
        $manager->flush();
    }
}
