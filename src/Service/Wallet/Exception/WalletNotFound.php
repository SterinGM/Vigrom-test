<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet\Exception;

use RuntimeException;

class WalletNotFound extends RuntimeException
{
    /**
     * WalletNotFound constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        parent::__construct(
            sprintf(
                'Wallet by id %d does not found', $id
            )
        );
    }
}