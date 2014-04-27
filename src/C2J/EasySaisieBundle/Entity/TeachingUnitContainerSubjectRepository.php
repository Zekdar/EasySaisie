<?php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeachingUnitContainerSubjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeachingUnitContainerSubjectRepository extends EntityRepository
{
	public function findAllTucsByPromotionId($promotion_id) 
	{
		return $this->createQueryBuilder('tucs')
					->join('tucs.teachingUnitContainer', 'tuc')
						->addSelect('tuc')
					->join('tuc.container', 'c')
						->addSelect('c')
					->where('c.promotion = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					//->addOrderBy('tu.code', 'ASC')
					//->addOrderBy('s.abbreviation', 'ASC')
					->getQuery()
					->getResult();
					/*
					->join('p.containers', 'c')
						->addSelect('c')
					->join('p.studentPromotions', 'sp')
						->addSelect('sp')
					->join('c.teachingUnitContainers', 'tuc')
						->addSelect('tuc')
					->join('tuc.teachingUnit', 'tu')
						->addSelect('tu')
					->leftjoin('tuc.teachingUnitContainerSubjects', 'tucs')
						->addSelect('tucs')		
					->leftjoin('tucs.subject', 's')
						->addSelect('s')
					->leftJoin('tucs.marks', 'm')
						->addSelect('m')
					->where('p.id = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					->andWhere('p.year = :year')
						->setParameter('year', $year)
					->addOrderBy('tu.code', 'ASC')
					->addOrderBy('s.abbreviation', 'ASC')
					->getQuery()
					->getResult();
					*/
					
	}
}
