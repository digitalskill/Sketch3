<?php
namespace Sketch\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\UserRepository")
 */
class User
{
    use \Sketch\Traits\GetterSetter;
    use \Sketch\Traits\Extensions;
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

    /** @ORM\Column(length=100, nullable=true) */
    private $firstname;

    /** @ORM\Column(length=255, nullable=true) */
    private $lastname;

    /** @ORM\Column(length=255, nullable=true) */
    private $address;

    /** @ORM\Column(length=255, nullable=true) */
    private $address2;

    /** @ORM\Column(length=255, nullable=true) */
    private $suburb;

    /** @ORM\Column(length=255, nullable=true) */
    private $city;

    /** @ORM\Column(length=255, nullable=true) */
    private $country;

    /** @ORM\Column(length=255, nullable=true) */
    private $state;

    /** @ORM\Column(length=255, nullable=true) */
    private $postcode;

    /** @ORM\Column(length=255, nullable=true) */
    private $mobile;

    /** @ORM\Column(length=255, nullable=true) */
    private $phone;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $lastlogin;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $datejoined;

    /** @ORM\Column(type="integer", nullable=true) */
    private $subscribed = 0;

    /** @ORM\Column(length=80) */
    private $type;      // Admin | Member | Contributor

    /** @ORM\Column(type="datetime", nullable=true) */
    private $tokenExpiry;

    /** @ORM\Column(length=255, nullable=true) */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="Wishlist")
     */
    private $wishlist;
}
