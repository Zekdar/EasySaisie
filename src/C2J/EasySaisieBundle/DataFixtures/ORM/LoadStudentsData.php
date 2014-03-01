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
		$student1->setAddress('1 rue Jules Vallès');
		$student1->setZipCode('91000');
		$student1->setCity('Evry');
		$student1->setPhone('0659965222');
		$student1->setEmail('angelo.benoit@laposte.net');
		$student1->setBirthDate('2014-03-01');
	
		$student2=new Student();
		$student2->setNumber('20114832');
		$student2->setLastName('BOETCHEVITCH');
		$student2->setFirstName('Jonathan');
		$student2->setAddress('6 place Guillaume Apollinaire');
		$student2->setZipCode('77176');
		$student2->setCity('Savigny le Temple');
		$student2->setPhone('0637226914');
		$student2->setEmail('jonathan.boet@gmail.com');
		$student2->setBirthDate('2014-03-01');
		
		$student3=new Student();
		$student3->setNumber('20112002');
		$student3->setLastName('CARVAGLIO');
		$student3->setFirstName('Antony');
		$student3->setAddress('1 rue des oliviers');
		$student3->setZipCode('91160');
		$student3->setCity('Longjumeau');
		$student3->setPhone('0662955304');
		$student3->setEmail('antony.carvaglio@gmail.com');
		$student3->setBirthDate('2014-03-01');
		
		$student4=new Student();
		$student4->setNumber('20112003');
		$student4->setLastName('CISSE');
		$student4->setFirstName('Abdoul Karim');
		$student4->setAddress('12 rue de la balance');
		$student4->setZipCode('91350');
		$student4->setCity('Grigny');
		$student4->setPhone('0640566060');
		$student4->setEmail('cisse.abdoulkarim@gmail.com');
		$student4->setBirthDate('2014-03-01');
		
		$student5=new Student();
		$student5->setNumber('20112004');
		$student5->setLastName('DAMA');
		$student5->setFirstName('Maimouna');
		$student5->setAddress('19 impasse clos bellevue');
		$student5->setZipCode('91100');
		$student5->setCity('Corbeil Essonne');
		$student5->setPhone('0672656906');
		$student5->setEmail('maimouna.dama@yahoo.fr');
		$student5->setBirthDate('2014-03-01');
		
		$student6=new Student();
		$student6->setNumber('20112005');
		$student6->setLastName('DAHALANI');
		$student6->setFirstName('Seny');
		$student6->setAddress('18 avenue de la concorde');
		$student6->setZipCode('91270');
		$student6->setCity('Vigneux sur Seine');
		$student6->setPhone('0663593151');
		$student6->setEmail('sdahalani@gmail.com');
		$student6->setBirthDate('2014-03-01');
		
		$student7=new Student();
		$student7->setNumber('20112006');
		$student7->setLastName('FLEURY');
		$student7->setFirstName('Matthieu');
		$student7->setAddress('28 rue de la ferté alais');
		$student7->setZipCode('77930');
		$student7->setCity('St Germain/Ecole');
		$student7->setPhone('0640745345');
		$student7->setEmail('matthieu77930@hotmail.fr');
		$student7->setBirthDate('2014-03-01');
		
		$student8=new Student();
		$student8->setNumber('20112007');
		$student8->setLastName('HAIRAPIAN');
		$student8->setFirstName('Julien');
		$student8->setAddress('Bat B2 Résidence Les Millepertuis');
		$student8->setZipCode('91940');
		$student8->setCity('Les Ulis');
		$student8->setPhone('0646426352');
		$student8->setEmail('julien.hairapian@gmail.com');
		$student8->setBirthDate('2014-03-01');
		
		$student9=new Student();
		$student9->setNumber('20112008');
		$student9->setLastName('KRAUCH');
		$student9->setFirstName('Nguyen Cuong');
		$student9->setAddress('26 rue Marx Dormoy');
		$student9->setZipCode('75018');
		$student9->setCity('Paris');
		$student9->setPhone('0675516444');
		$student9->setEmail('nc.krauch@gmail.com');
		$student9->setBirthDate('2014-03-01');
		
		$student10=new Student();
		$student10->setNumber('20112009');
		$student10->setLastName('LAVABRE');
		$student10->setFirstName('Clément');
		$student10->setAddress('1 rue des folies');
		$student10->setZipCode('77250');
		$student10->setCity('Moret/Loing');
		$student10->setPhone('0652323168');
		$student10->setEmail('clement-lavabre@hotmail.fr');
		$student10->setBirthDate('2014-03-01');
	
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