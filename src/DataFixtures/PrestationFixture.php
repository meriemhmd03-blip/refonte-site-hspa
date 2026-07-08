<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Prestation; //j'importe mon entité prestation car je vais créer un objet de cette classe

class PrestationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $prestation = new Prestation();

        $prestation->setNom('Head Spa');
        $prestation->setSlug('head-spa');

        $prestation->setHeroSousTitre('Soin du cuir chevelu japonais');

        $prestation->setHeroImage('hero-headspa.webp');

        $prestation->setIntroduction("Découvrez le Head Spa, un rituel inspiré des traditions japonaises qui allie détente profonde, massage du cuir chevelu et soins capillaires pour une expérience de bien-être unique.");

        $prestation->setTechnique("Le soin associe massage du cuir chevelu, techniques de relaxation, nettoyage profond et soins adaptés afin d'améliorer le bien-être et la santé du cuir chevelu.");

        $prestation->setImageTechnique('technique-headspa.webp');

        $prestation->setResultats("À l'issue du soin, le cuir chevelu est assaini, les tensions sont relâchées et les cheveux retrouvent douceur, légèreté et brillance.");

        $prestation->setImageResultats('resultat-headspa.webp');

        $manager->persist($prestation);

        $manager->flush();
    }
}
