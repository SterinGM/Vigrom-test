<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\API\Mapper;

use App\Service\Wallet\DTO\ChangeBalance as WalletChangeBalance;
use App\API\DTO\ChangeBalance;
use App\API\DTO\WalletBalance;
use App\Entity\Wallet;
use App\Service\Wallet\DTO\Money;

class WalletMapper
{
    /**
     * @param Wallet $wallet
     *
     * @return WalletBalance
     */
    public function mapWalletBalance(Wallet $wallet): WalletBalance
    {
        $balance = round($wallet->getAmount() / 100, 2) . ' ' . $wallet->getCurrency();

        $walletBalance = new WalletBalance();
        $walletBalance->walletId = $wallet->getId();
        $walletBalance->balance = $balance;

        return $walletBalance;
    }

    /**
     * @param array $data
     *
     * @return ChangeBalance
     */
    public function mapChangeBalance(array $data): ChangeBalance
    {
        $changeBalance = new ChangeBalance();
        $changeBalance->walletId = $data['walletId'] ?? null;
        $changeBalance->transactionType = $data['transactionType'] ?? null;
        $changeBalance->amount = $data['amount'] ?? null;
        $changeBalance->currency = $data['currency'] ?? null;
        $changeBalance->reason = $data['reason'] ?? null;

        return $changeBalance;
    }

    /**
     * @param Wallet $wallet
     * @param ChangeBalance $changeBalance
     *
     * @return WalletChangeBalance
     */
    public function mapChangeBalanceToWalletChangeBalance(Wallet $wallet, ChangeBalance $changeBalance): WalletChangeBalance
    {
        $money = new Money($changeBalance->amount, $changeBalance->currency);

        return new WalletChangeBalance($wallet, $changeBalance->transactionType, $money, $changeBalance->reason);
    }
}