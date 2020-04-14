<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet\DTO;

use App\Entity\Wallet;

class ChangeBalance
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var string
     */
    private $transaction;

    /**
     * @var Money
     */
    private $balance;

    /**
     * @var string
     */
    private $reason;

    /**
     * ChangeBalance constructor.
     *
     * @param Wallet $wallet
     * @param string $transaction
     * @param Money $balance
     * @param string $reason
     */
    public function __construct(Wallet $wallet, string $transaction, Money $balance, string $reason)
    {
        $this->wallet = $wallet;
        $this->transaction = $transaction;
        $this->balance = $balance;
        $this->reason = $reason;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @return string
     */
    public function getTransaction(): string
    {
        return $this->transaction;
    }

    /**
     * @return Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }
}