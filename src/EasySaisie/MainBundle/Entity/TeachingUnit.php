<?php
// src/.../TeachingUnit.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\TeachingUnitRepository")
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
   * @ORM\ManyToOne(targetEntity="...\Entity\Container")
   */
  private $container;
  
}