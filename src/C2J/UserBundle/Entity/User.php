<?php
// src/C2J/UserBundle/Entity/User.php

namespace C2J\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
  
  
  /**
   * @var string $myRoles
   *
   * @ORM\Column(name="myRoles", type="string", length=255)
   */
  private $myRoles;

  /**
   * @var string $student
   *
   * @ORM\OneToOne(targetEntity="C2J\EasySaisieBundle\Entity\Student")
   */
  private $student;

  /**
   * @var string $teacher
   *
   * @ORM\OneToOne(targetEntity="C2J\EasySaisieBundle\Entity\Teacher")
   */
  private $teacher;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set myRoles
     *
     * @param string $myRoles
     * @return User
     */
    public function setMyRoles($myRoles)
    {
        $this->myRoles = $myRoles;

        return $this;
    }

    /**
     * Get myRoles
     *
     * @return string 
     */
    public function getMyRoles()
    {
        return $this->myRoles;
    }

    /**
     * Set student
     *
     * @param \C2J\EasySaisieBundle\Entity\Student $student
     * @return User
     */
    public function setStudent(\C2J\EasySaisieBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \C2J\EasySaisieBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set teacher
     *
     * @param \C2J\EasySaisieBundle\Entity\Teacher $teacher
     * @return User
     */
    public function setTeacher(\C2J\EasySaisieBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \C2J\EasySaisieBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
