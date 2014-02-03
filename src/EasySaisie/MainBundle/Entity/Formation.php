<?php
// src/.../Formation.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\FormationRepository")
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