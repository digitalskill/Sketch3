<?php
namespace Sketch\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\EmailMessageRepository")
 */
class EmailMessage
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
    private $sentfrom;

    /** @ORM\Column(length=255) */
    private $sendto;

    /** @ORM\Column(length=255) */
    private $formpage;

    /** @ORM\Column(type="datetime") */
    private $datesent;

     /** @ORM\Column(type="integer", nullable=true) */
    private $emailresult;
}
