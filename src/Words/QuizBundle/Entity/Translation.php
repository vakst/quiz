<?php

namespace Words\QuizBundle\Entity;

/**
 * Translation
 */
class Translation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Words\QuizBundle\Entity\Word
     */
    private $translation;

    /**
     * @var \Words\QuizBundle\Entity\Word
     */
    private $word;


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
     * Set translation
     *
     * @param \Words\QuizBundle\Entity\Word $translation
     *
     * @return Translation
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
     * @return Translation
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
