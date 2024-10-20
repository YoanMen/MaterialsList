<?php

namespace App\DataFixtures;

use App\Entity\Material;
use App\Entity\TVA;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->generateTVA($manager);
        $this->generateMaterials($manager);
    }

    private function generateMaterials(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 60; ++$i) {
            $material = new Material();
            $tva = $manager->getRepository(TVA::class)->findAll();
            $random = array_rand($tva);

            $material->setName($faker->words(3, true))
                ->setQuantity($faker->numberBetween(0, 150))
                ->setPriceHT(strval($faker->randomFloat(2, 1, 1000)))
                ->setTVA($tva[$random])
                ->setTTC();

            $material->setCreatedAt();

            $manager->persist($material);
        }

        $manager->flush();
    }

    private function generateTVA(ObjectManager $manager): void
    {
        $tva20 = new TVA();
        $tva10 = new TVA();
        $tva05 = new TVA();

        $tva20->setLabel('TVA 20%')
            ->setValue('0.20');

        $tva10->setLabel('TVA 10%')
            ->setValue('0.10');

        $tva05->setLabel('TVA 5%')
            ->setValue('0.05');

        $manager->persist($tva20);
        $manager->persist($tva10);
        $manager->persist($tva05);

        $manager->flush();
    }
}
