<?php

namespace C2J\EasySaisieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use C2J\EasySaisieBundle\Entity\Rule;

class LoadRulesData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $minMark = new Rule();
        $minMark->setName('Note Minimale');

        $rattrapages = new Rule();
        $rattrapages->setName('Rattrapages');

        $manager->persist($minMark);
        $manager->persist($rattrapages);
        $manager->flush();
    }
}