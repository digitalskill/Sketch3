<?php
namespace Sketch\Entities;

use \Gedmo\Mapping\Annotation as Gedmo;
use \Doctrine\ORM\Mapping AS ORM;

/** @ORM\Entity */
class Page
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /** @ORM\Column(length=255) */
    private $description;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $keywords;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $title;
    
    /** @ORM\Column(type="text") */
    private $content;
    
    /** @ORM\Column(type="text") */
    private $edit;
    
    /** @ORM\Column(type="datetime",nullable=true)*/
    private $updated;
    
     /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /** 
     * @Gedmo\Timestampable(on="change", field="pageStatus", value="Published")
     * @ORM\Column(type="datetime",nullable=true)*/
    private $published;
    
    /** @ORM\Column(type="datetime",nullable=true)*/
    private $expires;
    
    /** @ORM\Column(length=255, nullable=true) */
    private $pageType;          // General / Product / Landing
    
    /** @ORM\Column(length=255, nullable=true) */
    private $pageStatus;        // Published / Deleted / Pending
    
    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="Page")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $updatedBy;         
    
    /** @ORM\Column(length=255, nullable=true) */
    private $pageView;          // View for Page
    
     /** @ORM\Column(length=255, nullable=true) */
    private $pageTemplate;      // Template for Page
}