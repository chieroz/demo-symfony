<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create('it_IT');
        $authors = $manager->getRepository(Author::class)->findAll();

        for ($i = 0; $i <= 500; $i++) {
            $article = new Article();

            $article->setAuthor($generator->randomElement($authors));
            $article->setTitle($generator->words(rand(3,5), true));
            $article->setSummary($generator->words(rand(10,16), true));
            $article->setContent($generator->sentence(10));
            $article->setPublishedAt($generator->dateTimeBetween('-5 years', 'now'));

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AuthorFixtures::class];
    }
}
