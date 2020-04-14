<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class TransactionType extends AbstractEnumType
{
    public const DEBIT = 'DEBIT';
    public const CREDIT = 'CREDIT';

    protected static $choices = [
        self::DEBIT => 'debit',
        self::CREDIT => 'credit',
    ];
}