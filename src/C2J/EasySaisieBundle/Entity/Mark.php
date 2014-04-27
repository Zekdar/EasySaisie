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
   * @var float $valueS1
   *
   * @ORM\Column(name="valueS1", type="float")
   */
  private $valueS1;

  /**
   * @var float $valueS2
   *
   * @ORM\Column(name="valueS2", type="float", nullable=true)
   */
  private $valueS2 = null;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject", inversedBy="marks")
   */
  private $teachingUnitContainerSubject;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\StudentPromotion", inversedBy="marks")
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
     * Set teachingUnitContainerSubject
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubject
     * @return Mark
     */
    public function setTeachingUnitContainerSubject(\C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject $teachingUnitContainerSubject = null)
    {
        $this->teachingUnitContainerSubject = $teachingUnitContainerSubject;
    
        return $this;
    }

    /**
     * Get teachingUnitContainerSubject
     *
     * @return \C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject 
     */
    public function getTeachingUnitContainerSubject()
    {
        return $this->teachingUnitContainerSubject;
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

    /**
     * Set valueS1
     *
     * @param float $valueS1
     * @return Mark
     */
    public function setValueS1($valueS1)
    {
        $this->valueS1 = $valueS1;
    
        return $this;
    }

    /**
     * Get valueS1
     *
     * @return float 
     */
    public function getValueS1()
    {
        return $this->valueS1;
    }
  
    /**
     * Set valueS2
     *
     * @param float $valueS2
     * @return Mark
     */
    public function setValueS2($valueS2)
    {
        $this->valueS1 = $valueS2;
    
        return $this;
    }

    /**
     * Get valueS2
     *
     * @return float 
     */
    public function getValueS2()
    {
        return $this->valueS2;
    }
}
