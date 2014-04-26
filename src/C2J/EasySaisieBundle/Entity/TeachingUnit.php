<?php
// src/EasySaisieBundle/TeachingUnit.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\TeachingUnitRepository")
 */
class TeachingUnit
{
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  
  /**
   * @var string $name
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  /**
   * @var string $code
   *
   * @ORM\Column(name="code", type="string", length=255)
   */
  private $code;
  
  /**
   * @var boolean $isCompensable
   *
   * @ORM\Column(name="isCompensable", type="boolean")
   */
  private $isCompensable;
    
  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitContainer", mappedBy="teachingUnit")
   */
  private $teachingUnitContainers;
  

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
     * @return TeachingUnit
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
     * Set code
     *
     * @param string $code
     * @return TeachingUnit
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set isCompensable
     *
     * @param boolean $isCompensable
     * @return TeachingUnit
     */
    public function setIsCompensable($isCompensable)
    {
        $this->isCompensable = $isCompensable;
    
        return $this;
    }

    /**
     * Get isCompensable
     *
     * @return boolean 
     */
    public function getIsCompensable()
    {
        return $this->isCompensable;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teachingUnitContainerSubjects = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
