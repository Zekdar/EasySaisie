<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Promotion;

class LoadPromotionsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $promotion1 = new Promotion();
        $promotion1->setName('L3');
        $promotion1->setMinAverageToValidate('5');
        $promotion1->setFormation($this->getReference('formation1')); // TODO fixtures recherche partager objets

        $promotion2 = new Promotion();
        $promotion2->setName('M2');
        $promotion2->setMinAverageToValidate('5');
        $promotion2->setFormation($this->getReference('formation2'));

        $manager->persist($promotion1);
        $manager->persist($promotion2);
        $manager->flush();
		
		$this->addReference('promotion1', $promotion1);
		$this->addReference('promotion2', $promotion2);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}