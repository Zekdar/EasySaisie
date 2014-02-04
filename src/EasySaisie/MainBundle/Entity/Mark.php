<?php
// src/EasySaisieBundle/Mark.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\MarkRepository")
 */
class Mark
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
   * @var decimal $value
   *
   * @ORM\Column(name="value", type="decimal")
   */
  private $value;
  
  /**
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\TeachingUnitSubject")
   */
  private $tuSubject;
  
  /**
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\StudentPromotion")
   */
  private $studentPromotion;
  
}