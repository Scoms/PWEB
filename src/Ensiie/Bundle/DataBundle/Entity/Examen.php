<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity(repositoryClass="Ensiie\Bundle\DataBundle\Entity\ExamenRepository")
* @ORM\Table(name="examen")
*/

class Examen {


  /**
   * @ORM\ManyToMany(targetEntity="Etudiant",cascade={"remove"})
   */
  private $etudiants;

  /** 
  * @ORM\ManyToOne(targetEntity="FileExamen",inversedBy="examen")
  */
  protected $file;
  
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
*/
protected $promo;

/**
* @ORM\Column(type="datetime")
*/
protected $date_debut;

/**
* @ORM\Column(type="datetime")
*/
protected $date_fin;

/**
* @ORM\Column(type="integer")
*/
protected $coefficient;

/**
* @ORM\OneToMany(targetEntity="Depot", mappedBy="examen",cascade={"remove"})
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
 

    /**
     * Set file
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\FileExamen $file
     * @return Examen
     */
    public function setFile(\Ensiie\Bundle\DataBundle\Entity\FileExamen $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Ensiie\Bundle\DataBundle\Entity\FileExamen 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set date_debut
     *
     * @param \DateTime $dateDebut
     * @return Examen
     */
    public function setDateDebut($dateDebut)
    {
        $this->date_debut = $dateDebut;
    
        return $this;
    }

    /**
     * Get date_debut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * Set date_fin
     *
     * @param \DateTime $dateFin
     * @return Examen
     */
    public function setDateFin($dateFin)
    {
        $this->date_fin = $dateFin;
    
        return $this;
    }

    /**
     * Get date_fin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * Add etudiants
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants
     * @return Examen
     */
    public function addEtudiant(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants)
    {
        $this->etudiants[] = $etudiants;
    
        return $this;
    }

    /**
     * Remove etudiants
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants
     */
    public function removeEtudiant(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants)
    {
        $this->etudiants->removeElement($etudiants);
    }
    
    /**
     * Set etudiants
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants
     */
    public function setEtudiants(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiants)
    {
        $this->etudiants[] = $etudiants;
    }

    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtudiants()
    {
        return $this->etudiants;
    }

    public function __toString()
    {
      return $this->getLibelle();
    }
}
