<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $author = new Author();
            $author
                ->setFullname($faker->name)
                ->setBiography($faker->paragraph);

            $manager->persist($author);
        }

        $manager->flush();
    }
}
