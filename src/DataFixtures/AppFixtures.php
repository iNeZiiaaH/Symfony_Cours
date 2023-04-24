<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {

            $category = new Category();
            $category
                ->setName($faker->word)
                ->setDescription($faker->realTextBetween(100, 300));

            $categories[] = $category;
            $manager->persist($category);
        }
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(35))
                ->setDateCreated($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80))
                ->setContent($faker->realTextBetween(200, 500))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($article);
        }
        $manager->flush();
    }
}
