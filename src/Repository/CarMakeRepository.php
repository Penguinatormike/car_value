<?php

namespace App\Repository;

use App\Entity\CarMake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarMake>
 *
 * @method CarMake|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarMake|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarMake[]    findAll()
 * @method CarMake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarMakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarMake::class);
    }

    public function save(CarMake $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CarMake $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
