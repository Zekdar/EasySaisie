<?php

// src/EasySaisie/MainBundle/Promotion.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\PromotionRepository")
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
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\Formation")
   */
  private $formation;
}