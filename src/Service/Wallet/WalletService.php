<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet;

use App\DBAL\Types\TransactionType;
use App\Repository\WalletRepository;
use App\Service\Currency\CurrencyServiceInterface;
use App\Service\Wallet\DTO\ChangeBalance;
use App\Service\Wallet\Exception\NotEnoughMoney;
use Exception;

class WalletService implements WalletServiceInterface
{
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * @var CurrencyServiceInterface
     */
    private $currencyService;

    /**
     * WalletService constructor.
     *
     * @param WalletRepository $walletRepository
     * @param CurrencyServiceInterface $currencyService
     */
    public function __construct(WalletRepository $walletRepository, CurrencyServiceInterface $currencyService)
    {
        $this->walletRepository = $walletRepository;
        $this->currencyService = $currencyService;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function changeBalance(ChangeBalance $changeBalance): void
    {
        $amount = $this->currencyService->convertToCurrency(
            $changeBalance->getBalance()->getAmount(),
            $changeBalance->getBalance()->getCurrency(),
            $changeBalance->getWallet()->getCurrency()
        );

        // я предпологаю что дебетовая операция это списание средств
        if ($changeBalance->getTransaction() === TransactionType::DEBIT) {
            if ($amount > $changeBalance->getWallet()->getAmount()) {
                throw new NotEnoughMoney($changeBalance->getWallet()->getId());
            }

            $amount = $amount * -1;
        }

        $this->walletRepository->changeBalance($changeBalance, $amount);
    }
}