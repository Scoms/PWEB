<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
* @ORM\Table(name="etudiant")
*/

class Etudiant {
    
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;

/**
* @ORM\Column(type="string", length=100)
*/
protected $nom;

/**
* @ORM\Column(type="string", length=100)
*/
protected $prenom;

/**
* @ORM\Column(type="string", length=100)
*/
protected $adresse;

/**
* @ORM\Column(type="integer")
*/
protected $codePostal;

/**
* @ORM\Column(type="string", length=100)
*/
protected $ville;

/**
* @ORM\Column(type="string", length=100)
*/
protected $email;
/**
* @ORM\Column(type="integer", length=10)
*/
protected $telephone;

/**
* @ORM\ManyToOne(targetEntity="Promo",inversedBy="etudiant")
* @ORM\JoinColumn(name="promo", referencedColumnName="id") 
*/
protected $promo;

/**
* @ORM\OneToMany(targetEntity="Depot", mappedBy="etudiant")
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
     * Set nom
     *
     * @param string $nom
     * @return Etudiant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Etudiant
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Etudiant
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     * @return Etudiant
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    
        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Etudiant
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Etudiant
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
     * Set telephone
     *
     * @param integer $telephone
     * @return Etudiant
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set promo
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Promo $promo
     * @return Etudiant
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
     * @return Etudiant
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