<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Currency;

use App\DBAL\Types\CurrencyType;
use App\Service\Currency\Exception\CurrencyNotFound;

class CurrencyService implements CurrencyServiceInterface
{
    /**
     * все расчеты происходят в копейках и центах, как советуют делать при работе с деньгами
     *
     * @inheritDoc
     */
    public function convertToCurrency(int $amount, string $from, string $to): int
    {
        if ($from === $to) {
            return $amount;
        }

        $fromRate = $this->getCurrentRate($from);
        $toRate = $this->getCurrentRate($to);

        return round($amount * $fromRate / $toRate);
    }

    /**
     * курс валют может переодически обновляться
     * тут я не делаю логику получения данных с внешних апи, но это сделать не сложно
     * договоримся что валюта по умолчанию usd, следовательно курс для доллара в системе будет равен 1,
     * а для рублей к примеру 0.0134
     * валют может быть сколько угодно, но все преобразования происходят через доллары
     * так что ниже будет условный код для получения различных значений курсов
     *
     * @param string $currency
     *
     * @return float
     */
    private function getCurrentRate(string $currency): float
    {
        switch ($currency) {
            case CurrencyType::USD:
                return 1;
            case CurrencyType::RUB:
                return round(1 / mt_rand(70, 80), 4);
            default:
                throw new CurrencyNotFound($currency);
        }
    }
}