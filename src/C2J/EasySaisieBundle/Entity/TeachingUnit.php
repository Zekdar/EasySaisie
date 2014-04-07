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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Container", inversedBy="teachingUnits")
   */
  private $container;

  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitSubject", mappedBy="teachingUnit")
   */
  private $teachingUnitSubjects;
  

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
     * Set container
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $container
     * @return TeachingUnit
     */
    public function setContainer(\C2J\EasySaisieBundle\Entity\Container $container = null)
    {
        $this->container = $container;
    
        return $this;
    }

    /**
     * Get container
     *
     * @return \C2J\EasySaisieBundle\Entity\Container 
     */
    public function getContainer()
    {
        return $this->container;
    }
	
	public function __toString()
    {
        return $this->name;
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
        $this->teachingUnitSubjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teachingUnitSubjects
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubjects
     * @return TeachingUnit
     */
    public function addTeachingUnitSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubjects)
    {
        $this->teachingUnitSubjects[] = $teachingUnitSubjects;

        return $this;
    }

    /**
     * Remove teachingUnitSubjects
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubjects
     */
    public function removeTeachingUnitSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubjects)
    {
        $this->teachingUnitSubjects->removeElement($teachingUnitSubjects);
    }

    /**
     * Get teachingUnitSubjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachingUnitSubjects()
    {
        return $this->teachingUnitSubjects;
    }
}
