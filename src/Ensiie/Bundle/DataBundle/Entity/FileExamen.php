<?php

namespace Ensiie\Bundle\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
/**
* @ORM\Entity
* @ORM\Table(name="FileExamen")
*/

class FileExamen 
{

     /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;
    /**
      * @ORM\ManyToOne(targetEntity="Ensiie\Bundle\UserBundle\Entity\User")
      */
     protected $user;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $path;

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
      return "../../".$this->getUploadDir()."/".$this->path;
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
        return 'uploads/examens/'.$this->getUser()->getUserName();
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
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
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
    public function upload()
    {
      if (null === $this->file) {
	  return;
      }
      $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
      $this->path = $this->file->getClientOriginalName();
      $this->file = null;
    }
    public function __toString()
    {
      return $this->getName()." : ".$this->getPath();
    }

    /**
     * Set user
     *
     * @param \Ensiie\Bundle\UserBundle\Entity\User $user
     * @return FileExamen
     */
    public function setUser(\Ensiie\Bundle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Ensiie\Bundle\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function getFile()
    {
      return $this->file;
    }
    
    public function setFile($file)
    {
      return $this->file = $file;
    }

}