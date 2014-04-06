<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Formation;

class LoadFormationsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $formation1 = new Formation();
        $formation1->setName('MIAGE');
        $formation1->setType('Initiale');

        $formation2 = new Formation();
        $formation2->setName('ASR');
        $formation2->setType('Apprentissage');

        $manager->persist($formation1);
        $manager->persist($formation2);
        $manager->flush();
		
		$this->addReference('formation1', $formation1);
		$this->addReference('formation2', $formation2);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}