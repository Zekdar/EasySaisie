<?php
// src/.../Promotion.php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="...\Entity\PromotionRepository")
 */
class Promotion
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
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="...\Entity\Formation")
   */
  private $formation;
}