<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager,): void
    {
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFullName($this->faker->name);

            $user->setPlainPassword('123456');

            $manager->persist($user);
        }
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFullName($this->faker->name);
            $user->setRoles(['ROLE_HAIRDRESSER']);

            $user->setPlainPassword('123456');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
