<?php

namespace BlogJF\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="BlogJF\BlogBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;


    /**
     * Un commentaire a plusieurs commentaires
     * @ORM\OneToMany(targetEntity="BlogJF\BlogBundle\Entity\Commentaire", mappedBy="parentId")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="BlogJF\BlogBundle\Entity\Commentaire", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parentId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="signaler", type="boolean")
     */
    private $signaler;

    /**
     * @ORM\ManyToOne(targetEntity="BlogJF\BlogBundle\Entity\Billet", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billet;


    public function __construct() {
        $this->date = new \Datetime();
        $this->parentId = 0;
        $this->signaler = false;
        $this->children = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return commentaire
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return commentaire
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setBillet(Billet $billet)
    {
        $this->billet = $billet;
    }

    public function getBillet()
    {
        return $this->billet;
    }


    public function setSignaler($signaler)
    {
        $this->signaler = $signaler;
    }

    public function getSignaler()
    {
        return $this->signaler;
    }
}
