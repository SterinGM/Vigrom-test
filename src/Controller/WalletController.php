<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Controller;

use App\API\DTO\WalletBalance;
use App\API\Mapper\WalletMapper;
use App\Service\Wallet\Exception\WalletNotFound;
use App\Service\Wallet\WalletProviderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class WalletController extends AbstractController
{
    /**
     * @var WalletProviderInterface
     */
    private $walletProvider;

    /**
     * @var WalletMapper
     */
    private $walletMapper;

    /**
     * WalletController constructor.
     *
     * @param WalletProviderInterface $walletProvider
     * @param WalletMapper $walletMapper
     */
    public function __construct(WalletProviderInterface $walletProvider, WalletMapper $walletMapper)
    {
        $this->walletProvider = $walletProvider;
        $this->walletMapper = $walletMapper;
    }

    /**
     * Get wallet balance
     *
     * @Route("/api/wallets/{id}/amount", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns wallet balance",
     *     @Model(type=WalletBalance::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer"
     * )
     * @SWG\Tag(name="wallets")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getWalletBalance(int $id)
    {
        try {
            $wallet = $this->walletProvider->getWallet($id);
            $balance = $this->walletMapper->mapWalletBalance($wallet);

            return $this->json($balance);
        } catch (WalletNotFound $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}