<?php
namespace Sketch\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\SiteRepository")
 * 
 */
class Site
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /** @ORM\Column(length=255) */
    private $name;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $email;
    
    /** @ORM\Column(length=15, nullable=true) */
    private $phone;
    
     /** @ORM\Column(length=15, nullable=true) */
    private $mobile;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $address;

    /** @ORM\Column(length=255, nullable=true) */
    private $suburb;
    
    /** @ORM\Column(length=50, nullable=true) */
    private $state;
    
    /** @ORM\Column(length=10, nullable=true) */
    private $zip;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $logo;
    
    /** @ORM\Column(length=100, nullable=true) */
    private $domainname;
    
    /** @ORM\Column(type="integer") */
    private $published = 0;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $placeholderPage;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $paymentPage;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $contactPage;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $paymentType;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $paymentDps;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $paymentPaypal;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $paymentFetch;
}