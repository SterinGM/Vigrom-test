<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Service\Wallet;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Service\Wallet\Exception\WalletNotFound;

class WalletProvider implements WalletProviderInterface
{
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * WalletProvider constructor.
     *
     * @param WalletRepository $walletRepository
     */
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * @inheritDoc
     */
    public function getWallet(int $id): Wallet
    {
        $wallet = $this->walletRepository->find($id);

        if (null === $wallet) {
            throw new WalletNotFound($id);
        }

        return $wallet;
    }
}