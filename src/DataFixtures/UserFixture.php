<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
     public function __construct(private UserPasswordHasherInterface $hasher)
    {}
    public function load(ObjectManager $manager): void
    {
         //$product = new Product();
        // $manager->persist($product);
        $user=new User();
        $user->setEmail('admin@gmail.com');
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $user->setName('admin');
        $manager->persist($user);
        $manager->flush();
    }
}
