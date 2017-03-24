<?php

namespace BlogJF\BlogBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Louvre\BilletterieBundle\Validator as AcmeAssert;

/**
 * Class BilletModel
 */
class BilletModel
{
     /**
     * @var \string
     */
    private $titre;

    /**
     * @var \string
     * @Assert\NotBlank("Le commentaire ne peut pas être vide")
     */
    private $roman;

    /**
     * @var \boolean
     */
    private $published;


    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setRoman($roman)
    {
        $this->roman = $roman;

        return $this;
    }

    public function getRoman()
    {
        return $this->roman;
    }

    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    public function getPublished()
    {
        return $this->published;
    }
}
