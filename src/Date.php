<?php

namespace ContactsGrabber;

use Carbon\Carbon;

class Date
{
    const TYPE_BIRTHDAY = 'birthday';

    /**
     * @var string
     */
    protected $type;
    /**
     * @var Carbon
     */
    protected $date;
    /**
     * @var string
     */
    protected $comment; // @todo what for?

    /**
     * Date constructor.
     * @param string $type
     * @param Carbon $date
     * @param string $comment
     */
    public function __construct($type, Carbon $date, $comment = null)
    {
        $this->setType($type);
        $this->setDate($date);
        $this->setComment($comment);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment = null)
    {
        $this->comment = $comment;
    }

}