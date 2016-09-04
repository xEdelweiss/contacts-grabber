<?php

namespace ContactsGrabber;

class Country
{
    protected $value;
    protected $isIso;

    /**
     * Country constructor.
     * @param string $value
     * @param bool $isIso
     */
    public function __construct($value, $isIso)
    {
        $this->value = $value;
        $this->isIso = $isIso;
    }

}