<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create('it_IT');
        $authors = $manager->getRepository(Author::class)->findAll();

        for ($i = 0; $i <= 500; $i++) {
            $blog = new Blog();

            $blog->setAuthor($generator->randomElement($authors));
            $blog->setTitle($generator->words(rand(4,8), true));
            $blog->setImage($generator->image('assets/images/blog', 600, 350, 'blog', true));
            $blog->setContent($generator->sentences(rand(2,5), true));
            $blog->setPublishedAt($generator->dateTimeBetween('-5 years', 'now'));

            $manager->persist($blog);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AuthorFixtures::class];
    }
}
