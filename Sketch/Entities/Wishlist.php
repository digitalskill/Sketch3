<?php
namespace Sketch\Entities;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\WishlistRepository")
 */
class Wishlist
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

    public function __construct() {
        $this->product    = new \Doctrine\Common\Collections\ArrayCollection();
    }
}