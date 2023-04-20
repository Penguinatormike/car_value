<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dealer.
 *
 * @ORM\Table(name="dealer", uniqueConstraints={@ORM\UniqueConstraint(name="UC_Dealer", columns={"dealer_name", "dealer_city", "dealer_street", "dealer_state", "dealer_zip"})}, indexes={@ORM\Index(name="dealer_street", columns={"dealer_street"}), @ORM\Index(name="dealer_state", columns={"dealer_state"}), @ORM\Index(name="dealer_name", columns={"dealer_name"}), @ORM\Index(name="dealer_zip", columns={"dealer_zip"}), @ORM\Index(name="dealer_city", columns={"dealer_city"})})
 * @ORM\Entity
 */
class Dealer
{
    // Source for canadian/us provinces/states https://www.ups.com/worldshiphelp/WSA/ENU/AppHelp/mergedProjects/CORE/Codes/State_Province_Codes.htm
    public const CANADIAN_PROV_MAP = [
        'ab' => 'AB - Alberta, CA',
        'bc' => 'BC - British Columbia, CA',
        'mb' => 'MB - Manitoba, CA',
        'nb' => 'NB - New Brunswick, CA',
        'nl' => 'NL - Newfoundland and Labrador, CA',
        'nt' => 'NT - Northwest Territories, CA',
        'ns' => 'NS - Nova Scotia, CA',
        'nu' => 'NU - Nunavut, CA',
        'on' => 'ON - Ontario, CA',
        'pe' => 'PE - Prince Edward Island, CA',
        'qc' => 'QC - Quebec, CA',
        'sk' => 'SK - Saskatchewan, CA',
        'yt' => 'YT - Yukon, CA',
    ];

    public const AMERICAN_STATE_MAP = [
        'al' => 'AL - Alabama, US',
        'ak' => 'AK - Alaska, US',
        'az' => 'AZ - Arizona, US',
        'ar' => 'AR - Arkansas, US',
        'aa' => 'AA - Armed Forces America',
        'ae' => 'AE - Armed Forces Europe',
        'ap' => 'AP - Armed Forces Pacific',
        'ca' => 'CA - California, US',
        'co' => 'CO - Colorado, US',
        'ct' => 'CT - Connecticut, US',
        'de' => 'DE - Delaware, US',
        'dc' => 'DC - District of Columbia, US',
        'fl' => 'FL - Florida, US',
        'ga' => 'GA - Georgia, US',
        'hi' => 'HI - Hawaii, US',
        'id' => 'ID - Idaho, US',
        'il' => 'IL - Illinois, US',
        'in' => 'IN - Indiana, US',
        'ia' => 'IA - Iowa, US',
        'ks' => 'KS - Kansas, US',
        'ky' => 'KY - Kentucky, US',
        'la' => 'LA - Louisiana, US',
        'me' => 'ME - Maine, US',
        'md' => 'MD - Maryland, US',
        'ma' => 'MA - Massachusetts, US',
        'mi' => 'MI - Michigan, US',
        'mn' => 'MN - Minnesota, US',
        'ms' => 'MS - Mississippi, US',
        'mo' => 'MO - Missouri, US',
        'mt' => 'MT - Montana, US',
        'ne' => 'NE - Nebraska, US',
        'nv' => 'NV - Nevada, US',
        'nh' => 'NH - New Hampshire, US',
        'nj' => 'NJ - New Jersey, US',
        'nm' => 'NM - New Mexico, US',
        'ny' => 'NY - New York, US',
        'nc' => 'NC - North Carolina, US',
        'nd' => 'ND - North Dakota, US',
        'oh' => 'OH - Ohio, US',
        'ok' => 'OK - Oklahoma, US',
        'or' => 'OR - Oregon, US',
        'pa' => 'PA - Pennsylvania, US',
        'ri' => 'RI - Rhode Island, US',
        'sc' => 'SC - South Carolina, US',
        'sd' => 'SD - South Dakota, US',
        'tn' => 'TN - Tennessee, US',
        'tx' => 'TX - Texas, US',
        'ut' => 'UT - Utah, US',
        'vt' => 'VT - Vermont, US',
        'va' => 'VA - Virginia, US',
        'wa' => 'WA - Washington, US',
        'wv' => 'WV - West Virginia, US',
        'wi' => 'WI - Wisconsin, US',
        'wy' => 'WY - Wyoming, US',
    ];

    public const COUNTRY_CAN = 'can';
    public const COUNTRY_USA = 'usa';

    public const DEALER_COUNTRY = 'dealerCountry';
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
     * @ORM\Column(name="dealer_country", type="string", length=255, nullable=false)
     */
    private $dealerCountry;

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

    public function getDealerCountry(): ?string
    {
        return $this->dealerCountry;
    }

    public function setDealerCountry(string $dealerCountry): self
    {
        $this->dealerCountry = $dealerCountry;

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
