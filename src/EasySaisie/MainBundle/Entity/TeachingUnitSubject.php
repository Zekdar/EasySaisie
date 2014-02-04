<?php
// src/EasySaisieBundle/TeachingUnitSubject.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\TeachingUnitSubjectRepository")
 */
class TeachingUnitSubject
{  
  /**
   * @var smallint $coeff
   *
   * @ORM\Column(name="coeff", type="smallint")
   */
  private $coeff;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\TeachingUnit")
   */
  private $teachingUnit;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\Subject")
   */
  private $subject;
}