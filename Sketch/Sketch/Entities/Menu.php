<?php
namespace Sketch\Entities;

use \Gedmo\Mapping\Annotation as Gedmo;
use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\MenuRepository")
 * @ORM\Table(name="Menu",indexes={
 *      @ORM\Index(name="sort_idx",     columns={"sort"}),
 *      @ORM\Index(name="lvl_idx",      columns={"lvl"}),
 *      @ORM\Index(name="onmenu_idx",   columns={"onMenu"}),
 *      @ORM\Index(name="path_idx",     columns={"path"})
 * }),
 * uniqueConstraints={@ORM\UniqueConstraint(name="path_unq",columns={"path"})}
 * @Gedmo\Tree(type="materializedPath")
 */
class Menu
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @Gedmo\TreePath(appendId=false, separator="/", startsWithSeparator=false, endsWithSeparator=false)
     * @ORM\Column(name="path", type="string", length=3000, nullable=true)
     */
    private $path;

    /**
     * @Gedmo\TreePathSource
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $parent;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort = 0;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToOne(targetEntity="Page")
     */
    private $page;

     /**
     * @ORM\ManyToOne(targetEntity="Site")
     */
    private $site;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $landing;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $holding = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $onMenu = 1;

    /**
     * @ORM\Column(length=80)
     */
    private $menuclass = "";

    /**
     * @ORM\Column(length=80)
     */
    private $menuimage = "";

    /**
     * @ORM\Column(type="integer")
     */
    private $deleted = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $doMegaMenu = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $menuDescription;

    /**
     * @ORM\Column(type="float", precision=2, scale=10 )
     */
    private $pageRank = 0.5;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setParent(Menu $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getLevel()
    {
        return $this->level;
    }

}
