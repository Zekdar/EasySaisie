<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Container;

class LoadContainersData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $container1 = new Container();
        $container1->setName('Semestre 1');
        $container1->setPromotion($this->getReference('promotion1')); // TODO fixtures recherche partager objets

        $container2 = new Container();
        $container2->setName('Semestre 2');
        $container2->setPromotion($this->getReference('promotion1'));
		
		$container3 = new Container();
        $container3->setName('Semestre 1');
        $container3->setPromotion($this->getReference('promotion2'));
		
		$container4 = new Container();
        $container4->setName('Semestre 2');
        $container4->setPromotion($this->getReference('promotion2'));

        $manager->persist($container1);
        $manager->persist($container2);
		$manager->persist($container3);
		$manager->persist($container4);
        $manager->flush();
		
		$this->addReference('container1', $container1);
		$this->addReference('container2', $container2);
		$this->addReference('container3', $container3);
		$this->addReference('container4', $container4);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // l'ordre dans lequel les fichiers sont chargés
    }
}