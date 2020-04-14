<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\API\DTO;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeBalance
{
    const MAX_NUMBER = 2147483647;

    /**
     * @var int
     * @SWG\Property(description="Wallet ID")
     * @Assert\NotBlank
     * @Assert\Range(min=1, max=ChangeBalance::MAX_NUMBER)
     */
    public $walletId;

    /**
     * @var string
     * @SWG\Property(enum={"DEBIT", "CREDIT"}, description="Transaction type")
     * @Assert\NotBlank
     * @Assert\Choice(callback={"App\DBAL\Types\TransactionType", "getValues"})
     */
    public $transactionType;

    /**
     * @var float
     * @SWG\Property(type="number", description="Amount")
     * @Assert\NotBlank
     * @Assert\Range(min=0, max=ChangeBalance::MAX_NUMBER)
     */
    public $amount;

    /**
     * @var string
     * @SWG\Property(enum={"RUB", "USD"}, description="Currency")
     * @Assert\NotBlank
     * @Assert\Choice(callback={"App\DBAL\Types\CurrencyType", "getValues"})
     */
    public $currency;

    /**
     * @var string
     * @SWG\Property(enum={"STOCK", "REFUND"}, description="Reason type")
     * @Assert\NotBlank
     * @Assert\Choice(callback={"App\DBAL\Types\ReasonType", "getValues"})
     */
    public $reason;
}