<?php

namespace App\Repository;

use App\Entity\EstimationRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstimationRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstimationRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstimationRequest[]    findAll()
 * @method EstimationRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimationRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstimationRequest::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EstimationRequest $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EstimationRequest $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
