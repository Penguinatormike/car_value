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

    /**
     * @return CarMake[] Returns an array of most popular car makes
     */
    public function findByCar($car): array
    {
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
            ->andWhere('i.listingPrice != 0') // do not include price 0 as it does not help
            ->orderBy('i.inventoryId', 'ASC')
        ;

        if (isset($car['make'])) {
            $make = $car['make'];
            $qb->andWhere('carMa.makeName = :make')
                ->setParameter('make', $make);
        }

        if (isset($car['state'])) {
            $state = $car['state'];
            $qb->andWhere('dl.dealerState = :state')
                ->setParameter('state', $state);
        }

        if (isset($car['model'])) {
            $model = $car['model'];
            $qb->andWhere('carMo.modelName LIKE :model')
                ->setParameter('model', "$model%");
        }

        if (isset($car['year'])) {
            $year = $car['year'];
            $qb->andWhere('car.yearRelease = :year')
                ->setParameter('year', "$year");
        }

        if (isset($car['trim'])) {
            $trim = $car['trim'];
            $qb->andWhere('car.trimName LIKE :trim')
                ->setParameter('trim', "$trim%");
        }

        // If we specify mileage in our form, it will be more accurate to omit empty mileages
        if (isset($car['mileage'])) {
            $qb->andWhere('i.listingMileage != 0');
        }

        return $qb->getQuery()->getResult();
    }
}
