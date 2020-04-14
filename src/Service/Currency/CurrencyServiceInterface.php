<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Currency;

interface CurrencyServiceInterface
{
    /**
     * @param int $amount
     * @param string $from
     * @param string $to
     *
     * @return int
     */
    public function convertToCurrency(int $amount, string $from, string $to): int;
}