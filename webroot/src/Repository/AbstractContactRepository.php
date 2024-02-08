<?php

namespace App\Repository;

use App\Entity\AbstractContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractContact>
 *
 * @method AbstractContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractContact[]    findAll()
 * @method AbstractContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractContact::class);
    }
}
