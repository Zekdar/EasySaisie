<?php
// src/EasySaisieBundle/TeachingUnitContainer.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\TeachingUnitContainerRepository")
 */
class TeachingUnitContainer
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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnit", inversedBy="teachingUnitContainers")
   */
  private $teachingUnit;

  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Container", inversedBy="teachingUnitContainers")
   */
  private $container;

  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject", mappedBy="teachingUnitContainer")
   */
  private $teachingUnitContainerSubjects;
  

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
     * Set container
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $container
     * @return TeachingUnitContainer
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
		
	/**
     * Set teachingUnit
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnit
     * @return TeachingUnitContainer
     */
    public function setTeachingUnit(\C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnit = null)
    {
        $this->teachingUnit = $teachingUnit;
    
        return $this;
    }

    /**
     * Get teachingUnit
     *
     * @return \C2J\EasySaisieBundle\Entity\TeachingUnit
     */
    public function getTeachingUnit()
    {
        return $this->teachingUnit;
    }
	
	public function __toString()
    {
        return $this->getTeachingUnit()->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teachingUnitContainerSubjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teachingUnitContainerSubjects
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubjects
     * @return TeachingUnitContainer
     */
    public function addTeachingUnitContainerSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubjects)
    {
        $this->teachingUnitContainerSubjects[] = $teachingUnitContainerSubjects;

        return $this;
    }

    /**
     * Remove teachingUnitContainerSubjects
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubjects
     */
    public function removeTeachingUnitContainerSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubjects)
    {
        $this->teachingUnitContainerSubjects->removeElement($teachingUnitContainerSubjects);
    }

    /**
     * Get teachingUnitContainerSubjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachingUnitContainerSubjects()
    {
        return $this->teachingUnitContainerSubjects;
    }
}
