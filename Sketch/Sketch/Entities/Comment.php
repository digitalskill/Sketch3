<?php
namespace Sketch\Entities;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(type="integer")
     */
    private $approved = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commentdate;

    /**
     * @ORM\OneToOne(targetEntity="User")
     */
    private $user;
}
