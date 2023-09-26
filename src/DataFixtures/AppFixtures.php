<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Books;
use App\Entity\Authors;
use App\Entity\Borrows;
use Monolog\DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $livre = new Books();
            $livre->setTitle($faker->sentence(3))
                ->setCategory($faker->sentence(1))
                ->setPublicationDate(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')))
                ->setStock($faker->numberBetween(0, 100));

            for ($j = 0; $j < mt_rand(1, 5); $j++) {
                $auteur = new Authors();
                $auteur->setName($faker->name())
                    ->setBirthDate(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-50 years', '-20 years')))
                    ->setBiography($faker->text(200));

                $auteur->addBook($livre);
                $manager->persist($auteur);
                $livre->addAuthor($auteur);
            }
            $manager->persist($livre);
        }

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPseudo($faker->userName())
                ->setPlainPassword('password');
            $manager->persist($user);
        }
        for ($j = 0; $j < mt_rand(1, 5); $j++) {
            $borrow = new Borrows();
            $borrow->setBook($livre->getTitle())
                ->setUser($user);
            $manager->persist($borrow);
        }
        $manager->flush();
    }
}
