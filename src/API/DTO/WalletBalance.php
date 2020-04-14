<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\API\DTO;

use Swagger\Annotations as SWG;

class WalletBalance
{
    /**
     * @var int
     * @SWG\Property(description="Wallet ID")
     */
    public $walletId;

    /**
     * @var string
     * @SWG\Property(description="Wallet balance")
     */
    public $balance;
}