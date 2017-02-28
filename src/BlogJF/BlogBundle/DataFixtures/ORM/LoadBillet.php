<?php

namespace BlogJF\BlogBundle\DataFixtures\ORM;

use BlogJF\BlogBundle\Entity\Billet;
use BlogJF\BlogBundle\Entity\Commentaire;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBillet implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tab = array(
            array('date' => new \DateTime() , 'titre' => 'Chapitre 1',
                'roman' => 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?'),
            array('date' => new \DateTime() , 'titre' => 'Chapitre 2',
                'roman' => 'Dum apud Persas, ut supra narravimus, perfidia regis motus agitat insperatos, et in eois tractibus bella rediviva consurgunt, anno sexto decimo et eo diutius post Nepotiani exitium, saeviens per urbem aeternam urebat cuncta Bellona, ex primordiis minimis ad clades excita luctuosas, quas obliterasset utinam iuge silentium! ne forte paria quandoque temptentur, plus exemplis generalibus nocitura quam delictis.'),
            array('date' => new \DateTime() , 'titre' => 'Chapitre 3',
                'roman' => 'Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.'),
            array('date' => new \DateTime() , 'titre' => 'Chapitre 4',
                'roman' => 'Sed fruatur sane hoc solacio atque hanc insignem ignominiam, quoniam uni praeter se inusta sit, putet esse leviorem, dum modo, cuius exemplo se consolatur, eius exitum expectet, praesertim cum in Albucio nec Pisonis libidines nec audacia Gabini fuerit ac tamen hac una plaga conciderit, ignominia senatus.'),
            array('date' => new \DateTime() , 'titre' => 'Chapitre 5',
                'roman' => 'Et interdum acciderat, ut siquid in penetrali secreto nullo citerioris vitae ministro praesente paterfamilias uxori susurrasset in aurem, velut Amphiarao referente aut Marcio, quondam vatibus inclitis, postridie disceret imperator. ideoque etiam parietes arcanorum soli conscii timebantur.'),
        );

        foreach ($tab as $billets) {
            $billet = new Billet();
            $billet->setDate($billets['date']);
            $billet->setTitre($billets['titre']);
            $billet->setRoman($billets['roman']);

            $manager->persist($billet);
       };
        $manager->flush();
    }
}