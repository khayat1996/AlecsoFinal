<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_admin", referencedColumnName="id_user")
     * })
     */
    private $idAdmin;



    /**
     * Set idAdmin
     *
     * @param \Alecso\EvenementBundle\Entity\User $idAdmin
     *
     * @return Admin
     */
    public function setIdAdmin(\Alecso\EvenementBundle\Entity\User $idAdmin)
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    /**
     * Get idAdmin
     *
     * @return \Alecso\EvenementBundle\Entity\User
     */
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }
}
