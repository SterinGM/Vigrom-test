<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet;

use App\Service\Wallet\DTO\ChangeBalance;

interface WalletServiceInterface
{
    /**
     * @param ChangeBalance $changeBalance
     */
    public function changeBalance(ChangeBalance $changeBalance): void;
}