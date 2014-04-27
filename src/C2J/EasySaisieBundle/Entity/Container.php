<?php
// src/EasySaisieBundle/Container.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\ContainerRepository")
 */
class Container
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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Promotion", inversedBy="containers")
   */
  private $promotion;
  
  /**
   * @var boolean  $isCompensable
   *
   * @ORM\Column(name="isCompensable", type="boolean")
   */
  private $isCompensable;
  
  /**
   * @var float  $minMark
   *
   * @ORM\Column(name="minMark", type="float")
   */
  private $minMark;
  
  /**
   * @var float  $minAverage
   *
   * @ORM\Column(name="minAverage", type="float")
   */
  private $minAverage;

  /**
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnitContainer", mappedBy="container")
   */
  private $teachingUnitContainers;
  
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
   * @return Container
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
   * Set promotion
   *
   * @param \C2J\EasySaisieBundle\Entity\Promotion $promotion
   * @return Container
   */
  public function setPromotion(\C2J\EasySaisieBundle\Entity\Promotion $promotion = null)
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

  public function __toString()
  {
      return $this->name;
  }

  /**
   * Set isCompensable
   *
   * @param boolean $isCompensable
   * @return Container
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
   * Set minMark
   *
   * @param float $minMark
   * @return Container
   */
  public function setMinMark($minMark)
  {
      $this->minMark = $minMark;
  
      return $this;
  }

  /**
   * Get minMark
   *
   * @return float 
   */
  public function getMinMark()
  {
      return $this->minMark;
  }

  /**
   * Set minAverage
   *
   * @param float $minAverage
   * @return Container
   */
  public function setMinAverage($minAverage)
  {
      $this->minAverage = $minAverage;
  
      return $this;
  }

  /**
   * Get minAverage
   *
   * @return float 
   */
  public function getMinAverage()
  {
      return $this->minAverage;
  }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teachingUnitContainers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teachingUnitContainers
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainers
     * @return Container
     */
    public function addTeachingContainerUnit(\C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainers)
    {
        $this->teachingUnitContainers[] = $teachingUnitContainers;

        return $this;
    }

    /**
     * Remove teachingUnitContainers
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainers
     */
    public function removeTeachingContainerUnit(\C2J\EasySaisieBundle\Entity\TeachingUnitContainer $teachingUnitContainers)
    {
        $this->teachingUnitContainers->removeElement($teachingUnitContainers);
    }

    /**
     * Get teachingUnitContainers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachingUnitContainers()
    {
        return $this->teachingUnitContainers;
    }
}
