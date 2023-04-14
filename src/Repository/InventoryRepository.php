<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\CarMake;
use App\Entity\CarModel;
use App\Entity\Dealer;
use App\Entity\Inventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inventory>
 *
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    public function save(Inventory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Inventory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Inventory[] Returns an array of  objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('in')
            ->join(Car::class, 'car')
            ->join(CarModel::class, 'carMo')
            ->join(CarMake::class, 'carMa')
            ->join(Dealer::class, 'dl')
            ->andWhere('carMa.makeName LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
