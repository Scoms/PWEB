<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="depot")
*/

class Depot {
    
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;

/**
* @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="depot")
* @ORM\JoinColumn(name="etudiant", referencedColumnName="id") 
*/
protected $etudiant;

/**
* @ORM\ManyToOne(targetEntity="Examen", inversedBy="depot")
* @ORM\JoinColumn(name="examen", referencedColumnName="id") 
*/
protected $examen;

/**
* @ORM\Column(type="string", length=100)
*/
protected $link;

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
     * Set link
     *
     * @param string $link
     * @return Depot
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set etudiant
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant
     * @return Depot
     */
    public function setEtudiant(\Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;
    
        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Ensiie\Bundle\DataBundle\Entity\Etudiant 
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set examen
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Examen $examen
     * @return Depot
     */
    public function setExamen(\Ensiie\Bundle\DataBundle\Entity\Examen $examen = null)
    {
        $this->examen = $examen;
    
        return $this;
    }

    /**
     * Get examen
     *
     * @return \Ensiie\Bundle\DataBundle\Entity\Examen 
     */
    public function getExamen()
    {
        return $this->examen;
    }
}