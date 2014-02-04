<?php
// src/EasySaisieBundle/Student.php

namespace EasySaisie\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EasySaisie\MainBundle\Entity\StudentRepository")
 */
class Student
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
   * @var integer $number
   *
   * @ORM\Column(name="number", type="integer", unique=true)
   */
  private $number;
  
  /**
   * @var string $lastName
   *
   * @ORM\Column(name="lastName", type="string", length=255)
   */
  private $lastName;

  /**
   * @var string $firstName
   *
   * @ORM\Column(name="firstName", type="string", length=255)
   */
  private $firstName;
  
  /**
   * @var string $address
   *
   * @ORM\Column(name="address", type="string", length=255)
   */
  private $address;
  
  /**
   * @var string $zipCode
   *
   * @ORM\Column(name="zipCode", type="string", length=255)
   */
  private $zipCode;
  
  /**
   * @var string $city
   *
   * @ORM\Column(name="city", type="string", length=255)
   */
  private $city;
  
  /**
   * @var string $phone
   *
   * @ORM\Column(name="phone", type="string", length=255)
   */
  private $phone;
  
  /**
   * @var string $email
   *
   * @ORM\Column(name="email", type="string", length=255)
   */
  private $email;
  
  /**
   * @var date $birthDate
   *
   * @ORM\Column(name="birthDate", type="date")
   */
  private $birthDate;
}