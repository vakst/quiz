<?php
namespace Words\QuizBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserTranslationMistakeLogRepository extends EntityRepository
{
     /**
     * Get count of mistakes
     *
     * @return Entity
     */
    public function getMistakeCountByUser($userId)
    {
        return $this->createQueryBuilder('ulog')
            ->select('COUNT(ulog.id)') 
            ->where('ulog.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}