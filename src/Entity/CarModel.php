<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarModel
 *
 * @ORM\Table(name="car_model", uniqueConstraints={@ORM\UniqueConstraint(name="model_name", columns={"model_name"})}, indexes={@ORM\Index(name="make_id", columns={"make_id"}), @ORM\Index(name="model_name_2", columns={"model_name"})})
 * @ORM\Entity
 */
class CarModel
{
    /**
     * @var int
     *
     * @ORM\Column(name="model_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $modelId;

    /**
     * @var string
     *
     * @ORM\Column(name="model_name", type="string", length=255, nullable=false)
     */
    private $modelName;

    /**
     * @var CarMake
     *
     * @ORM\ManyToOne(targetEntity="CarMake")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="make_id", referencedColumnName="make_id")
     * })
     */
    private $make;

    public function getModelId(): ?int
    {
        return $this->modelId;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getMake(): ?CarMake
    {
        return $this->make;
    }

    public function setMake(?CarMake $make): self
    {
        $this->make = $make;

        return $this;
    }


}
