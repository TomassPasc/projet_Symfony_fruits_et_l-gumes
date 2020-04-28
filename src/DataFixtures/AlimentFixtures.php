<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AlimentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $a1 = new Aliment();
        $a1->setNom("Carotte")
            ->setPrix(1.8)
            ->setCalorie(36)
            ->setProteine(0.77)
            ->setGlucide(6.45)
            ->setLipide(0.26)
            ->setImage("aliments/carotte.png")
            ;
        $manager->persist($a1);

        $a2 = new Aliment();
        $a2->setNom("Patate")
            ->setPrix(1.5)
            ->setCalorie(80)
            ->setProteine(1.8)
            ->setGlucide(16.7)
            ->setLipide(0.34)
            ->setImage("aliments/patate.png")
            ;
        $manager->persist($a2);

        $a3 = new Aliment();
        $a3->setNom("Tomate")
            ->setPrix(2.3)
            ->setCalorie(18)
            ->setProteine(0.86)
            ->setGlucide(2.26)
            ->setLipide(0.24)
            ->setImage("aliments/tomate.png")
            ;
        $manager->persist($a3);

        $a4 = new Aliment();
        $a4->setNom("Pomme")
            ->setPrix(2.35)
            ->setCalorie(52)
            ->setProteine(0.25)
            ->setGlucide(11.6)
            ->setLipide(0.25)
            ->setImage("aliments/pomme.png")
            ;
        $manager->persist($a4);


        $manager->flush();
    }
}
