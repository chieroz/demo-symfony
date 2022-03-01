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
        $generator = Factory::create('it_IT');

        for ($i = 0; $i <= 100; $i++) {
            $author = new Author();

            $author->setFirstName($generator->firstName);
            $author->setLastName($generator->lastName());
            $author->setAvatar($generator->image('assets/images/author', 40, 40, 'author', true));

            $manager->persist($author);
        }

        $manager->flush();
    }
}
