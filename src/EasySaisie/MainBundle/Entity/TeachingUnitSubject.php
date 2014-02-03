<?php
// src/.../TeachingUnitSubject.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\TeachingUnitSubjectRepository")
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
   * @ORM\ManyToOne(targetEntity="...\Entity\TeachingUnit")
   */
  private $teachingUnit;
  
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="...\Entity\Subject")
   */
  private $subject;
}