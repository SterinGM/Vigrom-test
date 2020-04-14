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
     * @SWG\Property(description="The unique identifier of the wallet.")
     */
    public $walletId;

    /**
     * @var string
     * @SWG\Property(type="string")
     */
    public $balance;
}