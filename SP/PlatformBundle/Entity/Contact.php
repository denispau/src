<?php

namespace SP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collection\ArrayCollection;
use Symfony\Component\Validator\Constraints as  Assert;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SP\PlatformBundle\Entity\ContactRepository")
 */
class Contact
{
    /**
    * @ORM/ManyToOne(targetEntity="CA", mappedBy="contact")
    * @ORM/JoinColumn(nullable=false)
    */
    protected $ca;

public function __construct()
{
    $this->ca = new ArrayCollection();
}

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomContact", type="string", length=255)
     * @Assert\Length(min=2, message=" Le nom du contact doit faire au moins {{ limit }} caract�res.")
     */
    private $nomContact;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomContact", type="string", length=255)
     * @Assert\Length(min=2, message=" Le pr�nom du contact doit faire au moins {{ limit }} caract�res."))
     */
    private $prenomContact;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseMailContact", type="string", length=255)
     * @Assert\Email()
     */
    private $adresseMailContact;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroTelephoneContact", type="string", length=255)
     * @Assert\Length(min=10)
     */
    private $numeroTelephoneContact;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomContact
     *
     * @param string $nomContact
     * @return Contact
     */
    public function setNomContact($nomContact)
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    /**
     * Get nomContact
     *
     * @return string 
     */
    public function getNomContact()
    {
        return $this->nomContact;
    }

    /**
     * Set prenomContact
     *
     * @param string $prenomContact
     * @return Contact
     */
    public function setPrenomContact($prenomContact)
    {
        $this->prenomContact = $prenomContact;

        return $this;
    }

    /**
     * Get prenomContact
     *
     * @return string 
     */
    public function getPrenomContact()
    {
        return $this->prenomContact;
    }

    /**
     * Set adresseMailContact
     *
     * @param string $adresseMailContact
     * @return Contact
     */
    public function setAdresseMailContact($adresseMailContact)
    {
        $this->adresseMailContact = $adresseMailContact;

        return $this;
    }

    /**
     * Get adresseMailContact
     *
     * @return string 
     */
    public function getAdresseMailContact()
    {
        return $this->adresseMailContact;
    }

    /**
     * Set numeroTelephoneContact
     *
     * @param string $numeroTelephoneContact
     * @return Contact
     */
    public function setNumeroTelephoneContact($numeroTelephoneContact)
    {
        $this->numeroTelephoneContact = $numeroTelephoneContact;

        return $this;
    }

    /**
     * Get numeroTelephoneContact
     *
     * @return string 
     */
    public function getNumeroTelephoneContact()
    {
        return $this->numeroTelephoneContact;
    }

    public function setCA(CA $ca)
    {
        $this->ca=$ca;

        return $this;
    }

    public function getCA()
    {
        return $this->ca;
    }
}