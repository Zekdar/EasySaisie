<?php
// src/EasySaisieBundle/Subject.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisieBundle\Entity\SubjectRepository")
 */
class Subject
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
   * @var string $abbreviation
   *
   * @ORM\Column(name="abbreviation", type="string", length=255)
   */
  private $abbreviation;

  /**
   * @var string $name
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;
  
}