<?php
// src/EasySaisieBundle/Formation.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\FormationRepository")
 */
class Formation
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
   * @var string $nom
   *
   * @ORM\Column(name="nom", type="string", length=255)
   */
  private $nom;

  /**
   * @var string $type
   *
   * @ORM\Column(name="type", type="string", length=255)
   */
  private $type;
  
}