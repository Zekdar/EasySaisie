<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\TeachingUnitSubject;

class LoadTeachingUnitSubjectsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		$teachingUnitSubject1=new TeachingUnitSubject();
		$teachingUnitSubject1->setCoeff('3');	
		$teachingUnitSubject1->setEcts('3');
		$teachingUnitSubject1->setSubject($this->getReference('subject2'));
		$teachingUnitSubject1->setTeachingUnit($this->getReference('teachingUnit2'));
		
		$teachingUnitSubject2=new TeachingUnitSubject();
		$teachingUnitSubject2->setCoeff('3');
		$teachingUnitSubject2->setEcts('3');
		$teachingUnitSubject2->setSubject($this->getReference('subject3'));
		$teachingUnitSubject2->setTeachingUnit($this->getReference('teachingUnit3'));
		
		$teachingUnitSubject3=new TeachingUnitSubject();
		$teachingUnitSubject3->setCoeff('3');
		$teachingUnitSubject3->setEcts('3');
		$teachingUnitSubject3->setSubject($this->getReference('subject4'));
		$teachingUnitSubject3->setTeachingUnit($this->getReference('teachingUnit3'));
		
		$teachingUnitSubject4=new TeachingUnitSubject();
		$teachingUnitSubject4->setCoeff('4');
		$teachingUnitSubject4->setEcts('4');
		$teachingUnitSubject4->setSubject($this->getReference('subject5'));
		$teachingUnitSubject4->setTeachingUnit($this->getReference('teachingUnit4'));
		
		$teachingUnitSubject5=new TeachingUnitSubject();
		$teachingUnitSubject5->setCoeff('4');
		$teachingUnitSubject5->setEcts('4');
		$teachingUnitSubject5->setSubject($this->getReference('subject6'));
		$teachingUnitSubject5->setTeachingUnit($this->getReference('teachingUnit4'));
		
		$teachingUnitSubject6=new TeachingUnitSubject();
		$teachingUnitSubject6->setCoeff('3');
		$teachingUnitSubject6->setEcts('3');
		$teachingUnitSubject6->setSubject($this->getReference('subject7'));
		$teachingUnitSubject6->setTeachingUnit($this->getReference('teachingUnit5'));
		
		$teachingUnitSubject7=new TeachingUnitSubject();
		$teachingUnitSubject7->setCoeff('3');
		$teachingUnitSubject7->setEcts('3');
		$teachingUnitSubject7->setSubject($this->getReference('subject8'));
		$teachingUnitSubject7->setTeachingUnit($this->getReference('teachingUnit6'));
		
		$teachingUnitSubject8=new TeachingUnitSubject();
		$teachingUnitSubject8->setCoeff('3');
		$teachingUnitSubject8->setEcts('3');
		$teachingUnitSubject8->setSubject($this->getReference('subject9'));
		$teachingUnitSubject8->setTeachingUnit($this->getReference('teachingUnit7'));
		
		$teachingUnitSubject9=new TeachingUnitSubject();
		$teachingUnitSubject9->setCoeff('4');
		$teachingUnitSubject9->setEcts('4');
		$teachingUnitSubject9->setSubject($this->getReference('subject10'));
		$teachingUnitSubject9->setTeachingUnit($this->getReference('teachingUnit9'));
		
		$teachingUnitSubject10=new TeachingUnitSubject();
		$teachingUnitSubject10->setCoeff('4');
		$teachingUnitSubject10->setEcts('4');
		$teachingUnitSubject10->setSubject($this->getReference('subject11'));
		$teachingUnitSubject10->setTeachingUnit($this->getReference('teachingUnit9'));
		
		$teachingUnitSubject11=new TeachingUnitSubject();
		$teachingUnitSubject11->setCoeff('3');
		$teachingUnitSubject11->setEcts('3');
		$teachingUnitSubject11->setSubject($this->getReference('subject12'));
		$teachingUnitSubject11->setTeachingUnit($this->getReference('teachingUnit8'));
		
		$teachingUnitSubject12=new TeachingUnitSubject();
		$teachingUnitSubject12->setCoeff('3');
		$teachingUnitSubject12->setEcts('3');
		$teachingUnitSubject12->setSubject($this->getReference('subject13'));
		$teachingUnitSubject12->setTeachingUnit($this->getReference('teachingUnit8'));
		
		$teachingUnitSubject13=new TeachingUnitSubject();
		$teachingUnitSubject13->setCoeff('2');
		$teachingUnitSubject13->setEcts('3');
		$teachingUnitSubject13->setSubject($this->getReference('subject14'));
		$teachingUnitSubject13->setTeachingUnit($this->getReference('teachingUnit10'));
		
		$teachingUnitSubject14=new TeachingUnitSubject();
		$teachingUnitSubject14->setCoeff('3');
		$teachingUnitSubject14->setEcts('3');
		$teachingUnitSubject14->setSubject($this->getReference('subject15'));
		$teachingUnitSubject14->setTeachingUnit($this->getReference('teachingUnit11'));
		
		$teachingUnitSubject15=new TeachingUnitSubject();
		$teachingUnitSubject15->setCoeff('6');
		$teachingUnitSubject15->setEcts('6');
		$teachingUnitSubject15->setSubject($this->getReference('subject16'));
		$teachingUnitSubject15->setTeachingUnit($this->getReference('teachingUnit12'));
		
		$teachingUnitSubject16=new TeachingUnitSubject();
		$teachingUnitSubject16->setCoeff('3');
		$teachingUnitSubject16->setEcts('3');
		$teachingUnitSubject16->setSubject($this->getReference('subject17'));
		$teachingUnitSubject16->setTeachingUnit($this->getReference('teachingUnit5'));
		
		$teachingUnitSubject17=new TeachingUnitSubject();
		$teachingUnitSubject17->setCoeff('2');
		$teachingUnitSubject17->setEcts('3');
		$teachingUnitSubject17->setSubject($this->getReference('subject18'));
		$teachingUnitSubject17->setTeachingUnit($this->getReference('teachingUnit10'));
		
		$teachingUnitSubject18=new TeachingUnitSubject();
		$teachingUnitSubject18->setCoeff('3');
		$teachingUnitSubject18->setEcts('3');
		$teachingUnitSubject18->setSubject($this->getReference('subject1'));
		$teachingUnitSubject18->setTeachingUnit($this->getReference('teachingUnit1'));
		
        $manager->persist($teachingUnitSubject1);
		$manager->persist($teachingUnitSubject2);
		$manager->persist($teachingUnitSubject3);
		$manager->persist($teachingUnitSubject4);
		$manager->persist($teachingUnitSubject5);
		$manager->persist($teachingUnitSubject6);
		$manager->persist($teachingUnitSubject7);
		$manager->persist($teachingUnitSubject8);
		$manager->persist($teachingUnitSubject9);
		$manager->persist($teachingUnitSubject10);
		$manager->persist($teachingUnitSubject11);
		$manager->persist($teachingUnitSubject12);
		$manager->persist($teachingUnitSubject13);
		$manager->persist($teachingUnitSubject14);
		$manager->persist($teachingUnitSubject15);
		$manager->persist($teachingUnitSubject16);
        $manager->flush();
		
		$this->addReference('teachingUnitSubject1', $teachingUnitSubject1);
		$this->addReference('teachingUnitSubject2', $teachingUnitSubject2);
		$this->addReference('teachingUnitSubject3', $teachingUnitSubject3);
		$this->addReference('teachingUnitSubject4', $teachingUnitSubject4);
		$this->addReference('teachingUnitSubject5', $teachingUnitSubject5);
		$this->addReference('teachingUnitSubject6', $teachingUnitSubject6);
		$this->addReference('teachingUnitSubject7', $teachingUnitSubject7);
		$this->addReference('teachingUnitSubject8', $teachingUnitSubject8);
		$this->addReference('teachingUnitSubject9', $teachingUnitSubject9);
		$this->addReference('teachingUnitSubject10', $teachingUnitSubject10);
		$this->addReference('teachingUnitSubject11', $teachingUnitSubject11);
		$this->addReference('teachingUnitSubject12', $teachingUnitSubject12);
		$this->addReference('teachingUnitSubject13', $teachingUnitSubject13);
		$this->addReference('teachingUnitSubject14', $teachingUnitSubject14);
		$this->addReference('teachingUnitSubject15', $teachingUnitSubject15);
		$this->addReference('teachingUnitSubject16', $teachingUnitSubject16);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6; // l'ordre dans lequel les fichiers sont chargés
    }
}