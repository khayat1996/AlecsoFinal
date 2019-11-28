<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moderateur
 *
 * @ORM\Table(name="moderateur")
 * @ORM\Entity
 */
class Moderateur
{
    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_moderateur", referencedColumnName="id_user")
     * })
     */
    private $idModerateur;



    /**
     * Set idModerateur
     *
     * @param \Alecso\EvenementBundle\Entity\User $idModerateur
     *
     * @return Moderateur
     */
    public function setIdModerateur(\Alecso\EvenementBundle\Entity\User $idModerateur)
    {
        $this->idModerateur = $idModerateur;

        return $this;
    }

    /**
     * Get idModerateur
     *
     * @return \Alecso\EvenementBundle\Entity\User
     */
    public function getIdModerateur()
    {
        return $this->idModerateur;
    }
}
