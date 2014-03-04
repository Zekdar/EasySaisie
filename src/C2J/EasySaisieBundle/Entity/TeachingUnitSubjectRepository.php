<?php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeachingUnitSubjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeachingUnitSubjectRepository extends EntityRepository
{
	public function findAllSubjectsByTusByContainerByPromotionByYear($promotion_id, $year) 
	{
		return $this->createQueryBuilder('tus')
					->join('tus.subject', 's')
						->addSelect('s')
					->join('tus.teachingUnit', 'tu')
						->addSelect('tu')
					->join('tu.container', 'c')
						->addSelect('c')
					->join('c.promotion', 'p')
						->addSelect('p')
					->join('p.studentPromotions', 'sp')
						->addSelect('sp')
					->where('p.id = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					->andWhere('sp.year = :year')
						->setParameter('year', $year)
					->addOrderBy('tu.code', 'ASC')
					->getQuery()
					->getResult();
	}
}
