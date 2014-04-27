<?php
// src/EasySaisieBundle/TeachingUnitContainerSubject.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubjectRepository")
 */
class TeachingUnitContainerSubject
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
   * @var smallint $coeff
   *
   * @ORM\Column(name="coeff", type="smallint")
   */
  private $coeff;
  
  /**
   * @var smallint $ects
   *
   * @ORM\Column(name="ects", type="smallint")
   */
  private $ects;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Teacher")
   */
  private $teacher;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitContainer", inversedBy="teachingUnitContainerSubjects")
   */
  private $teachingUnitContainer;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Subject")
   */
  private $subject;
  
  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\Mark", mappedBy="teachingUnitContainerSubject")
   */
  private $marks;
  
  private $container;
  private $teachingUnit;
  

    /**
     * Set coeff
     *
     * @param integer $coeff
     * @return TeachingUnitContainerSubject
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;
    
        return $this;
    }

    /**
     * Get coeff
     *
     * @return integer 
     */
    public function getCoeff()
    {
        return $this->coeff;
    }
	
	/**
     * Set ects
     *
     * @param integer $ects
     * @return TeachingUnitContainerSubject
     */
    public function setEcts($ects)
    {
        $this->ects = $ects;
    
        return $this;
    }

    /**
     * Get ects
     *
     * @return integer 
     */
    public function getEcts()
    {
        return $this->ects;
    }
	
	/**
     * Set teacher
     *
     * @param \C2J\EasySaisieBundle\Entity\Teacher $teacher
     * @return TeachingUnitContainerSubject
     */
    public function setTeacher(\C2J\EasySaisieBundle\Entity\Teacher $teacher)
    {
        $this->teacher = $teacher;
    
        return $this;
    }

    /**
     * Get teacher
     *
     * @return \C2J\EasySaisieBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set teachingUnitContainer
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainer
     * @return TeachingUnitContainerSubject
     */
    public function setTeachingUnitContainer(\C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainer)
    {
        $this->teachingUnitContainer = $teachingUnitContainer;
    
        return $this;
    }

    /**
     * Get teachingUnitContainer
     *
     * @return \C2J\EasySaisieBundle\Entity\TeachingUnitContainer 
     */
    public function getTeachingUnitContainer()
    {
        return $this->teachingUnitContainer;
    }

    /**
     * Set subject
     *
     * @param \C2J\EasySaisieBundle\Entity\Subject $subject
     * @return TeachingUnitContainerSubject
     */
    public function setSubject(\C2J\EasySaisieBundle\Entity\Subject $subject)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return \C2J\EasySaisieBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
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
	
	public function __toString()
    {
        return $this->getSubject()."";
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->marks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add marks
     *
     * @param \C2J\EasySaisieBundle\Entity\Mark $marks
     * @return TeachingUnitContainerSubject
     */
    public function addMark(\C2J\EasySaisieBundle\Entity\Mark $marks)
    {
        $this->marks[] = $marks;

        return $this;
    }

    /**
     * Remove marks
     *
     * @param \C2J\EasySaisieBundle\Entity\Mark $marks
     */
    public function removeMark(\C2J\EasySaisieBundle\Entity\Mark $marks)
    {
        $this->marks->removeElement($marks);
    }

    /**
     * Get marks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarks()
    {
        return $this->marks;
    }
	
	/**
     * Set container
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $container
     * @return TeachingUnitContainerSubject
     */
    public function setContainer(\C2J\EasySaisieBundle\Entity\Container $container)
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
     * @return TeachingUnitContainerSubject
     */
    public function setTeachingUnit(\C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnit)
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
}
