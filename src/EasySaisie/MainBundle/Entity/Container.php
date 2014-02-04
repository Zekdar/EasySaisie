<?php
// src/EasySaisieBundle/Container.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\ContainerRepository")
 */
class Container
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
   * @ORM\ManyToOne(targetEntity="EasySaisie\MainBundle\Entity\Promotion")
   */
  private $promotion;
}