<?php
// src/EasySaisieBundle/TeachingUnit.php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\TeachingUnitRepository")
 */
class TeachingUnit
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
   * @var string $code
   *
   * @ORM\Column(name="code", type="string", length=255)
   */
  private $code;
    
  /**
   * @ORM\ManyToOne(targetEntity="C2J\EasySaisieBundle\Entity\Container")
   */
  private $container;
  

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
     * @return TeachingUnit
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
     * Set code
     *
     * @param string $code
     * @return TeachingUnit
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set container
     *
     * @param \C2J\EasySaisieBundle\Entity\Container $container
     * @return TeachingUnit
     */
    public function setContainer(\C2J\EasySaisieBundle\Entity\Container $container = null)
    {
        $this->container = $container;
    
        return $this;
    }

    /**
     * Get container
     *
     * @return \C2J\EasySaisieBundle\Entity\Container 
     */
    public function getContainer()
    {
        return $this->container;
    }
	
	public function __toString()
    {
        return $this->name;
    }
}
