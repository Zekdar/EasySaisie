<?php
// src/EasySaisieBundle/TeachingUnitSubject.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\TeachingUnitSubjectRepository")
 */
class TeachingUnitSubject
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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnit")
   */
  private $teachingUnit;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Subject")
   */
  private $subject;

    /**
     * Set coeff
     *
     * @param integer $coeff
     * @return TeachingUnitSubject
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
     * Set teachingUnit
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnit
     * @return TeachingUnitSubject
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

    /**
     * Set subject
     *
     * @param \C2J\EasySaisieBundle\Entity\Subject $subject
     * @return TeachingUnitSubject
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
}
