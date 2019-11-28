<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="group", indexes={@ORM\Index(name="fk_group_users1_idx", columns={"id_user"})})
 * @ORM\Entity
 */
class Group
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_group", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroup;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="idGugroup")
     * @ORM\JoinTable(name="group_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_GUgroup", referencedColumnName="id_group")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_GUuser", referencedColumnName="id_user")
     *   }
     * )
     */
    private $idGuuser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idGuuser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idGroup
     *
     * @return integer
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     * Set idUser
     *
     * @param \Alecso\EvenementBundle\Entity\User $idUser
     *
     * @return Group
     */
    public function setIdUser(\Alecso\EvenementBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \Alecso\EvenementBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Add idGuuser
     *
     * @param \Alecso\EvenementBundle\Entity\User $idGuuser
     *
     * @return Group
     */
    public function addIdGuuser(\Alecso\EvenementBundle\Entity\User $idGuuser)
    {
        $this->idGuuser[] = $idGuuser;

        return $this;
    }

    /**
     * Remove idGuuser
     *
     * @param \Alecso\EvenementBundle\Entity\User $idGuuser
     */
    public function removeIdGuuser(\Alecso\EvenementBundle\Entity\User $idGuuser)
    {
        $this->idGuuser->removeElement($idGuuser);
    }

    /**
     * Get idGuuser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdGuuser()
    {
        return $this->idGuuser;
    }
}
