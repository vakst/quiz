<?php

namespace Words\QuizBundle\Entity;

/**
 * UserTranslationMistakeLog
 */
class UserTranslationMistakeLog
{
    /**
     * @var \DateTime
     */
    private $createdDate = 'now()';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Words\QuizBundle\Entity\User
     */
    private $user;

    /**
     * @var \Words\QuizBundle\Entity\Word
     */
    private $translation;

    /**
     * @var \Words\QuizBundle\Entity\Word
     */
    private $word;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }


    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return UserTranslationMistakeLog
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \Words\QuizBundle\Entity\User $user
     *
     * @return UserTranslationMistakeLog
     */
    public function setUser(\Words\QuizBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Words\QuizBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set translation
     *
     * @param \Words\QuizBundle\Entity\Word $translation
     *
     * @return UserTranslationMistakeLog
     */
    public function setTranslation(\Words\QuizBundle\Entity\Word $translation = null)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return \Words\QuizBundle\Entity\Word
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set word
     *
     * @param \Words\QuizBundle\Entity\Word $word
     *
     * @return UserTranslationMistakeLog
     */
    public function setWord(\Words\QuizBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \Words\QuizBundle\Entity\Word
     */
    public function getWord()
    {
        return $this->word;
    }
}
