<?php
// src/EasySaisieBundle/StudentPromotion.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\StudentPromotionRepository")
 */
class StudentPromotion
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
   * @var string $year
   *
   * @ORM\Column(name="year", type="string", length=4)
   */
  private $year;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Student")
   */
  private $student;
  
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Promotion")
   */
  private $promotion;
  
  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\Mark", mappedBy="studentPromotion")
   */
  private $marks;

    /**
     * Set year
     *
     * @param string $year
     * @return StudentPromotion
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set student
     *
     * @param \C2J\EasySaisieBundle\Entity\Student $student
     * @return StudentPromotion
     */
    public function setStudent(\C2J\EasySaisieBundle\Entity\Student $student)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \C2J\EasySaisieBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set promotion
     *
     * @param \C2J\EasySaisieBundle\Entity\Promotion $promotion
     * @return StudentPromotion
     */
    public function setPromotion(\C2J\EasySaisieBundle\Entity\Promotion $promotion)
    {
        $this->promotion = $promotion;
    
        return $this;
    }

    /**
     * Get promotion
     *
     * @return \C2J\EasySaisieBundle\Entity\Promotion 
     */
    public function getPromotion()
    {
        return $this->promotion;
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
		return $this->getStudent()." ".$this->getYear()." ".$this->getPromotion();
	}
}
