<?php

namespace App\DataFixtures;

use App\Entity\Countries as EntityCountries;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Countries extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $country = new EntityCountries();
        $country->setName('Bénin');
        $manager->persist($country);

        $manager->flush();
    }
}
