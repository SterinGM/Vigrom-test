<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\API\Mapper;

use App\API\DTO\WalletBalance;
use App\Entity\Wallet;

class WalletMapper
{
    public function mapWalletBalance(Wallet $wallet): WalletBalance
    {
        $balance = round($wallet->getAmount() / 100, 2) . ' ' . $wallet->getCurrency();

        $walletBalance = new WalletBalance();
        $walletBalance->walletId = $wallet->getId();
        $walletBalance->balance = $balance;

        return $walletBalance;
    }
}