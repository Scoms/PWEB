<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
* @ORM\Table(name="examen")
*/

class Examen {

/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;

/**
* @ORM\Column(type="string", length=100)
*/
protected $libelle;

/**
* @ORM\Column(type="string", length=100)
*/
protected $description;

/**
* @ORM\ManyToOne(targetEntity="Promo", inversedBy="examen")
* @ORM\JoinColumn(name="promo", referencedColumnName="id") 
*/
protected $promo;

/**
* @ORM\Column(type="datetime")
*/
protected $date;

/**
* @ORM\Column(type="integer")
*/
protected $coefficient;

/**
* @ORM\ManyToOne(targetEntity="Statut", inversedBy="examen")
* @ORM\JoinColumn(name="statut", referencedColumnName="id") 
*/
protected $statut;

/**
* @ORM\OneToMany(targetEntity="Depot", mappedBy="examen")
*/
protected $depot;

public function __construct()
    {
        $this->depot = new ArrayCollection();
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

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Examen
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Examen
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Examen
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set coefficient
     *
     * @param integer $coefficient
     * @return Examen
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;
    
        return $this;
    }

    /**
     * Get coefficient
     *
     * @return integer 
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set promo
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Promo $promo
     * @return Examen
     */
    public function setPromo(\Ensiie\Bundle\DataBundle\Entity\Promo $promo = null)
    {
        $this->promo = $promo;
    
        return $this;
    }

    /**
     * Get promo
     *
     * @return \Ensiie\Bundle\DataBundle\Entity\Promo 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set statut
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Statut $statut
     * @return Examen
     */
    public function setStatut(\Ensiie\Bundle\DataBundle\Entity\Statut $statut = null)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return \Ensiie\Bundle\DataBundle\Entity\Statut 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Add depot
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Depot $depot
     * @return Examen
     */
    public function addDepot(\Ensiie\Bundle\DataBundle\Entity\Depot $depot)
    {
        $this->depot[] = $depot;
    
        return $this;
    }

    /**
     * Remove depot
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Depot $depot
     */
    public function removeDepot(\Ensiie\Bundle\DataBundle\Entity\Depot $depot)
    {
        $this->depot->removeElement($depot);
    }

    /**
     * Get depot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepot()
    {
        return $this->depot;
    }
    
}