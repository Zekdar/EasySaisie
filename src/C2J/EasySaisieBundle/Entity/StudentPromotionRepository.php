<?php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StudentPromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentPromotionRepository extends EntityRepository
{
	public function findAllPromotionsByYearDistinct() 
	{
		$qb = $this ->createQueryBuilder('sp')
					->join('sp.promotion', 'p')
						->addSelect('p')
					->groupBy('p.name')
					->orderBy('p.year', 'DESC')
					->addOrderBy('p.name', 'ASC');

		return $qb 	->getQuery()
					->getResult();
	}

	public function findAllStudentsInPromotionByYear($promotion_id, $year) 
	{
		$qb = $this ->createQueryBuilder('sp')
					->join('sp.student', 's')
						->addSelect('s')
					->leftJoin('sp.marks', 'm')
						->addSelect('m')
					->join('sp.promotion', 'p')
						->addSelect('p')
					->where('sp.promotion = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					->andWhere('p.year = :year')
						->setParameter('year', $year)
					->addOrderBy('s.lastName', 'ASC');
		
		return $qb 	->getQuery()
					->getResult();
	}

	public function findAllStudentsInPromotionByYearBySubject($promotion_id, $year, $subject_id) 
	{
		$qb = $this ->createQueryBuilder('sp')
					->join('sp.student', 's')
						->addSelect('s')
					->leftJoin('sp.marks', 'm')
						->addSelect('m')
					->join('sp.promotion', 'p')
						->addSelect('p')
					->join('p.containers','c')
						->addSelect('c')
					->join('c.teachingUnitContainers','tuc')
						->addSelect('tuc')
					->join('tuc.teachingUnitContainerSubjects','tucs')
						->addSelect('tucs')
					->join('tucs.subject','sub')
						->addSelect('sub')
					->where('sp.promotion = :promotion_id')
						->setParameter('promotion_id', $promotion_id)
					->andWhere('sub.id = :sub_id')
						->setParameter('sub_id', $subject_id)
					->andWhere('p.year = :year') 
						->setParameter('year', $year)
					->addOrderBy('s.lastName', 'ASC');
		
		return $qb 	->getQuery()
					->getResult();
	}

	public function findAllMarksForTheseStudentsByPromotionByYear($promotion_id, $year, $studentsList)
	{
		if(count($studentsList) > 0) {
			$qb = $this ->createQueryBuilder('sp')
						->join('sp.student', 's')
							->addSelect('s')
						->leftJoin('sp.marks', 'm')
							->addSelect('m')
						->join('sp.promotion', 'p')
							->addSelect('p')
						->where('sp.promotion = :promotion_id')
							->setParameter('promotion_id', $promotion_id)
						->andWhere('p.year = :year')
							->setParameter('year', $year)
						->andWhere('s.number IN (:studentsList)')
							->setParameter('studentsList', $studentsList);
			
			return $qb 	->addOrderBy('s.lastName', 'ASC')
						->getQuery()
						->getResult();
		}
		else {
			return array();
		}
	}
}
