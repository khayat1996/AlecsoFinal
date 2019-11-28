<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire
 *
 * @ORM\Table(name="partenaire", indexes={@ORM\Index(name="fk_partenaires_moderateurs1_idx", columns={"id_user"})})
 * @ORM\Entity
 */
class Partenaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_partenaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPartenaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=120, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

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
     * @var string
     *
     * @ORM\Column(name="tel1", type="string", length=18, nullable=true)
     */
    private $tel1;

    /**
     * @var string
     *
     * @ORM\Column(name="tel2", type="string", length=18, nullable=true)
     */
    private $tel2;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @var \Moderateur
     *
     * @ORM\ManyToOne(targetEntity="Moderateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_moderateur")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Evenement", mappedBy="idPartenaire")
     */
    private $idEvent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvent = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idPartenaire
     *
     * @return integer
     */
    public function getIdPartenaire()
    {
        return $this->idPartenaire;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Partenaire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Partenaire
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
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
     * @return Partenaire
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Partenaire
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
     * @return Partenaire
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
     * @return Partenaire
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
     * Set tel1
     *
     * @param string $tel1
     *
     * @return Partenaire
     */
    public function setTel1($tel1)
    {
        $this->tel1 = $tel1;

        return $this;
    }

    /**
     * Get tel1
     *
     * @return string
     */
    public function getTel1()
    {
        return $this->tel1;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     *
     * @return Partenaire
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;

        return $this;
    }

    /**
     * Get tel2
     *
     * @return string
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * Set media
     *
     * @param string $media
     *
     * @return Partenaire
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
     * Set idUser
     *
     * @param \Alecso\EvenementBundle\Entity\Moderateur $idUser
     *
     * @return Partenaire
     */
    public function setIdUser(\Alecso\EvenementBundle\Entity\Moderateur $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \Alecso\EvenementBundle\Entity\Moderateur
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Add idEvent
     *
     * @param \Alecso\EvenementBundle\Entity\Evenement $idEvent
     *
     * @return Partenaire
     */
    public function addIdEvent(\Alecso\EvenementBundle\Entity\Evenement $idEvent)
    {
        $this->idEvent[] = $idEvent;

        return $this;
    }

    /**
     * Remove idEvent
     *
     * @param \Alecso\EvenementBundle\Entity\Evenement $idEvent
     */
    public function removeIdEvent(\Alecso\EvenementBundle\Entity\Evenement $idEvent)
    {
        $this->idEvent->removeElement($idEvent);
    }

    /**
     * Get idEvent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }
}
