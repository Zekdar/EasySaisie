<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Promotion;

class LoadFormationsData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $promo1 = new Promotion();
        $promo1->setName('L3I');
        $M2A->setFormation(''); // TODO fixtures recherche partager objets

        $promo2 = new Formation();
        $promo2->setName('M2A');
        $masterMiage->setFormation('');

        $manager->persist($licenceMiage);
        $manager->persist($masterMiage);
        $manager->flush();
    }
}