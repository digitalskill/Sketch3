<?php
namespace Sketch\Entities;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\BlockRepository")
 */
class Block
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /*
     * @ORM\Column(type="string", nullable=true)
     */
    private $heading;
    
    /*
     * @ORM\Column(type="string", nullable=true)
     */
    private $content;
    
    /*
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;
    
    /*
     * @ORM\Column(length=255, nullable=true)
     */
    private $image;
    
     /*
     * @ORM\Column(length=255, nullable=true)
     */
    private $link;
    
     /*
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="Page", inversedBy="blocks")
     */
    private $pages;

    public function __construct() {
        $this->$pages = new \Doctrine\Common\Collections\ArrayCollection();
    }
}