<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $authors = $manager->getRepository(Author::class)->findAll();
        for ($i = 0; $i < 50; $i++) {
            $book = new Book();
            $book
                ->setTitle($faker->company)
                ->setType($faker->randomElement(BOOK_TYPES))
                ->setIsbn($faker->unique()->bankAccountNumber)
                ->setAuthor($faker->randomElement($authors));

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
        ];
    }
}
