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

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $heading;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $content;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;
    
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $image;
    
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $link;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type = 0; // 0 = banner : 1 =  call to action : 2
    
    /**
     * @ORM\ManyToMany(targetEntity="Block")
     * @ORM\OrderBy({"type" = "ASC","sort" = "ASC"})
     * @ORM\JoinTable(name="Block_Block",
     *      joinColumns={@ORM\JoinColumn(name="Block_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="SubBlock_id", referencedColumnName="id")}
     *      )
     */
    private $blocks;
    
    public function addBlock(\Sketch\Entities\Block $b) {
        $this->blocks[] = $b;
    }
    
    public function getBlocks(){
        return $this->blocks->toArray();
    }
    public function __construct() {
        $this->blocks = new \Doctrine\Common\Collections\ArrayCollection();
    }
}