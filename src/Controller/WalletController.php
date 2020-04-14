<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Controller;

use App\API\DTO\ChangeBalance;
use App\API\DTO\WalletBalance;
use App\API\Mapper\WalletMapper;
use App\Service\Wallet\Exception\WalletNotFound;
use App\Service\Wallet\WalletProviderInterface;
use App\Service\Wallet\WalletServiceInterface;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WalletController extends AbstractController
{
    /**
     * @var WalletProviderInterface
     */
    private $walletProvider;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * @var WalletMapper
     */
    private $walletMapper;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * WalletController constructor.
     *
     * @param WalletProviderInterface $walletProvider
     * @param WalletServiceInterface $walletService
     * @param WalletMapper $walletMapper
     * @param ValidatorInterface $validator
     */
    public function __construct(WalletProviderInterface $walletProvider,
        WalletServiceInterface $walletService,
        WalletMapper $walletMapper,
        ValidatorInterface $validator)
    {
        $this->walletProvider = $walletProvider;
        $this->walletService = $walletService;
        $this->walletMapper = $walletMapper;
        $this->validator = $validator;
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
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Change wallet balance
     *
     * @Route("/api/wallets/change_balance", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Balance changed"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @Model(type=ChangeBalance::class)
     * )
     * @SWG\Tag(name="wallets")
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function changeWalletBalance(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $changeBalance = $this->walletMapper->mapChangeBalance($data);

            $this->validate($changeBalance);

            $wallet = $this->walletProvider->getWallet($changeBalance->walletId);
            $walletChangeBalance = $this->walletMapper->mapChangeBalanceToWalletChangeBalance($wallet, $changeBalance);

            $this->walletService->changeBalance($walletChangeBalance);

            return $this->json('Balance changed');
        } catch (ValidatorException $exception) {
            return $this->json('Failed validation', Response::HTTP_BAD_REQUEST);
        } catch (WalletNotFound $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param $data
     */
    private function validate($data): void
    {
        $errors = $this->validator->validate($data);

        if ($errors->count() > 0) {
            throw new ValidatorException();
        }
    }
}