<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Formation;

class LoadFormationsData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $licenceMiage = new Formation();
        $licenceMiage->setName('Licence MIAGE');
        $licenceMiage->setType('Initial');

        $masterMiage = new Formation();
        $masterMiage->setName('Master MIAGE');
        $masterMiage->setType('Apprentissage');

        $manager->persist($licenceMiage);
        $manager->persist($masterMiage);
        $manager->flush();
    }
}