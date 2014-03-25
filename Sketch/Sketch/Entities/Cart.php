<?php
namespace Sketch\Entities;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\CartRepository")
 */
class Cart
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Page")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $purchased = 0;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="purchases")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Invoice")
     */
    private $invoice;

    public function __construct()
    {
        $this->product    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user       = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
