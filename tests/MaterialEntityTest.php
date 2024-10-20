<?php

namespace App\Tests;

use App\Entity\Material;
use App\Entity\TVA;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MaterialEntityTest extends KernelTestCase
{
  private mixed $validator;

  protected function setUp(): void
  {
    self::bootKernel();
    $this->validator = $this->getContainer()->get('validator');
  }

  public function testMaterialIsValid(): void
  {
    $tva = new TVA();
    $tva->setValue('0.20')
      ->setLabel('TVA 20%');

    $material = new Material();
    $material->setName("Ecran")
      ->setPriceHT('100.00')
      ->setPriceTTC('110.00')
      ->setQuantity(quantity: 10)
      ->setTVA($tva);
    $material->setCreatedAt();

    $errors = $this->validator->validate($material);
    $this->assertCount(0, $errors);
  }

  public function testMaterialWithInvalidPriceHTAndTTC(): void
  {
    $tva = new TVA();
    $tva->setValue('0.20')
      ->setLabel('TVA 20%');

    $material = new Material();
    $material->setName("Ecran")
      ->setPriceTTC('11000000000000.0')
      ->setPriceHT('100000000000.20')
      ->setTVA($tva);

    $errors = $this->validator->validate($material);
    $this->assertCount(2, $errors);
  }
}
