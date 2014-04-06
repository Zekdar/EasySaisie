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
   * @var boolean  $areTeachingUnitsCompensable
   *
   * @ORM\Column(name="areTeachingUnitsCompensable", type="boolean")
   */
  private $areTeachingUnitsCompensable;
  
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
   * @ORM\OneToMany(targetEntity="C2J\EasySaisieBundle\Entity\TeachingUnit", mappedBy="container")
   */
  private $teachingUnits;
  
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
   * Set areTeachingUnitsCompensable
   *
   * @param boolean $areTeachingUnitsCompensable
   * @return Container
   */
  public function setAreTeachingUnitsCompensable($areTeachingUnitsCompensable)
  {
      $this->areTeachingUnitsCompensable = $areTeachingUnitsCompensable;
  
      return $this;
  }

  /**
   * Get areTeachingUnitsCompensable
   *
   * @return boolean 
   */
  public function getAreTeachingUnitsCompensable()
  {
      return $this->areTeachingUnitsCompensable;
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
        $this->teachingUnits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teachingUnits
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnits
     * @return Container
     */
    public function addTeachingUnit(\C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnits)
    {
        $this->teachingUnits[] = $teachingUnits;

        return $this;
    }

    /**
     * Remove teachingUnits
     *
     * @param \C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnits
     */
    public function removeTeachingUnit(\C2J\EasySaisieBundle\Entity\TeachingUnit $teachingUnits)
    {
        $this->teachingUnits->removeElement($teachingUnits);
    }

    /**
     * Get teachingUnits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachingUnits()
    {
        return $this->teachingUnits;
    }
}
