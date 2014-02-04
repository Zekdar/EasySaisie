<?php
// src/EasySaisieBundle/Mark.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\MarkRepository")
 */
class Mark
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
   * @var decimal $value
   *
   * @ORM\Column(name="value", type="decimal")
   */
  private $value;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitSubject")
   */
  private $teachingUnitSubject;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\StudentPromotion")
   */
  private $studentPromotion;
  

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
     * Set value
     *
     * @param string $value
     * @return Mark
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set teachingUnitSubject
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubject
     * @return Mark
     */
    public function setTeachingUnitSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitSubject $teachingUnitSubject = null)
    {
        $this->teachingUnitSubject = $teachingUnitSubject;
    
        return $this;
    }

    /**
     * Get teachingUnitSubject
     *
     * @return \C2J\EasySaisieBundle\Entity\TeachingUnitSubject 
     */
    public function getTeachingUnitSubject()
    {
        return $this->teachingUnitSubject;
    }

    /**
     * Set studentPromotion
     *
     * @param \C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotion
     * @return Mark
     */
    public function setStudentPromotion(\C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotion = null)
    {
        $this->studentPromotion = $studentPromotion;
    
        return $this;
    }

    /**
     * Get studentPromotion
     *
     * @return \C2J\EasySaisieBundle\Entity\StudentPromotion 
     */
    public function getStudentPromotion()
    {
        return $this->studentPromotion;
    }
}
