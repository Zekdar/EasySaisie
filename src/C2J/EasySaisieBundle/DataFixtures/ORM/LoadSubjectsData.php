<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Subject;

class LoadSubjectsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		$subject1=new Subject();
		$subject1->setAbbreviation('ANG');
		$subject1->setName('Anglais');
		
		$subject2=new Subject();
		$subject2->setAbbreviation('AD');
		$subject2->setName('Aide à la décision');
		
		$subject3=new Subject();
		$subject3->setAbbreviation('DRO');
		$subject3->setName('Droit informatique et droit du travail');
	
		$subject4=new Subject();
		$subject4->setAbbreviation('GES');
		$subject4->setName('Gestion Financière et Contrôle de Gestion');
		
		$subject5=new Subject();
		$subject5->setAbbreviation('ALRE');
		$subject5->setName('Algorithmique répartie');
		
		$subject6=new Subject();
		$subject6->setAbbreviation('ISR');
		$subject6->setName('Réseaux avancés');
		
		$subject7=new Subject();
		$subject7->setAbbreviation('GL');
		$subject7->setName('Génie Logiciel');
		
		$subject8=new Subject();
		$subject8->setAbbreviation('URSI');
		$subject8->setName('Urbanisation des Systèmes d’information 1');
		
		$subject9=new Subject();
		$subject9->setAbbreviation('ANDO');
		$subject9->setName('Analyse de données');
		
		$subject10=new Subject();
		$subject10->setAbbreviation('GL2');
		$subject10->setName('Génie Logiciel 2');
		
		$subject11=new Subject();
		$subject11->setAbbreviation('TECHLO');
		$subject11->setName('Technologies Logicielles 1');
		
		$subject12=new Subject();
		$subject12->setAbbreviation('CPAR');
		$subject12->setName('Conception et programmation d’applications réparties');
		
		$subject13=new Subject();
		$subject13->setAbbreviation('CRYPTO');
		$subject13->setName('Cryptologie et Compression');
		
		$subject14=new Subject();
		$subject14->setAbbreviation('BADA');
		$subject14->setName('Bases de données avancées');
		
		$subject15=new Subject();
		$subject15->setAbbreviation('SIGE');
		$subject15->setName('Simulation de gestion dentreprise');
		
		$subject16=new Subject();
		$subject16->setAbbreviation('APP');
		$subject16->setName('Apprentissage');
		
		$subject17=new Subject();
		$subject17->setAbbreviation('PJC');
		$subject17->setName('Projet conception');
		
		$subject18=new Subject();
		$subject18->setAbbreviation('PJI');
		$subject18->setName('Projet implémentation');
		
		
        $manager->persist($subject1);
		$manager->persist($subject2);
		$manager->persist($subject3);
		$manager->persist($subject4);
		$manager->persist($subject5);
		$manager->persist($subject6);
		$manager->persist($subject7);
		$manager->persist($subject8);
		$manager->persist($subject9);
		$manager->persist($subject10);
		$manager->persist($subject11);
		$manager->persist($subject12);
		$manager->persist($subject13);
		$manager->persist($subject14);
		$manager->persist($subject15);
		$manager->persist($subject16);
		$manager->persist($subject17);
		$manager->persist($subject18);
        $manager->flush();
		
		$this->addReference('subject1', $subject1);
		$this->addReference('subject2', $subject2);
		$this->addReference('subject3', $subject3);
		$this->addReference('subject4', $subject4);
		$this->addReference('subject5', $subject5);
		$this->addReference('subject6', $subject6);
		$this->addReference('subject7', $subject7);
		$this->addReference('subject8', $subject8);
		$this->addReference('subject9', $subject9);
		$this->addReference('subject10', $subject10);
		$this->addReference('subject11', $subject11);
		$this->addReference('subject12', $subject12);
		$this->addReference('subject13', $subject13);
		$this->addReference('subject14', $subject14);
		$this->addReference('subject15', $subject15);
		$this->addReference('subject16', $subject16);
		$this->addReference('subject17', $subject17);
		$this->addReference('subject18', $subject18);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}