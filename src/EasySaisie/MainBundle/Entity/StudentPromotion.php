<?php
// src/.../StudentPromotion.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\StudentPromotionRepository")
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
   * @ORM\ManyToOne(targetEntity="...\Entity\Student")
   */
  private $student;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="...\Entity\Promotion")
   */
  private $promotion;
}