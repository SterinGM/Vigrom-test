<?php

namespace App\Repository;

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
     */
    public function changeBalance(ChangeBalance $changeBalance, int $amount): void
    {
        try {
            $this->_em->beginTransaction();

            $q = $this->createQueryBuilder('w')
                ->update(Wallet::class, 'w')
                ->set('w.amount', 'w.amount + :amount')
                ->andWhere('w.id = :id')
                ->setParameter('id', $changeBalance->getWallet()->getId())
                ->setParameter('amount', $amount)
                ->getQuery();

            $q->execute();

            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->commit();
        }
    }
}
