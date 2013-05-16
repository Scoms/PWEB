<?php
// src/Iaato/UserBundle/Entity/User.php
 
namespace Ensiie\Bundle\UserBundle\Entity;
 

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="Ensiie\Bundle\UserBundle\Entity\UserRepository")
 */
class User implements UserInterface 
{
  /**
   * @var integer $id 
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
 
  /**
  * @ORM\OneToMany(targetEntity="Ensiie\Bundle\DataBundle\Entity\FileExamen",mappedBy="user",cascade={"remove"})
  */
  protected $examen;
  
  /**
  * @ORM\OneToOne(targetEntity="Ensiie\Bundle\DataBundle\Entity\Etudiant",mappedBy="user")
  */
  protected $etudiant;
  /**
   * @ORM\Column(name="username", type="string", length=255, unique=true)
   */
  private $username;
 
  /**
   * @ORM\Column(name="password", type="string", length=255)
   */
  private $password;
 
  /**
   * @ORM\Column(name="salt", type="string", length=255)
   */
  private $salt;
 
  	/**
   * @ORM\Column(name="roles",type="array")
   */
  private $roles;
 
  public function __construct()
  {
    $this->roles = array();
  }
   /**
    * Add roles
    *
    * @param $roles
    */
  public function setRoles($role) // addCategorie sans « s » !
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau, avec la syntaxe []
    $this->roles = $role;
  }

  /**
    * Get roles
    *
    * @return Doctrine\Common\Collections\Collection
    */
  public function getRoles() // Notez le « s », on récupère une liste de catégories ici !
  {
	return $this->roles;
  }
 
  public function getId()
  {
    return $this->id;
  }
 
  public function setUsername($username)
  {
    $this->username = $username;
    return $this;
  }
 
  public function getUsername()
  {
    return $this->username;
  }
 
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
 
  public function getPassword()
  {
    return $this->password;
  }
 
  public function setSalt($salt)
  {
    $this->salt = $salt;
    return $this;
  }
 
  public function getSalt()
  {
    return $this->salt;
  }
  
  public function eraseCredentials()
  {
  }
   
    public function serialize()
    {
	  return serialize($this->id);
    }

    public function unserialize($data)
    {
	  $this->id = unserialize($data);
    }
    
    public function __toString()
    {
      return $this->getUsername();
    }


    /**
     * Add examen
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\FileExamen $examen
     * @return User
     */
    public function addExamen(\Ensiie\Bundle\DataBundle\Entity\FileExamen $examen)
    {
        $this->examen[] = $examen;
    
        return $this;
    }

    /**
     * Remove examen
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\FileExamen $examen
     */
    public function removeExamen(\Ensiie\Bundle\DataBundle\Entity\FileExamen $examen)
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

    /**
     * Set etudiant
     *
     * @param \Ensiie\Bundle\DataBundle\Entity\Etudiant $etudiant
     * @return User
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
}
