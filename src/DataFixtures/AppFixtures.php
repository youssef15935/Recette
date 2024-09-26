<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Faker\Factory as FakerFactory;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct(){
        $this->faker = FakerFactory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for( $i = 1; $i < 51; $i++ ) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word());
            $ingredient->setPrice(mt_rand(0, 100)); 
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
