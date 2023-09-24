<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Livres;
use App\Entity\Auteurs;
use Monolog\DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $livre = new Livres();
            $livre->setTitre($faker->sentence(3))
                ->setCategorie($faker->sentence(1))
                ->setDatePublication(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')))
                ->setStock($faker->numberBetween(0, 100));

            for ($j = 0; $j < mt_rand(0, 5); $j++) {
                $auteur = new Auteurs();
                $auteur->setNom($faker->name())
                    ->setBirthDate(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-50 years', '-20 years')))
                    ->setBiographie($faker->text(200));

                $auteur->addLivres($livre);
                $manager->persist($auteur);
                $livre->addAuteurs($auteur);
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

        $manager->flush();
    }
}
