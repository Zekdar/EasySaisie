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
   * @ORM\ManyToOne(targetEntity="EasySaisieBundle\Entity\TeachingUnitSubject")
   */
  private $tuSubject;
  
  /**
   * @ORM\ManyToOne(targetEntity="EasySaisieBundle\Entity\StudentPromotion")
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
     * Set tuSubject
     *
     * @param \EasySaisieBundle\Entity\TeachingUnitSubject $tuSubject
     * @return Mark
     */
    public function setTuSubject(\EasySaisieBundle\Entity\TeachingUnitSubject $tuSubject = null)
    {
        $this->tuSubject = $tuSubject;
    
        return $this;
    }

    /**
     * Get tuSubject
     *
     * @return \EasySaisieBundle\Entity\TeachingUnitSubject 
     */
    public function getTuSubject()
    {
        return $this->tuSubject;
    }

    /**
     * Set studentPromotion
     *
     * @param \EasySaisieBundle\Entity\StudentPromotion $studentPromotion
     * @return Mark
     */
    public function setStudentPromotion(\EasySaisieBundle\Entity\StudentPromotion $studentPromotion = null)
    {
        $this->studentPromotion = $studentPromotion;
    
        return $this;
    }

    /**
     * Get studentPromotion
     *
     * @return \EasySaisieBundle\Entity\StudentPromotion 
     */
    public function getStudentPromotion()
    {
        return $this->studentPromotion;
    }
}
