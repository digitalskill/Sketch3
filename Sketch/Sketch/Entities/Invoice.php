<?php
namespace Sketch\Entities;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sketch\Entities\Repository\InvoiceRepository")
 */
class Invoice
{
    use \Sketch\Traits\GetterSetter;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $invoicedate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $invoicestatus;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $invoiceamount;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $gatewayresponse;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $paymentstatus = 0;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $invoicegateway;

    /**
     * @ORM\OneToOne(targetEntity="User")
     */
    private $user;

    public function __construct()
    {
        $this->user    = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
