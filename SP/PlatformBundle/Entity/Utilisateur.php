<?php

namespace SP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as  Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SP\PlatformBundle\Entity\UtilisateurRepository")
 * @UniqueEntity(fields="adresseMail", message="Cette adresse est déjà utilisée par un utilisateur")
 */
class Utilisateur
{
 /**
  * @ORM\ManyToOne(targetEntity="Evenement", mappedBy="utilisateur")
  */

 /**
 * @ORM\ManyToOne(targetEntity="CA", inversedBy="utilisateur")
 * @ORM\JoinColumn(name="CA_id", referencedColumnName="id")
 */

  private $evenement;
  protected $ca;

public function __construct()
{
    $this-> evenement = new ArrayCollection();
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
     * @ORM\Column(name="nomUtilisateur", type="string", length=255)
     * @Assert\Length(min=2, message="Le nom de l'utilisateur doit faire au moins {{ limit }} caractères.")
     */
    private $nomUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomUtilisateur", type="string", length=255)
     * @Assert\Length(min=2, message="Le prénom de l'utilisateur doit faire au moins {{ limit }} caractères.")
     */
     */
    private $prenomUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseMail", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $adresseMail;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $motDePasse;

    /**
     * @var array
     *
     * @ORM\Column(name="Administrateur", type="array")
     */
    private $administrateur;


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
     * Set nomUtilisateur
     *
     * @param string $nomUtilisateur
     * @return Utilisateur
     */
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * Get nomUtilisateur
     *
     * @return string 
     */
    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    /**
     * Set prenomUtilisateur
     *
     * @param string $prenomUtilisateur
     * @return Utilisateur
     */
    public function setPrenomUtilisateur($prenomUtilisateur)
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    /**
     * Get prenomUtilisateur
     *
     * @return string 
     */
    public function getPrenomUtilisateur()
    {
        return $this->prenomUtilisateur;
    }

    /**
     * Set adresseMail
     *
     * @param string $adresseMail
     * @return Utilisateur
     */
    public function setAdresseMail($adresseMail)
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    /**
     * Get adresseMail
     *
     * @return string 
     */
    public function getAdresseMail()
    {
        return $this->adresseMail;
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     * @return Utilisateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string 
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set administrateur
     *
     * @param array $administrateur
     * @return Utilisateur
     */
    public function setAdministrateur($administrateur)
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    /**
     * Get administrateur
     *
     * @return array 
     */
    public function getAdministrateur()
    {
        return $this->administrateur;
    }

    public function setEvenenement (Evenement $evenement)
    {
        $this->evenement =$evenement;

        return $this;
    }

    public function getEvenement()
    {
        return $this->evenement;
    }
}