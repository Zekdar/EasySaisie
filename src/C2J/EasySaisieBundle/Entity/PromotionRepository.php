<?php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PromotionRepository extends EntityRepository
{
	public function findAllPromotionsByYearDistinct() 
	{
		$qb = $this ->createQueryBuilder('p')
					->groupBy('p.name')
					->orderBy('p.year', 'DESC')
					->addOrderBy('p.name', 'ASC');

		return $qb 	->getQuery()
					->getResult();
	}

	public function findAllSubjectsByTucsByContainerByPromotionByYear($promotion_id, $year) 
	{
		return $this->createQueryBuilder('p')
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
					
	}
	
	public function getPromotions($promotionId = null)
	{	
		$queryBuilder = $this->createQueryBuilder('p');
        if($promotionId != null)
        {
            $queryBuilder->andWhere('p.id = :promotionId')
            ->setParameter('promotionId', $promotionId);
        }
        return $queryBuilder;;
	}
	/*
	public function findAllSubjectsByTusByContainerByPromotionByYear($promotion_id, $year) 
	{
		return $this->createQueryBuilder('p')
					->join('p.containers', 'c')
						->addSelect('c')
					->join('p.studentPromotions', 'sp')
						->addSelect('sp')
					->join('c.teachingUnits', 'tu')
						->addSelect('tu')
					->join('tu.teachingUnitSubjects', 'tus')
						->addSelect('tus')
					->join('tus.subject', 's')
						->addSelect('s')
					->leftJoin('tus.marks', 'm')
						->addSelect('m')
					->where('p.id = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					->andWhere('p.year = :year')
						->setParameter('year', $year)
					->addOrderBy('tu.code', 'ASC')
					->addOrderBy('s.abbreviation', 'ASC')
					->getQuery()
					->getResult();
	}
	*/
}
