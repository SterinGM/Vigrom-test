<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class CurrencyType extends AbstractEnumType
{
    public const RUB = 'RUB';
    public const USD = 'USD';

    protected static $choices = [
        self::RUB => 'RUB',
        self::USD => 'USD',
    ];
}