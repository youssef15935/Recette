<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;
   

    public function __construct(){
        $this->faker = FakerFactory::create('fr_FR');
        
    }

    public function load(ObjectManager $manager ): void
    {
        for( $i = 1; $i < 51; $i++ ) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word());
            $ingredient->setPrice(mt_rand(0, 100)); 
            $manager->persist($ingredient);
        }
        for ($i=0; $i < 10; $i++) { 
                    $user = new User();
                    $user->setfullName($this->faker->name());
                    $user->setPseudo(mt_rand(0,1));
                    $user->setEmail($this->faker->email());
                    $user->setRoles(['ROLE USER']);
                    //password hashed
                    $user->setPlainPassword('password');
                    
                    $manager ->persist($user);
                }
        $manager->flush();


}
}