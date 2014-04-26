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
   * @var float $value
   *
   * @ORM\Column(name="value", type="float")
   */
  private $value;
  
  /**
   * @var float $value
   *
   * @ORM\Column(name="session", type="integer")
   */
  private $session;
  
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
     * Set value
     *
     * @param float $value
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
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }
	
	/**
     * Set value
     *
     * @param integer $session
     * @return Mark
     */
    public function setSession($session)
    {
        $this->session = $session;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getSession()
    {
        return $this->session;
    }
}
