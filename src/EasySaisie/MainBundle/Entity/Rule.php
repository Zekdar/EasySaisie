<?php
// src/EasySaisieBundle/Rule.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\RuleRepository")
 */
class Rule
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
   * @var integer $name
   *
   * @ORM\Column(name="name", type="integer")
   */
  private $name;
}