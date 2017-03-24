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
     * @var \string
     */
    private $auteur;

    /**
     * @var \string
     * @Assert\NotBlank("Le commentaire ne peut pas être vide")
     */
    private $commentaire;


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

}
