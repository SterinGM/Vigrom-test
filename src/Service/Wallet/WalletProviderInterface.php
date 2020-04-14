<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet;

use App\Entity\Wallet;

interface WalletProviderInterface
{
    /**
     * @param int $id
     *
     * @return Wallet
     */
    public function getWallet(int $id): Wallet;
}