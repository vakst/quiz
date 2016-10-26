<?php
namespace Words\QuizBundle\Entity;

use Doctrine\ORM\EntityRepository;

class WordRepository extends EntityRepository
{
     /**
     * Get random entity
     *
     * @return Entity
     */
    public function getRandomEntity()
    {
        return  $this->createQueryBuilder('q')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get random entity
     *
     * @return Entity
     */
    public function getNextEntityByUserId($userId, $offset)
    {
        return  $this->createQueryBuilder('q')
            ->addSelect('PseudoRandByParam(q.id, :randomiseId) as HIDDEN sortorder')
            ->setParameter('randomiseId', $userId)
            ->addOrderBy('sortorder')
            ->setFirstResult($offset)           
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get translation for word
     *
     * @return Entity
     */
    public function getTranslationByWordId($wordId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT w FROM WordsQuizBundle:Word w 
                INNER JOIN WordsQuizBundle:Translation t WITH w = t.translation
                WHERE t.word = :wordId
                '
            )
            ->setParameter('wordId', $wordId)
            ->getOneOrNullResult();
    }

    /**
     * Get wrong translation for word
     *
     * @return Entity
     */
    public function getWrongTranslationByWordId($wordId, $languageId, $userId, $limit)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT w, PseudoRandByParam(w.id, :randomiseId) as HIDDEN sortorder FROM WordsQuizBundle:Word w 
                INNER JOIN WordsQuizBundle:Translation t WITH w = t.translation
                WHERE t.word <> :wordId AND w.language = :languageId
                ORDER BY sortorder ASC
                '
            )
            ->setParameter('wordId', $wordId)
            ->setParameter('languageId', $languageId)
            //->addSelect('PseudoRandByParam(q.id, :randomiseId) as HIDDEN sortorder')
            ->setParameter('randomiseId', $userId)
            //->addOrderBy('sortorder')
            ->setFirstResult(0)           
            ->setMaxResults($limit)
            ->getResult();
    }
}