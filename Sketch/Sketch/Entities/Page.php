<?php
namespace Sketch\Entities;

use \Gedmo\Mapping\Annotation as Gedmo;
use \Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\PageRepository")
 *
 */
class Page
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

    /** @ORM\Column(type="integer") */
    private $deleted = 0;

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
     * @ORM\ManyToOne(targetEntity="User")
     **/
    private $updatedBy;

    /** @ORM\Column(length=255, nullable=true) */
    private $pageView;          // View for Page

     /** @ORM\Column(length=255, nullable=true) */
    private $pageTemplate;      // Template for Page

    /**
     * @ORM\ManyToMany(targetEntity="Block")
     * @ORM\OrderBy({"type" = "ASC","sort" = "ASC"})
     */
    private $blocks;

    /**
     * @ORM\ManyToMany(targetEntity="Tag")
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity="Comment")
     */
    private $comment;

    public function addComment(\Sketch\Entities\Comment $b)
    {
        $this->comment[] = $b;
    }

    public function getComment()
    {
        return $this->comment->toArray();
    }

    public function addTag(\Sketch\Entities\Tag $b)
    {
        $this->tag[] = $b;
    }

    public function getTag()
    {
        return $this->tag->toArray();
    }

    public function addBlock(\Sketch\Entities\Block $b)
    {
        $this->blocks[] = $b;
    }

    public function getBlocks()
    {
        return $this->blocks->toArray();
    }
    public function __construct()
    {
        $this->comment  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->blocks   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag      = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
