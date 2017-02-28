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
    private $titre;

    /**
     * @var \string
     */
    private $roman;


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
}