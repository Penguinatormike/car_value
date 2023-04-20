<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarMake.
 *
 * @ORM\Table(name="car_make", uniqueConstraints={@ORM\UniqueConstraint(name="make_name", columns={"make_name"})}, indexes={@ORM\Index(name="make_name_2", columns={"make_name"})})
 * @ORM\Entity
 */
class CarMake
{
    /**
     * @var int
     *
     * @ORM\Column(name="make_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $makeId;

    /**
     * @var string
     *
     * @ORM\Column(name="make_name", type="string", length=255, nullable=false)
     */
    private $makeName;

    public function getMakeId(): ?int
    {
        return $this->makeId;
    }

    public function getMakeName(): ?string
    {
        return $this->makeName;
    }

    public function setMakeName(string $makeName): self
    {
        $this->makeName = $makeName;

        return $this;
    }
}
