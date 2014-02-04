<?php
// src/EasySaisieBundle/StudentPromotion.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\StudentPromotionRepository")
 */
class StudentPromotion
{
  /**
   * @var string $year
   *
   * @ORM\Column(name="year", type="string", length=4)
   */
  private $year;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\Student")
   */
  private $student;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\Promotion")
   */
  private $promotion;
}