<?php
namespace Sketch\Entities;

use Doctrine\ORM\Mapping AS ORM;

/** @ORM\Entity */
class Users
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /** @ORM\Column(length=255) */
    private $login;
    
    /** @ORM\Column(length=255) */
    private $password;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $email;
    
    /** @ORM\Column(type="integer") */
    private $role; 
   
}