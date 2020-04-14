<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet\Exception;

use RuntimeException;

class NotEnoughMoney extends RuntimeException
{
    /**
     * NotEnoughMoney constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        parent::__construct(
            sprintf(
                'Not enough money in the wallet %d', $id
            )
        );
    }
}