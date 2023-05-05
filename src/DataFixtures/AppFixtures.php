<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 150;
    private const NB_CATEGORIES = 20;

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = [];
        $regularUser = new User();
        $regularUser
            ->setEmail("bob@bob.com")
            ->setPassword('test');

        $manager->persist($regularUser);
        $users[] = $regularUser;
        $adminUser = new User();
        $adminUser
            ->setEmail("admin@domain.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword('test');
        $users[] = $adminUser;
        $manager->persist($adminUser);

        for ($i = 0, $categories = []; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category
                ->setName($faker->word())
                ->setDescription($faker->realTextBetween(100, 300));

            $categories[] = $category;

            $manager->persist($category);
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(35))
                ->setDateCreated($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80))
                ->setContent($faker->paragraphs(6, true))
                ->setCategory($faker->randomElement($categories))
                ->setUser($faker->randomElement($users));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
