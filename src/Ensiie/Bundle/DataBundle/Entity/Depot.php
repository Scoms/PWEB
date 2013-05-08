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
  * @Assert\File(maxSize="6000000")
  */
protected $file;

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
* @ORM\Column(type="string", length=100,nullable=true)
*/
protected $path;

/**
* @ORM\Column(type="decimal",precision=4,scale=2,nullable=true)
*/
protected $note;

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

    /**
     * Set path
     *
     * @param string $path
     * @return Depot
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
        
    public function getFile()
    {
      return $this->file;
    }
    
    public function setFile($file)
    {
      return $this->file = $file;
    }
        public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }
    public function getDlPath()
    {
      return "../../../".$this->getUploadDir()."/".$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/depots/'.$this->getEtudiant()->getUser()->getUserName()."/".$this->getExamen()->getId();
    }
    public function upload()
    {
      if (null === $this->file) {
	  return;
      }
      try
      {
	$this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
      }
      catch(Exception $e)
      {
	
      }
      $this->path = $this->file->getClientOriginalName();
      $this->file = null;
    }


    /**
     * Set note
     *
     * @param integer $note
     * @return Depot
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }
}