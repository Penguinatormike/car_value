<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventory
 *
 * @ORM\Table(name="inventory", indexes={@ORM\Index(name="listing_price", columns={"listing_price"}), @ORM\Index(name="listing_mileage", columns={"listing_mileage"}), @ORM\Index(name="car_id", columns={"car_id"}), @ORM\Index(name="dealer_id", columns={"dealer_id"})})
 * @ORM\Entity
 */
class Inventory
{
    const LISTING_PRICE = 'listingPrice';
    const LISTING_MILEAGE = 'listingMileage';

    /**
     * @var int
     *
     * @ORM\Column(name="inventory_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inventoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="listing_price", type="decimal", precision=9, scale=2, nullable=false)
     */
    private $listingPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="listing_mileage", type="integer", nullable=false)
     */
    private $listingMileage;

    /**
     * @var bool
     *
     * @ORM\Column(name="used", type="boolean", nullable=false)
     */
    private $used;

    /**
     * @var bool
     *
     * @ORM\Column(name="certified", type="boolean", nullable=false)
     */
    private $certified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="first_seen_date", type="date", nullable=false)
     */
    private $firstSeenDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_seen_date", type="date", nullable=false)
     */
    private $lastSeenDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="listing_status", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $listingStatus = 'NULL';

    /**
     * @var Dealer
     *
     * @ORM\ManyToOne(targetEntity="Dealer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dealer_id", referencedColumnName="dealer_id")
     * })
     */
    private $dealer;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_id", referencedColumnName="car_id")
     * })
     */
    private $car;

    public function getInventoryId(): ?int
    {
        return $this->inventoryId;
    }

    public function getListingPrice(): ?string
    {
        return $this->listingPrice;
    }

    public function setListingPrice(string $listingPrice): self
    {
        $this->listingPrice = $listingPrice;

        return $this;
    }

    public function getListingMileage(): ?int
    {
        return $this->listingMileage;
    }

    public function setListingMileage(int $listingMileage): self
    {
        $this->listingMileage = $listingMileage;

        return $this;
    }

    public function isUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(bool $used): self
    {
        $this->used = $used;

        return $this;
    }

    public function isCertified(): ?bool
    {
        return $this->certified;
    }

    public function setCertified(bool $certified): self
    {
        $this->certified = $certified;

        return $this;
    }

    public function getFirstSeenDate(): ?\DateTimeInterface
    {
        return $this->firstSeenDate;
    }

    public function setFirstSeenDate(\DateTimeInterface $firstSeenDate): self
    {
        $this->firstSeenDate = $firstSeenDate;

        return $this;
    }

    public function getLastSeenDate(): ?\DateTimeInterface
    {
        return $this->lastSeenDate;
    }

    public function setLastSeenDate(\DateTimeInterface $lastSeenDate): self
    {
        $this->lastSeenDate = $lastSeenDate;

        return $this;
    }

    public function getListingStatus(): ?string
    {
        return $this->listingStatus;
    }

    public function setListingStatus(?string $listingStatus): self
    {
        $this->listingStatus = $listingStatus;

        return $this;
    }

    public function getDealer(): ?Dealer
    {
        return $this->dealer;
    }

    public function setDealer(?Dealer $dealer): self
    {
        $this->dealer = $dealer;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }


}
