<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Prestation; //j'importe mon entité prestation car je vais créer un objet de cette classe

class PrestationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $prestation = new Prestation(); //Je crée un objet Prestation
        // $manager->persist($product);

        $manager->flush();
    }
}
