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

	    // $qb = $this ->createQueryBuilder('sp')
	    //             ->select('p.name')
	    //             ->distinct()
	    //             ->addSelect('sp.id')
	    //             ->addSelect('sp.year')
	    //             ->join('sp.promotion', 'p')
	    //             ->orderBy('sp.year', 'DESC')
	    //             ->addOrderBy('p.name', 'ASC');

		return $qb 	->getQuery()
					->getResult();
	}

	public function findAllStudentsInPromotionByYear($promotion_id, $year) 
	{$session= null;
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

	public function findAllStudentsInPromotionByYearBySubject($promotion_id, $year,$subject_id) 
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

	public function findAllStudentsInPromotion($promotion_id, $year) 
	{
		// return $this->createQueryBuilder('sp')
		// 			->join('sp.student', 's')
		// 				->addSelect('s')
		// 			->join('sp.promotion', 'p')
		// 				->addSelect('p')
		// 			->leftJoin('sp.marks', 'm')
		// 				->addSelect('m')
		// 			->leftJoin('tus.marks', 'm')
		// 				->addSelect('tus')
		// 			->join('tus.subject', 'sub')
		// 				->addSelect('sub')
		// 			->join('tus.teachingUnit', 'tu')
		// 				->addSelect('tu')
		// 			->join('tu.container', 'c')
		// 				->addSelect('c')					

		// 			->where('sp.promotion = :promotion_id')
		// 				->setParameter('promotion_id', $promotion_id)
		// 			->andWhere('sp.year = :year')
		// 				->setParameter('year', $year)
		// 			->getQuery()
		// 			->getResult();
	 			
		// $rsm = new ResultSetMapping();
		// $rsm->addEntityResult('C2JEasySaisieBundle:StudentPromotion', 'sp');
		// $rsm->addFieldResult('p', 'id', 'id');
		// $rsm->addFieldResult('p', 'title', 'title');
		 
		// $sql = '
		// 		SELECT 		*  
		// 		FROM 		studentpromotion sp
		// 		JOIN  		student s 				ON (sp.student_id = s.id)
		// 		JOIN 		promotion p 			ON (sp.promotion_id = p.id)
		// 		LEFT JOIN 	mark m 					ON (sp.id = m.studentpromotion_id)
		// 		LEFT JOIN 	teachingunitsubject tus ON (tus.id = m.teachingunitsubject_id)
		// 		JOIN 		subject sub 			ON (sub.id = tus.subject_id)
		// 		JOIN 		teachingunit tu 		ON (tu.id = tus.teachingunit_id)
		// 		JOIN 		container c 			ON (c.id = tu.container_id)
				
		// 		UNION 		
 
		// 		SELECT 		*  
		// 		FROM 		studentpromotion sp
		// 		JOIN  		student s 				ON (sp.student_id = s.id)
		// 		JOIN 		promotion p 			ON (sp.promotion_id = p.id)
		// 		RIGHT JOIN 	mark m 					ON (sp.id = m.studentpromotion_id)
		// 		RIGHT JOIN 	teachingunitsubject tus ON (tus.id = m.teachingunitsubject_id)
		// 		JOIN 		subject sub 			ON (sub.id = tus.subject_id)
		// 		JOIN 		teachingunit tu 		ON (tu.id = tus.teachingunit_id)
		// 		JOIN 		container c 			ON (c.id = tu.container_id)
		// ';
		 
		// $query = $this->_em->createNativeQuery($sql, $rsm);
		// $query->setParameter(1, $idProject);
		 
		// $projects = $query->getResult();
	}
}
