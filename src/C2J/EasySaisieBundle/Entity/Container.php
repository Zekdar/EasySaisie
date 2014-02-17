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
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Promotion")
   */
  private $promotion;

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
}
