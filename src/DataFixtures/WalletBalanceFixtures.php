<?php

namespace App\DataFixtures;

use App\DBAL\Types\CurrencyType;
use App\DBAL\Types\ReasonType;
use App\DBAL\Types\TransactionType;
use App\Entity\Wallet;
use App\Service\Wallet\DTO\ChangeBalance;
use App\Service\Wallet\DTO\Money;
use App\Service\Wallet\Exception\NotEnoughMoney;
use App\Service\Wallet\WalletServiceInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class WalletBalanceFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * WalletBalanceFixtures constructor.
     *
     * @param WalletServiceInterface $walletService
     */
    public function __construct(WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            /** @var Wallet $wallet */
            $wallet = $this->getReference('wallet_' . $i);

            for ($j = 0; $j < 5; $j++) {
                $money = new Money(mt_rand(1000, 2000), CurrencyType::getRandomValue());
                $changeBalance = new ChangeBalance(
                    $wallet,
                    TransactionType::getRandomValue(),
                    $money,
                    ReasonType::getRandomValue()
                );

                try {
                    $this->walletService->changeBalance($changeBalance);
                } catch (NotEnoughMoney $exception) {
                }

            }
        }
    }

    public function getDependencies()
    {
        return [
            WalletFixtures::class
        ];
    }
}
