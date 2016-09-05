<?php

namespace ContactsGrabber\Contact;

use ContactsGrabber\Contact;

class Email extends Contact
{
    const TYPE_HOME = 'home';
    const TYPE_OTHER = 'other';

    /**
     * Email constructor.
     * @param $value
     * @param null $type
     */
    public function __construct($value, $type = null)
    {
        $this->setValue($value);
        $this->setType($type);
    }

}