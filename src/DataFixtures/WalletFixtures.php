<?php

namespace App\DataFixtures;

use App\DBAL\Types\CurrencyType;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WalletFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $wallet = new Wallet();
            $wallet->setUserId($i);
            $wallet->setCurrency(CurrencyType::getRandomValue());

            $manager->persist($wallet);
        }

        $manager->flush();
    }
}
