<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Currency\Exception;

use RuntimeException;

class CurrencyNotFound extends RuntimeException
{
    /**
     * CurrencyNotFound constructor.
     *
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        parent::__construct(
            sprintf(
                'Currency %s does not found', $currency
            )
        );
    }
}