<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const SPECIALITY = ['coupe' => 30, 'coloration' => 90, 'meches' => 90, 'balayage' => 90,
        'permanente' => 60, 'lissage' => 50,
        'soins' => 30];


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
            $this->addReference('user_' . $i, $user);
        }
        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setFullName($this->faker->name);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPlainPassword('123456');
        $manager->persist($user);
        $this->addReference('user_' . $i, $user);
        $manager->flush();

        foreach (self::SPECIALITY as $key => $spec)
    {
        $speciality = new Speciality();
        $speciality->setNameSpeciality($key);
        $speciality->setDuration($spec);
        $speciality->setContent($this->faker->text());

        $manager->persist($speciality);
}
        $manager->flush();
    }
}
