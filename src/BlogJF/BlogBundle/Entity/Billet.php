<?php

namespace BlogJF\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="BlogJF\BlogBundle\Repository\BilletRepository")
 */
class Billet
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="roman", type="text")
     * @Assert\Length(min=1, minMessage="L'article ne peut pas être vide")
     */
    private $roman;

    /**
     * @ORM\OneToMany(targetEntity="BlogJF\BlogBundle\Entity\Commentaire", mappedBy="billet", cascade={"persist"})
     *
     */
    private $commentaires;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;


    public function __construct() {
        $this->date = new \Datetime();
        $this->commentaires = new ArrayCollection();
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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return billet
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
     * Set titre
     *
     * @param string $titre
     *
     * @return billet
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set roman
     *
     * @param string $roman
     *
     * @return billet
     */
    public function setRoman($roman)
    {
        $this->roman = $roman;

        return $this;
    }

    /**
     * Get roman
     *
     * @return string
     */
    public function getRoman()
    {
        return $this->roman;
    }

    public function addCommentaire(Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;
        $commentaire->setBillet($this);
        return $this;
    }

    public function removeCommentaire (Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * @return Commentaire[]
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param bool $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }
}

