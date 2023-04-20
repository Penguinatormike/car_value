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
     * @return Inventory[] Returns an array of inventories by car filters
     */
    public function findByCar($car): array
    {
        $cacheKey = '';

        $qb = $this->createQueryBuilder('i')
            ->select([
                'i.listingMileage AS listingMileage',
                'i.listingPrice AS listingPrice',
                'carMo.modelName AS modelName',
                'carMa.makeName AS makeName',
                'car.trimName AS trimName',
                'car.yearRelease AS yearRelease',
                'dl.dealerCountry AS dealerCountry',
                'dl.dealerState AS dealerState',
                'dl.dealerCity AS dealerCity',
            ])
            ->join('i.car', 'car')
            ->join('car.model', 'carMo')
            ->join('carMo.make', 'carMa')
            ->join('i.dealer', 'dl')
            ->andWhere('i.listingPrice != 0') // do not include price 0 as it is not accurate
            ->orderBy('i.firstSeenDate', 'DESC') // fetch latest entries first
//            ->setMaxResults(10) // testing
        ;

        if (!empty($car['make'])) {
            $make = $car['make'];
            $cacheKey .= $make;
            $qb->andWhere('carMa.makeName = :make')
                ->setParameter('make', $make);
        }

        if (!empty($car['state'])) {
            $state = $car['state'];
            $cacheKey .= $state;
            $qb->andWhere('dl.dealerState = :state')
                ->setParameter('state', $state);
        }

        if (!empty($car['model'])) {
            $model = $car['model'];
            $cacheKey .= $model;
            $qb->andWhere('carMo.modelName LIKE :model')
                ->setParameter('model', "$model%");
        }

        if (!empty($car['year'])) {
            $year = $car['year'];
            $cacheKey .= $year;
            $qb->andWhere('car.yearRelease = :year')
                ->setParameter('year', "$year");
        }

        if (!empty($car['trim'])) {
            $trim = $car['trim'];
            $cacheKey .= $trim;
            $qb->andWhere('car.trimName LIKE :trim')
                ->setParameter('trim', "$trim%");
        }

        // If we specify mileage in our form, it will be more accurate to omit empty mileages
        if (!empty($car['mileage'])) {
            $cacheKey .= 'mileage';
            $qb->andWhere('i.listingMileage != 0');
        }

        return $qb->getQuery()
            ->useQueryCache(true)
            ->enableResultCache(3600, $cacheKey)
            ->getResult();
    }
}
