<?php

namespace Alecso\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_messages_users_idx", columns={"envoyeur"}), @ORM\Index(name="fk_messages_users1_idx", columns={"recepteur"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_msg", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMsg;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi", type="datetime", nullable=true)
     */
    private $dateEnvoi = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="envoyeur", referencedColumnName="id_user")
     * })
     */
    private $envoyeur;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recepteur", referencedColumnName="id_user")
     * })
     */
    private $recepteur;



    /**
     * Get idMsg
     *
     * @return integer
     */
    public function getIdMsg()
    {
        return $this->idMsg;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return Message
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Message
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
     * Set envoyeur
     *
     * @param \Alecso\EvenementBundle\Entity\User $envoyeur
     *
     * @return Message
     */
    public function setEnvoyeur(\Alecso\EvenementBundle\Entity\User $envoyeur = null)
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    /**
     * Get envoyeur
     *
     * @return \Alecso\EvenementBundle\Entity\User
     */
    public function getEnvoyeur()
    {
        return $this->envoyeur;
    }

    /**
     * Set recepteur
     *
     * @param \Alecso\EvenementBundle\Entity\User $recepteur
     *
     * @return Message
     */
    public function setRecepteur(\Alecso\EvenementBundle\Entity\User $recepteur = null)
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    /**
     * Get recepteur
     *
     * @return \Alecso\EvenementBundle\Entity\User
     */
    public function getRecepteur()
    {
        return $this->recepteur;
    }
}
