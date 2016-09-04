<?php

namespace ContactsGrabber;

class Contact
{
    const PHONE = 'phone';
    const PHONE_PURPOSE_HOME = 'phone:home';
    const VKONTAKTE = 'vkontakte';

    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $value;
    /**
     * @var string
     */
    protected $purpose;

    public static function make($type, $value, $purpose = null)
    {
        $contact = new static();

        $contact->setType($type);
        $contact->setValue($value);
        $contact->setPurpose($purpose);

        return $contact;
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @param string $purpose
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
    }

}