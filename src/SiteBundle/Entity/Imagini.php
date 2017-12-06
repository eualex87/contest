<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagini
 *
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\ImaginiRepository")
 * @ORM\Table(name="imagini")
 */
class Imagini
{
    const STATUS_ACTIVE_IMAGE = 1;
    const STATUS_NEW_IMAGE = -1;

    /**
     * @var string
     *
     * @ORM\Column(name="nume", type="string", length=100, nullable=false)
     */
    private $nume;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=100, nullable=false)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=200, nullable=false)
     */
    private $hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adaugat", type="datetime", nullable=false)
     */
    private $adaugat;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nume
     *
     * @param string $nume
     * @return Imagini
     */
    public function setNume($nume)
    {
        $this->nume = $nume;

        return $this;
    }

    /**
     * Get nume
     *
     * @return string 
     */
    public function getNume()
    {
        return $this->nume;
    }

    /**
     * Set folder
     *
     * @param string $folder
     * @return Imagini
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string 
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return Imagini
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set adaugat
     *
     * @param \DateTime $adaugat
     * @return Imagini
     */
    public function setAdaugat($adaugat)
    {
        $this->adaugat = $adaugat;

        return $this;
    }

    /**
     * Get adaugat
     *
     * @return \DateTime 
     */
    public function getAdaugat()
    {
        return $this->adaugat;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
