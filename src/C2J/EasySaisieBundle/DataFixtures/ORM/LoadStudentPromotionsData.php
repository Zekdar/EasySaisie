<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\StudentPromotion;

class LoadStudentPromotionsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		$studentPromotion1=new StudentPromotion();
		$studentPromotion1->setStudent($this->getReference('student1'));
		$studentPromotion1->setPromotion($this->getReference('promotion1'));

		$studentPromotion2=new StudentPromotion();
		$studentPromotion2->setStudent($this->getReference('student2'));
		$studentPromotion2->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion3=new StudentPromotion();
		$studentPromotion3->setStudent($this->getReference('student3'));
		$studentPromotion3->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion4=new StudentPromotion();
		$studentPromotion4->setStudent($this->getReference('student4'));
		$studentPromotion4->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion5=new StudentPromotion();
		$studentPromotion5->setStudent($this->getReference('student5'));
		$studentPromotion5->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion6=new StudentPromotion();
		$studentPromotion6->setStudent($this->getReference('student6'));
		$studentPromotion6->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion7=new StudentPromotion();
		$studentPromotion7->setStudent($this->getReference('student7'));
		$studentPromotion7->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion8=new StudentPromotion();
		$studentPromotion8->setStudent($this->getReference('student8'));
		$studentPromotion8->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion9=new StudentPromotion();
		$studentPromotion9->setStudent($this->getReference('student9'));
		$studentPromotion9->setPromotion($this->getReference('promotion1'));
		
		$studentPromotion10=new StudentPromotion();
		$studentPromotion10->setStudent($this->getReference('student10'));
		$studentPromotion10->setPromotion($this->getReference('promotion1'));
		
        $manager->persist($studentPromotion1);
		$manager->persist($studentPromotion2);
		$manager->persist($studentPromotion3);
		$manager->persist($studentPromotion4);
		$manager->persist($studentPromotion5);
		$manager->persist($studentPromotion6);
		$manager->persist($studentPromotion7);
		$manager->persist($studentPromotion8);
		$manager->persist($studentPromotion9);
		$manager->persist($studentPromotion10);
        $manager->flush();
		
		$this->addReference('studentPromotion1', $studentPromotion1);
		$this->addReference('studentPromotion2', $studentPromotion2);
		$this->addReference('studentPromotion3', $studentPromotion3);
		$this->addReference('studentPromotion4', $studentPromotion4);
		$this->addReference('studentPromotion5', $studentPromotion5);
		$this->addReference('studentPromotion6', $studentPromotion6);
		$this->addReference('studentPromotion7', $studentPromotion7);
		$this->addReference('studentPromotion8', $studentPromotion8);
		$this->addReference('studentPromotion9', $studentPromotion9);
		$this->addReference('studentPromotion10', $studentPromotion10);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}