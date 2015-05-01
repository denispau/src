<?php

namespace SP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Theme
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SP\PlatformBundle\Entity\ThemeRepository")
 */
class Theme
{
    /**
    * @ORM\ManyToOne(targetEntity="Evenement", mappedBy="theme")
    */
    /**
    * @ORM\ManyToOne(targetEntity="CA", inversedBy="theme")
    * @ORM\JoinColumn(name="CA_id", referencedColumnName="id")
    */

    private $evenement;
    protected $ca;

public function __construct()
{
    $this->evenement = new ArrayCollection();
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
     * @var array
     *
     * @ORM\Column(name="theme", type="array")
     */
    private $theme;


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
     * Set theme
     *
     * @param array $theme
     * @return Theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return array 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    public function setEvenement(Evenement $evenement)
    {
        $this->evenement=evenement;

        return $this;
    }

    public function getEvenement()
    {
        return $this->evenement;
    }
}