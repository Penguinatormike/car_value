<?php

namespace App\Command;

use App\Entity\Car;
use App\Entity\CarMake;
use App\Entity\CarModel;
use App\Entity\Dealer;
use App\Entity\Inventory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

ini_set('memory_limit', '8G');
#[AsCommand(
    name: 'app:upload-car-data',
    description: 'Upload car data into the database',
    hidden: false,
)]
class UploadCarDataCommand extends Command {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    private const INVENTORY_HEADER_MAP = [
        "vin"                       => 0,
        "year"                      => 1,
        "make"                      => 2,
        "model"                     => 3,
        "trim"                      => 4,
        "dealer_name"               => 5,
        "dealer_street"             => 6,
        "dealer_city"               => 7,
        "dealer_state"              => 8,
        "dealer_zip"                => 9,
        "listing_price"             => 10,
        "listing_mileage"           => 11,
        "used"                      => 12,
        "certified"                 => 13,
        "style"                     => 14,
        "driven_wheels"             => 15,
        "engine"                    => 16,
        "fuel_type"                 => 17,
        "exterior_color"            => 18,
        "interior_color"            => 19,
        "seller_website"            => 20,
        "first_seen_date"           => 21,
        "last_seen_date"            => 22,
        "dealer_vdp_last_seen_date" => 23,
        "listing_status"            => 24,
    ];

    public function __construct(private EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->addArgument('fileName', InputArgument::REQUIRED, 'The file name to upload')
            ->addArgument('batchSize', InputArgument::OPTIONAL, 'The batch size to insert data', 20)
        ;
    }

    /**
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Doctrine\DBAL\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $startTime = microtime(true);
        $inventoryListingFile = $input->getArgument('fileName');
        $batchSize = $input->getArgument('batchSize');

        if (!is_file($inventoryListingFile)) {
            throw new \Exception($inventoryListingFile.' is not a valid file');
        }

        // store some objects in maps for faster access
        $makeMap = [];
        $modelMap = [];
        $dealerMap = [];
        $carMap = [];

        $headers = [];

        $batchCounter = 0;

        $fh = fopen($inventoryListingFile,'r');
        while ($line = fgets($fh)) {
            $lineArray = explode("|", strtolower($line));
            if (empty($headers)) {
                $headers = $lineArray;
                continue;
            }
            $vin = $lineArray[self::INVENTORY_HEADER_MAP["vin"]];
            $year = $lineArray[self::INVENTORY_HEADER_MAP["year"]];
            $make = $lineArray[self::INVENTORY_HEADER_MAP["make"]];
            $model = $lineArray[self::INVENTORY_HEADER_MAP["model"]];
            $trim = $lineArray[self::INVENTORY_HEADER_MAP["trim"]];
            $dealerName = $lineArray[self::INVENTORY_HEADER_MAP["dealer_name"]];
            $dealerStreet = $lineArray[self::INVENTORY_HEADER_MAP["dealer_street"]];
            $dealerCity = $lineArray[self::INVENTORY_HEADER_MAP["dealer_city"]];
            $dealerState = $lineArray[self::INVENTORY_HEADER_MAP["dealer_state"]];
            $dealerZip = $lineArray[self::INVENTORY_HEADER_MAP["dealer_zip"]];
            $listingPrice = $lineArray[self::INVENTORY_HEADER_MAP["listing_price"]];
            $listingMileage = $lineArray[self::INVENTORY_HEADER_MAP["listing_mileage"]];
            $used = $lineArray[self::INVENTORY_HEADER_MAP["used"]];
            $certified = $lineArray[self::INVENTORY_HEADER_MAP["certified"]];
            $style = $lineArray[self::INVENTORY_HEADER_MAP["style"]];
            $drivenWheels = $lineArray[self::INVENTORY_HEADER_MAP["driven_wheels"]];
            $engine = $lineArray[self::INVENTORY_HEADER_MAP["engine"]];
            $fuelType = $lineArray[self::INVENTORY_HEADER_MAP["fuel_type"]];
            $exteriorColor = $lineArray[self::INVENTORY_HEADER_MAP["exterior_color"]];
            $interiorColor = $lineArray[self::INVENTORY_HEADER_MAP["interior_color"]];
            $sellerWebsite = $lineArray[self::INVENTORY_HEADER_MAP["seller_website"]];
            $firstSeenDate = $lineArray[self::INVENTORY_HEADER_MAP["first_seen_date"]];
            $lastSeenDate = $lineArray[self::INVENTORY_HEADER_MAP["last_seen_date"]];
            $dealerVdpLastSeenDate = $lineArray[self::INVENTORY_HEADER_MAP["dealer_vdp_last_seen_date"]];
            $listingStatus = $lineArray[self::INVENTORY_HEADER_MAP["listing_status"]];
            $dealerKey = $dealerName.'-'.$dealerZip;

            // populate car_make table
            if (!isset($makeMap[$make])) {
                $carMake = $this->em->getRepository(CarMake::class)->findOneBy(['makeName' => $make]);
                if (!$carMake instanceof CarMake) {
                    $batchCounter++;
                    $carMake = new CarMake();
                    $carMake->setMakeName($make);
                    $this->em->persist($carMake);
                    $this->shouldBatchFlush($batchCounter, $batchSize);
                }
                $makeMap[$make] = $carMake;
            }

            // populate car_model table
            if (!isset($modelMap[$model])) {
                $carModel = $this->em->getRepository(CarModel::class)->findOneBy(['modelName' => $model]);
                if (!$carModel instanceof CarModel) {
                    $batchCounter++;
                    $carModel = new CarModel();
                    $carModel
                        ->setMake($makeMap[$make])
                        ->setModelName($model)
                    ;
                    $carModel = $this->em->merge($carModel);
                    $this->shouldBatchFlush($batchCounter, $batchSize);
                }

                $modelMap[$model] = $carModel;
            }

            // populate car table
            if (!isset($carMap[$vin])) {
                $car = $this->em->getRepository(Car::class)->findOneBy(['vin' => $vin]);
                if (!$car instanceof Car) {
                    $batchCounter++;
                    $car = new Car();
                    $car
                        ->setModel($modelMap[$model])
                        ->setVin($vin)
                        ->setTrimName($trim)
                        ->setYearRelease((int) $year)
                        ->setCarEngine($engine)
                        ->setFuelType($fuelType)
                        ->setDrivenWheels($drivenWheels)
                        ->setStyle($style)
                        ->setExteriorColor($exteriorColor)
                        ->setInteriorColor($interiorColor);
                    $car = $this->em->merge($car);
                    $this->shouldBatchFlush($batchCounter, $batchSize);
                }
                $carMap[$vin] = $car;
            }

            // populate dealer table - using name and zip as the key
            if (!isset($dealerMap[$dealerKey])) {
                $dealer = $this->em->getRepository(Dealer::class)->findOneBy(['dealerName' => $dealerName, 'dealerZip' => $dealerZip]);
                if (!$dealer instanceof Dealer) {
                    $batchCounter++;
                    $dealerCountry = Dealer::COUNTRY_USA;
                    if (Dealer::CANADIAN_PROV_MAP[$dealerState]) {
                        $dealerCountry = Dealer::COUNTRY_CAN;
                    }
                    $dealer = new Dealer();
                    $dealer
                        ->setDealerName($dealerName)
                        ->setDealerCity($dealerCity)
                        ->setDealerCountry($dealerCountry)
                        ->setDealerState($dealerState)
                        ->setDealerStreet($dealerStreet)
                        ->setDealerVdpLastSeenDate(new DateTime($dealerVdpLastSeenDate))
                        ->setDealerZip($dealerZip)
                        ->setSellerWebsite($sellerWebsite)
                    ;
                    $this->em->persist($dealer);
                    $this->shouldBatchFlush($batchCounter, $batchSize);
                }
                $dealerMap[$dealerKey] = $dealer;
            }

            // populate inventory table - not using map as most data will be new
            $batchCounter++;
            $inventory = new Inventory();
            $inventory
                ->setCar($carMap[$vin])
                ->setDealer($dealerMap[$dealerKey])
                ->setListingPrice((float) $listingPrice)
                ->setListingMileage((int) $listingMileage)
                ->setUsed((bool) $used)
                ->setCertified((bool) $certified)
                ->setFirstSeenDate(new DateTime($firstSeenDate))
                ->setLastSeenDate(new DateTime($lastSeenDate))
                ->setListingStatus($listingStatus)
            ;
            $this->em->merge($inventory);
            $this->shouldBatchFlush($batchCounter, $batchSize);
        }

        $this->flushAndCleanEntityManager();
        fclose($fh);

        $timeElapsed = microtime(true) - $startTime;
        echo 'Time Elapsed: '. $timeElapsed;
        return Command::SUCCESS;
    }

    /**
     * commits entity objects and clears them
     *
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    private function flushAndCleanEntityManager() {
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * Batch insert statements, dependent on batchSize
     *
     * check if our batchCounter is at our batchSize, if so, we will need to flush and clear entity manager
     *
     * @param $batchCounter
     * @param $batchSize
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    private function shouldBatchFlush($batchCounter, $batchSize) {
        if (($batchCounter % $batchSize) === 0) {
            $this->flushAndCleanEntityManager();
        }
    }

}

?>