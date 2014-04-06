<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\TeachingUnit;

class LoadTeachingUnitsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		$teachingUnit1=new TeachingUnit();
		$teachingUnit1->setName('Apprentissages fondamentaux');
		$teachingUnit1->setCode('71m');
		$teachingUnit1->setIsCompensable(true);
		$teachingUnit1->setContainer($this->getReference('container1'));
		
		$teachingUnit2=new TeachingUnit();
		$teachingUnit2->setName('Mathématiques');
		$teachingUnit2->setCode('72m');
		$teachingUnit2->setIsCompensable(true);
		$teachingUnit2->setContainer($this->getReference('container1'));
		
		$teachingUnit3=new TeachingUnit();
		$teachingUnit3->setName('Droit');
		$teachingUnit3->setCode('73m');
		$teachingUnit3->setIsCompensable(true);
		$teachingUnit3->setContainer($this->getReference('container1'));
		
		$teachingUnit4=new TeachingUnit();
		$teachingUnit4->setName('Réseaux');
		$teachingUnit4->setCode('74m');
		$teachingUnit4->setIsCompensable(true);
		$teachingUnit4->setContainer($this->getReference('container1'));
		
		$teachingUnit5=new TeachingUnit();
		$teachingUnit5->setName('Conception');
		$teachingUnit5->setCode('75m');
		$teachingUnit5->setIsCompensable(true);
		$teachingUnit5->setContainer($this->getReference('container1'));
		
		$teachingUnit6=new TeachingUnit();
		$teachingUnit6->setName('Enseignements d’ouvertures');
		$teachingUnit6->setCode('76m');
		$teachingUnit6->setIsCompensable(true);
		$teachingUnit6->setContainer($this->getReference('container1'));
		
		$teachingUnit7=new TeachingUnit();
		$teachingUnit7->setName('Mathématiques');
		$teachingUnit7->setCode('82m');
		$teachingUnit7->setIsCompensable(true);
		$teachingUnit7->setContainer($this->getReference('container1'));
		
		$teachingUnit8=new TeachingUnit();
		$teachingUnit8->setName('Réseaux et applications');
		$teachingUnit8->setCode('83m');
		$teachingUnit8->setIsCompensable(true);
		$teachingUnit8->setContainer($this->getReference('container1'));
		
		$teachingUnit9=new TeachingUnit();
		$teachingUnit9->setName('Ingénierie Logicielle');
		$teachingUnit9->setCode('84m');
		$teachingUnit9->setIsCompensable(true);
		$teachingUnit9->setContainer($this->getReference('container1'));
		
		$teachingUnit10=new TeachingUnit();
		$teachingUnit10->setName('Bases de données');
		$teachingUnit10->setCode('85m');
		$teachingUnit10->setIsCompensable(true);
		$teachingUnit10->setContainer($this->getReference('container1'));
		
		$teachingUnit11=new TeachingUnit();
		$teachingUnit11->setName('Gestion');
		$teachingUnit11->setCode('86m');
		$teachingUnit11->setIsCompensable(true);
		$teachingUnit11->setContainer($this->getReference('container1'));
		
		$teachingUnit12=new TeachingUnit();
		$teachingUnit12->setName('Apprentissage');
		$teachingUnit12->setCode('87m');
		$teachingUnit12->setIsCompensable(true);
		$teachingUnit12->setContainer($this->getReference('container2'));
		
        $manager->persist($teachingUnit1);
		$manager->persist($teachingUnit2);
		$manager->persist($teachingUnit3);
		$manager->persist($teachingUnit4);
		$manager->persist($teachingUnit5);
		$manager->persist($teachingUnit6);
		$manager->persist($teachingUnit7);
		$manager->persist($teachingUnit8);
		$manager->persist($teachingUnit9);
		$manager->persist($teachingUnit10);
		$manager->persist($teachingUnit11);
		$manager->persist($teachingUnit12);
        $manager->flush();
		
		$this->addReference('teachingUnit1', $teachingUnit1);
		$this->addReference('teachingUnit2', $teachingUnit2);
		$this->addReference('teachingUnit3', $teachingUnit3);
		$this->addReference('teachingUnit4', $teachingUnit4);
		$this->addReference('teachingUnit5', $teachingUnit5);
		$this->addReference('teachingUnit6', $teachingUnit6);
		$this->addReference('teachingUnit7', $teachingUnit7);
		$this->addReference('teachingUnit8', $teachingUnit8);
		$this->addReference('teachingUnit9', $teachingUnit9);
		$this->addReference('teachingUnit10', $teachingUnit10);
		$this->addReference('teachingUnit11', $teachingUnit11);
		$this->addReference('teachingUnit12', $teachingUnit12);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}