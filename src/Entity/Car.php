<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car", uniqueConstraints={@ORM\UniqueConstraint(name="vin", columns={"vin"})}, indexes={@ORM\Index(name="fk_car_model", columns={"model_id"}), @ORM\Index(name="trim_name", columns={"trim_name"}), @ORM\Index(name="year_release", columns={"year_release"})})
 * @ORM\Entity
 */
class Car
{
    /**
     * @var int
     *
     * @ORM\Column(name="car_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $carId;

    /**
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=255, nullable=false)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="trim_name", type="string", length=255, nullable=false)
     */
    private $trimName;

    /**
     * @var int
     *
     * @ORM\Column(name="year_release", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $yearRelease;

    /**
     * @var string
     *
     * @ORM\Column(name="car_engine", type="string", length=255, nullable=false)
     */
    private $carEngine;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_type", type="string", length=255, nullable=false)
     */
    private $fuelType;

    /**
     * @var string
     *
     * @ORM\Column(name="driven_wheels", type="string", length=255, nullable=false)
     */
    private $drivenWheels;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255, nullable=false)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="exterior_color", type="string", length=255, nullable=false)
     */
    private $exteriorColor;

    /**
     * @var string
     *
     * @ORM\Column(name="interior_color", type="string", length=255, nullable=false)
     */
    private $interiorColor;

    /**
     * @var \CarModel
     *
     * @ORM\ManyToOne(targetEntity="CarModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="model_id")
     * })
     */
    private $model;

    public function getCarId(): ?int
    {
        return $this->carId;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getTrimName(): ?string
    {
        return $this->trimName;
    }

    public function setTrimName(string $trimName): self
    {
        $this->trimName = $trimName;

        return $this;
    }

    public function getYearRelease(): ?int
    {
        return $this->yearRelease;
    }

    public function setYearRelease(int $yearRelease): self
    {
        $this->yearRelease = $yearRelease;

        return $this;
    }

    public function getCarEngine(): ?string
    {
        return $this->carEngine;
    }

    public function setCarEngine(string $carEngine): self
    {
        $this->carEngine = $carEngine;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getDrivenWheels(): ?string
    {
        return $this->drivenWheels;
    }

    public function setDrivenWheels(string $drivenWheels): self
    {
        $this->drivenWheels = $drivenWheels;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getExteriorColor(): ?string
    {
        return $this->exteriorColor;
    }

    public function setExteriorColor(string $exteriorColor): self
    {
        $this->exteriorColor = $exteriorColor;

        return $this;
    }

    public function getInteriorColor(): ?string
    {
        return $this->interiorColor;
    }

    public function setInteriorColor(string $interiorColor): self
    {
        $this->interiorColor = $interiorColor;

        return $this;
    }

    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    public function setModel(?CarModel $model): self
    {
        $this->model = $model;

        return $this;
    }


}
