<?php

namespace App\DataFixtures;

use App\Entity\Stock;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture

{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager ): void
    {

        $user1 = new User();
        $pwd = $this->hasher->hashPassword($user1 , 'Noirot17');
        $user1
            ->setUsername("hartur")
            ->setPassword($pwd)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user1);
        $stock = new Stock();
        $stock
            ->setCash(0)
            ->setMunition(0)
            ->setMarchandise(0)
            ->setMetal(0)
            ->setDiamant(0);
        $manager->persist($stock);
        $manager->flush();
    }
}
