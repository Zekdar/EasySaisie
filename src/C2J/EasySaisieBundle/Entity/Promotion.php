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
}