<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class ReasonType extends AbstractEnumType
{
    public const STOCK = 'STOCK';
    public const REFUND = 'REFUND';

    protected static $choices = [
        self::STOCK => 'stock',
        self::REFUND => 'refund',
    ];
}