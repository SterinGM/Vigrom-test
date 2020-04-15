<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 14.04.2020
 */

namespace App\Controller\Wallet;

use App\API\DTO\ChangeBalance;
use App\API\Mapper\WalletMapper;
use App\Service\Wallet\Exception\NotEnoughMoney;
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

class ChangeBalanceController extends AbstractController
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
     * @SWG\Tag(name="Wallets")
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(Request $request)
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
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (WalletNotFound $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (NotEnoughMoney $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_I_AM_A_TEAPOT);
        }
    }

    /**
     * @param $changeBalance
     */
    private function validate(ChangeBalance $changeBalance): void
    {
        $errors = $this->validator->validate($changeBalance);

        if ($errors->count() > 0) {
            throw new ValidatorException($errors->get(0)->getMessage());
        }
    }
}