<?php

namespace MiCocinaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Medida
 *
 * @ORM\Table(name="medida")
 * @ORM\Entity(repositoryClass="MiCocinaBundle\Repository\MedidaRepository")
 */
class Medida
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(name="cantidad", type="smallint", length=6)
     * @Assert\NotBlank()
     */
    private $cantidad;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Medida
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    function __toString()
    {
        return $this->nombre;
    }



    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Medida
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
}
