<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dealer
 *
 * @ORM\Table(name="dealer", uniqueConstraints={@ORM\UniqueConstraint(name="UC_Dealer", columns={"dealer_name", "dealer_city", "dealer_street", "dealer_state", "dealer_zip"})}, indexes={@ORM\Index(name="dealer_street", columns={"dealer_street"}), @ORM\Index(name="dealer_state", columns={"dealer_state"}), @ORM\Index(name="dealer_name", columns={"dealer_name"}), @ORM\Index(name="dealer_zip", columns={"dealer_zip"}), @ORM\Index(name="dealer_city", columns={"dealer_city"})})
 * @ORM\Entity
 */
class Dealer
{
    /**
     * @var int
     *
     * @ORM\Column(name="dealer_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dealerId;

    /**
     * @var string
     *
     * @ORM\Column(name="dealer_name", type="string", length=255, nullable=false)
     */
    private $dealerName;

    /**
     * @var string
     *
     * @ORM\Column(name="dealer_street", type="string", length=255, nullable=false)
     */
    private $dealerStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="dealer_city", type="string", length=255, nullable=false)
     */
    private $dealerCity;

    /**
     * @var string
     *
     * @ORM\Column(name="dealer_state", type="string", length=255, nullable=false)
     */
    private $dealerState;

    /**
     * @var string
     *
     * @ORM\Column(name="dealer_zip", type="string", length=255, nullable=false)
     */
    private $dealerZip;

    /**
     * @var string
     *
     * @ORM\Column(name="seller_website", type="string", length=255, nullable=false)
     */
    private $sellerWebsite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dealer_vdp_last_seen_date", type="date", nullable=false)
     */
    private $dealerVdpLastSeenDate;

    public function getDealerId(): ?int
    {
        return $this->dealerId;
    }

    public function getDealerName(): ?string
    {
        return $this->dealerName;
    }

    public function setDealerName(string $dealerName): self
    {
        $this->dealerName = $dealerName;

        return $this;
    }

    public function getDealerStreet(): ?string
    {
        return $this->dealerStreet;
    }

    public function setDealerStreet(string $dealerStreet): self
    {
        $this->dealerStreet = $dealerStreet;

        return $this;
    }

    public function getDealerCity(): ?string
    {
        return $this->dealerCity;
    }

    public function setDealerCity(string $dealerCity): self
    {
        $this->dealerCity = $dealerCity;

        return $this;
    }

    public function getDealerState(): ?string
    {
        return $this->dealerState;
    }

    public function setDealerState(string $dealerState): self
    {
        $this->dealerState = $dealerState;

        return $this;
    }

    public function getDealerZip(): ?string
    {
        return $this->dealerZip;
    }

    public function setDealerZip(string $dealerZip): self
    {
        $this->dealerZip = $dealerZip;

        return $this;
    }

    public function getSellerWebsite(): ?string
    {
        return $this->sellerWebsite;
    }

    public function setSellerWebsite(string $sellerWebsite): self
    {
        $this->sellerWebsite = $sellerWebsite;

        return $this;
    }

    public function getDealerVdpLastSeenDate(): ?\DateTimeInterface
    {
        return $this->dealerVdpLastSeenDate;
    }

    public function setDealerVdpLastSeenDate(\DateTimeInterface $dealerVdpLastSeenDate): self
    {
        $this->dealerVdpLastSeenDate = $dealerVdpLastSeenDate;

        return $this;
    }


}
