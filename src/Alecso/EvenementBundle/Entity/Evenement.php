<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alecso\EvenementBundle\Repository\EventRepository;


/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="fk_evenements_admins1_idx", columns={"id_admin"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Alecso\EvenementBundle\Repository\EventRepository")
 *
 */
class Evenement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $dateCreate ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=45, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=150, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_post", type="string", length=12, nullable=true)
     */
    private $codePost;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_part", type="integer", nullable=true)
     */
    private $nbrPart;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin", cascade={"all"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_admin", referencedColumnName="id_admin", onDelete="CASCADE")
     * })
     */
    private $idAdmin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Partenaire", inversedBy="idEvent")
     * @ORM\JoinTable(name="event_part",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_event", referencedColumnName="id_event")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_partenaire", referencedColumnName="id_partenaire")
     *   }
     * )
     */
    private $idPartenaire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idEvent")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPartenaire = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreate = new \DateTime();
    }


    /**
     * Get idEvent
     *
     * @return integer
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Evenement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Evenement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Evenement
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Evenement
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Evenement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Evenement
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Evenement
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePost
     *
     * @param string $codePost
     *
     * @return Evenement
     */
    public function setCodePost($codePost)
    {
        $this->codePost = $codePost;

        return $this;
    }

    /**
     * Get codePost
     *
     * @return string
     */
    public function getCodePost()
    {
        return $this->codePost;
    }

    /**
     * Set nbrPart
     *
     * @param integer $nbrPart
     *
     * @return Evenement
     */
    public function setNbrPart($nbrPart)
    {
        $this->nbrPart = $nbrPart;

        return $this;
    }

    /**
     * Get nbrPart
     *
     * @return integer
     */
    public function getNbrPart()
    {
        return $this->nbrPart;
    }

    /**
     * Set media
     *
     * @param string $media
     *
     * @return Evenement
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set idAdmin
     *
     * @param \Alecso\EvenementBundle\Entity\Admin $idAdmin
     *
     * @return Evenement
     */
    public function setIdAdmin(\Alecso\EvenementBundle\Entity\Admin $idAdmin = null)
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    /**
     * Get idAdmin
     *
     * @return \Alecso\EvenementBundle\Entity\Admin
     */
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    /**
     * Add idPartenaire
     *
     * @param \Alecso\EvenementBundle\Entity\Partenaire $idPartenaire
     *
     * @return Evenement
     */
    public function addIdPartenaire(\Alecso\EvenementBundle\Entity\Partenaire $idPartenaire)
    {
        $this->idPartenaire[] = $idPartenaire;

        return $this;
    }

    /**
     * Remove idPartenaire
     *
     * @param \Alecso\EvenementBundle\Entity\Partenaire $idPartenaire
     */
    public function removeIdPartenaire(\Alecso\EvenementBundle\Entity\Partenaire $idPartenaire)
    {
        $this->idPartenaire->removeElement($idPartenaire);
    }

    /**
     * Get idPartenaire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdPartenaire()
    {
        return $this->idPartenaire;
    }

    /**
     * Add idUser
     *
     * @param \Alecso\EvenementBundle\Entity\User $idUser
     *
     * @return Evenement
     */
    public function addIdUser(\Alecso\EvenementBundle\Entity\User $idUser)
    {
        $this->idUser[] = $idUser;

        return $this;
    }

    /**
     * Remove idUser
     *
     * @param \Alecso\EvenementBundle\Entity\User $idUser
     */
    public function removeIdUser(\Alecso\EvenementBundle\Entity\User $idUser)
    {
        $this->idUser->removeElement($idUser);
    }

    /**
     * Get idUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
