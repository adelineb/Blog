<?php

namespace BlogJF\BlogBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Louvre\BilletterieBundle\Validator as AcmeAssert;

/**
 * Class CommentaireModel
 */
class CommentaireModel
{
    /**
     * @var \integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

       /**
     * @var \string
     */
    private $auteur;

    /**
     * @var \string
     */
    private $commentaire;

    /**
     * @var \integer
     */
    private $parent;

    /**
     * @var \integer
     */
    private $billetId;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setBilletId($billetId)
    {
        $this->billetId = $billetId;

        return $this;
    }

    public function getBilletId()
    {
        return $this->billetId;
    }

    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }
}

