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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
