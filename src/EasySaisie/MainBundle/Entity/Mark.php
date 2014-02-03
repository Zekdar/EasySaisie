<?php
// src/.../Mark.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\MarkRepository")
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
   * @ORM\ManyToOne(targetEntity="...\Entity\TuSubject")
   */
  private $tuSubject;
  
  /**
   * @ORM\ManyToOne(targetEntity="...\Entity\StudentPromotion")
   */
  private $studentPromotion;
  
}