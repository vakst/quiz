<?php

namespace Words\QuizBundle\Entity;

/**
 * Word
 */
class Word
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Words\QuizBundle\Entity\Language
     */
    private $language;

    /**
     * @var array
     */
    private $answerList;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Word
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Set language
     *
     * @param \Words\QuizBundle\Entity\Language $language
     *
     * @return Word
     */
    public function setLanguage(\Words\QuizBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Words\QuizBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set answer list
     *
     * @param array $list
     *
     * @return Word
     */
    public function setAnswerList($name)
    {
        $this->answerList = $answerList;

        return $this;
    }

    /**
     * Get answer list
     *
     * @return array
     */
    public function getAnswerList()
    {
        return $this->answerList;
    }
}
