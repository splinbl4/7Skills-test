<?php

namespace App\DataFixtures;

use App\Module\Sale\Entity\Cashbox\Cashbox;
use App\Module\Sale\Entity\Cashbox\Timezone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CashboxFixtures
 * @package App\DataFixtures
 */
class CashboxFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $cashboxFirst = new Cashbox(new Timezone(-8), 'Касса 1');
         $manager->persist($cashboxFirst);

         $cashboxSecond = new Cashbox(new Timezone(0), 'Касса 2');
         $manager->persist($cashboxSecond);

         $cashboxThird = new Cashbox(new Timezone(8), 'Касса 3');
         $manager->persist($cashboxThird);

        $manager->flush();
    }
}
