<?php

namespace Words\QuizBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $score;

    /**
     * @var integer
     */
    private $currentQuestionOffset;

    /**
     * @var \DateTime
     */
    private $createdDate = 'now()';

    /**
     * @var integer
     */
    private $id;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set score
     *
     * @param integer $score
     *
     * @return User
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set currentQuestionOffset
     *
     * @param integer $currentQuestionOffset
     *
     * @return User
     */
    public function setCurrentQuestionOffset($currentQuestionOffset)
    {
        $this->currentQuestionOffset = $currentQuestionOffset;

        return $this;
    }

    /**
     * Get currentQuestionOffset
     *
     * @return integer
     */
    public function getCurrentQuestionOffset()
    {
        return $this->currentQuestionOffset;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return User
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
}
