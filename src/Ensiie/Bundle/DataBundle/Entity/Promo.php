<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="promo")
*/

class Promo {
    
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
* @ORM\OneToMany(targetEntity="Etudiant", mappedBy="promo")
*/
protected $etudiant;

/**
* @ORM\OneToMany(targetEntity="Examen", mappedBy="promo")
*/
protected $examen; 

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etudiant = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examen = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Promo
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
     * Add etudiant
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant
     * @return Promo
     */
    public function addEtudiant(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiant[] = $etudiant;
    
        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiant->removeElement($etudiant);
    }

    /**
     * Get etudiant
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Add examen
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Examen $examen
     * @return Promo
     */
    public function addExamen(\Ensiie\Bundle\DataBundle\Entity\Examen $examen)
    {
        $this->examen[] = $examen;
    
        return $this;
    }

    /**
     * Remove examen
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Examen $examen
     */
    public function removeExamen(\Ensiie\Bundle\DataBundle\Entity\Examen $examen)
    {
        $this->examen->removeElement($examen);
    }

    /**
     * Get examen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamen()
    {
        return $this->examen;
    }
}