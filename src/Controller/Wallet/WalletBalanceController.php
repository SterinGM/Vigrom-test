<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Controller\Wallet;

use App\API\DTO\WalletBalance;
use App\API\Mapper\WalletMapper;
use App\Service\Wallet\Exception\WalletNotFound;
use App\Service\Wallet\WalletProviderInterface;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class WalletBalanceController extends AbstractController
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
     * WalletBalanceController constructor.
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
     * @SWG\Tag(name="Wallets")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        try {
            $wallet = $this->walletProvider->getWallet($id);
            $balance = $this->walletMapper->mapWalletBalance($wallet);

            return $this->json($balance);
        } catch (WalletNotFound $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_I_AM_A_TEAPOT);
        }
    }
}