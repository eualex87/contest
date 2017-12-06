<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalii
 *
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DetaliiRepository")
 * @ORM\Table(name="detalii", indexes={@ORM\Index(name="nume", columns={"nume", "email"})})
 */
class Detalii
{
    const STATUS_ACTIVE_MESSAGE = 1;
    const STATUS_NEW_MESSAGE = -1;

    const PRIZE_HOUR = 1;
    const PRIZE_WEEK = 2;
    const PRIZE_FINAL = 3;

    const GEN_FEMININ = 2;
    const GEN_MASCULIN = 1;

    const PREMII_TOTALE_ZILNICE = 840;
    const PREMII_TOTALE_SAPTAMANALE = 5;
    const PREMIU_FINAL = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="nume", type="string", length=100, nullable=false)
     */
    private $nume;

    /**
     * @var string
     *
     * @ORM\Column(name="prenume", type="string", length=100, nullable=false)
     */
    private $prenume;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dn", type="date", nullable=false)
     */
    private $dn;

    /**
     * @var integer
     *
     * @ORM\Column(name="gen", type="integer", nullable=false)
     */
    private $gen;

    /**
     * @var string
     *
     * @ORM\Column(name="mesaj", type="string", length=300, nullable=true)
     */
    private $mesaj;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_img", type="integer", nullable=true)
     */
    private $idImg;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adaugat", type="datetime", nullable=false)
     */
    private $adaugat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modificat", type="datetime", nullable=false)
     */
    private $modificat;

    /**
     * @var integer
     *
     * @ORM\Column(name="anonim", type="integer", nullable=false)
     */
    private $anonim;

    /**
     * @var integer
     *
     * @ORM\Column(name="aproba_mesaj", type="integer", nullable=false)
     */
    private $aprobaMesaj;

    /**
     * @var integer
     *
     * @ORM\Column(name="aproba_imagine", type="integer", nullable=false)
     */
    private $aprobaImagine;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="premiu", type="integer")
     */
    private $premiu;

    /**
     * Set nume
     *
     * @param string $nume
     * @return Detalii
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
     * Set prenume
     *
     * @param string $prenume
     * @return Detalii
     */
    public function setPrenume($prenume)
    {
        $this->prenume = $prenume;

        return $this;
    }

    /**
     * Get prenume
     *
     * @return string 
     */
    public function getPrenume()
    {
        return $this->prenume;
    }

    /**
     * Set dn
     *
     * @param \DateTime $dn
     * @return Detalii
     */
    public function setDn($dn)
    {
        $this->dn = $dn;

        return $this;
    }

    /**
     * Get dn
     *
     * @return \DateTime 
     */
    public function getDn()
    {
        return $this->dn;
    }

    /**
     * Set gen
     *
     * @param boolean $gen
     * @return Detalii
     */
    public function setGen($gen)
    {
        $this->gen = $gen;

        return $this;
    }

    /**
     * Get gen
     *
     * @return boolean 
     */
    public function getGen()
    {
        return $this->gen;
    }

    /**
     * Set mesaj
     *
     * @param string $mesaj
     * @return Detalii
     */
    public function setMesaj($mesaj)
    {
        $this->mesaj = $mesaj;

        return $this;
    }

    /**
     * Get mesaj
     *
     * @return string 
     */
    public function getMesaj()
    {
        return $this->mesaj;
    }

    /**
     * Set idImg
     *
     * @param integer $idImg
     * @return Detalii
     */
    public function setIdImg($idImg)
    {
        $this->idImg = $idImg;

        return $this;
    }

    /**
     * Get idImg
     *
     * @return integer 
     */
    public function getIdImg()
    {
        return $this->idImg;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Detalii
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adaugat
     *
     * @param \DateTime $adaugat
     * @return Detalii
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
     * Set modificat
     *
     * @param \DateTime $modificat
     * @return Detalii
     */
    public function setModificat($modificat)
    {
        $this->modificat = $modificat;

        return $this;
    }

    /**
     * Get modificat
     *
     * @return \DateTime 
     */
    public function getModificat()
    {
        return $this->modificat;
    }

    /**
     * Set anonim
     *
     * @param boolean $anonim
     * @return Detalii
     */
    public function setAnonim($anonim)
    {
        $this->anonim = $anonim;

        return $this;
    }

    /**
     * Get anonim
     *
     * @return boolean 
     */
    public function getAnonim()
    {
        return $this->anonim;
    }

    /**
     * Set aprobaMesaj
     *
     * @param boolean $aprobaMesaj
     * @return Detalii
     */
    public function setAprobaMesaj($aprobaMesaj)
    {
        $this->aprobaMesaj = $aprobaMesaj;

        return $this;
    }

    /**
     * Get aprobaMesaj
     *
     * @return boolean 
     */
    public function getAprobaMesaj()
    {
        return $this->aprobaMesaj;
    }

    /**
     * Set aprobaImagine
     *
     * @param boolean $aprobaImagine
     * @return Detalii
     */
    public function setAprobaImagine($aprobaImagine)
    {
        $this->aprobaImagine = $aprobaImagine;

        return $this;
    }

    /**
     * Get aprobaImagine
     *
     * @return boolean 
     */
    public function getAprobaImagine()
    {
        return $this->aprobaImagine;
    }

    /**
     * Set premiu
     *
     * @param integer $premiu
     * @return Detalii
     */
    public function setPremiu($premiu)
    {
        $this->premiu = $premiu;

        return $this;
    }

    /**
     * Get premiu
     *
     * @return integer
     */
    public function getPremiu()
    {
        return $this->premiu;
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
