<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Service\Wallet\DTO\ChangeBalance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * @param ChangeBalance $changeBalance
     * @param int $amount
     *
     * @throws Exception
     */
    public function changeBalance(ChangeBalance $changeBalance, int $amount): void
    {
        $wallet = $changeBalance->getWallet();

        try {
            $this->_em->beginTransaction();

            $this->createQueryBuilder('w')
                ->update(Wallet::class, 'w')
                ->set('w.amount', 'w.amount + :amount')
                ->andWhere('w.id = :id')
                ->setParameter('id', $wallet)
                ->setParameter('amount', $amount)
                ->getQuery()
                ->execute();

            $this->_em->refresh($wallet);

            $transaction = new Transaction();
            $transaction->setWallet($wallet);
            $transaction->setCurrency($wallet->getCurrency());
            $transaction->setAmount($amount);
            $transaction->setBalance($wallet->getAmount());
            $transaction->setType($changeBalance->getTransaction());
            $transaction->setReason($changeBalance->getReason());

            $this->_em->persist($transaction);

            $this->_em->flush();
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();

            throw $exception;
        }
    }
}
