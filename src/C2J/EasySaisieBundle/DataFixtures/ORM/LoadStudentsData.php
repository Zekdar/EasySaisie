<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Student;

class LoadStudentsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		$student1=new Student();
		$student1->setNumber('20112000');
		$student1->setLastName('BENOIT');
		$student1->setFirstName('Philippe');
	
		$student2=new Student();
		$student2->setNumber('20114832');
		$student2->setLastName('BOETCHEVITCH');
		$student2->setFirstName('Jonathan');
		
		$student3=new Student();
		$student3->setNumber('20112002');
		$student3->setLastName('CARVAGLIO');
		$student3->setFirstName('Antony');
		
		$student4=new Student();
		$student4->setNumber('20112003');
		$student4->setLastName('CISSE');
		$student4->setFirstName('Abdoul Karim');
		
		$student5=new Student();
		$student5->setNumber('20112004');
		$student5->setLastName('DAMA');
		$student5->setFirstName('Maimouna');
		
		$student6=new Student();
		$student6->setNumber('20112005');
		$student6->setLastName('DAHALANI');
		$student6->setFirstName('Seny');
		
		$student7=new Student();
		$student7->setNumber('20112006');
		$student7->setLastName('FLEURY');
		$student7->setFirstName('Matthieu');
		
		$student8=new Student();
		$student8->setNumber('20112007');
		$student8->setLastName('HAIRAPIAN');
		$student8->setFirstName('Julien');
		
		$student9=new Student();
		$student9->setNumber('20112008');
		$student9->setLastName('KRAUCH');
		$student9->setFirstName('Nguyen Cuong');
		
		$student10=new Student();
		$student10->setNumber('20112009');
		$student10->setLastName('LAVABRE');
		$student10->setFirstName('Clément');
	
        $manager->persist($student1);
		$manager->persist($student2);
		$manager->persist($student3);
		$manager->persist($student4);
		$manager->persist($student5);
		$manager->persist($student6);
		$manager->persist($student7);
		$manager->persist($student8);
		$manager->persist($student9);
		$manager->persist($student10);
        $manager->flush();
		
		$this->addReference('student1', $student1);
		$this->addReference('student2', $student2);
		$this->addReference('student3', $student3);
		$this->addReference('student4', $student4);
		$this->addReference('student5', $student5);
		$this->addReference('student6', $student6);
		$this->addReference('student7', $student7);
		$this->addReference('student8', $student8);
		$this->addReference('student9', $student9);
		$this->addReference('student10', $student10);
    }
	
	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // l'ordre dans lequel les fichiers sont chargés
    }
}