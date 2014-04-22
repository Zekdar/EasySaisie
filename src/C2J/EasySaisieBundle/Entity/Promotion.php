<?php

// src/EasySaisie/MainBundle/Promotion.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\PromotionRepository")
 */
class Promotion
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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Formation")
   */
   
  private $formation;
  
  /**
   * @var string $name
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;
  
  /**
   * @var decimal $minAverageToValidate
   *
   * @ORM\Column(name="minAverageToValidate", type="float")
   */
  private $minAverageToValidate;

  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\StudentPromotion", mappedBy="promotion")
   */
  private $studentPromotions;

  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\Container", mappedBy="promotion")
   */
  private $containers;
  
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
     * Set year
     *
     * @param string $year
     * @return Promotion
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
   * Set formation
   *
   * @param \C2J\EasySaisieBundle\Entity\Formation $formation
   * @return Promotion
   */
  public function setFormation(\C2J\EasySaisieBundle\Entity\Formation $formation = null)
  {
      $this->formation = $formation;
  
      return $this;
  }

  /**
   * Get formation
   *
   * @return \C2J\EasySaisieBundle\Entity\Formation 
   */
  public function getFormation()
  {
      return $this->formation;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return Promotion
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

	public function __toString()
	{
		return $this->name." ".$this->getFormation();
	}

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studentPromotions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->containers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add studentPromotions
     *
     * @param \C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotions
     * @return Promotion
     */
    public function addStudentPromotion(\C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotions)
    {
        $this->studentPromotions[] = $studentPromotions;

        return $this;
    }

    /**
     * Remove studentPromotions
     *
     * @param \C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotions
     */
    public function removeStudentPromotion(\C2J\EasySaisieBundle\Entity\StudentPromotion $studentPromotions)
    {
        $this->studentPromotions->removeElement($studentPromotions);
    }

    /**
     * Get studentPromotions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudentPromotions()
    {
        return $this->studentPromotions;
    }

    /**
     * Add containers
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $containers
     * @return Promotion
     */
    public function addContainer(\C2J\EasySaisieBundle\Entity\Container $containers)
    {
        $this->containers[] = $containers;

        return $this;
    }

    /**
     * Remove containers
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $containers
     */
    public function removeContainer(\C2J\EasySaisieBundle\Entity\Container $containers)
    {
        $this->containers->removeElement($containers);
    }

    /**
     * Get containers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * Set minAverageToValidate
     *
     * @param float $minAverageToValidate
     * @return Promotion
     */
    public function setMinAverageToValidate($minAverageToValidate)
    {
        $this->minAverageToValidate = $minAverageToValidate;
    
        return $this;
    }

    /**
     * Get minAverageToValidate
     *
     * @return float 
     */
    public function getMinAverageToValidate()
    {
        return $this->minAverageToValidate;
    }
}
