<?php

namespace ContactsGrabber;

use ContactsGrabber\Driver\AbstractDriver;

class Grabber
{
    /**
     * @var AbstractDriver
     */
    private $driver;

    /**
     * Grabber constructor.
     * @param AbstractDriver $driver
     */
    public function __construct(AbstractDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return Metacontact[]
     */
    public function fetchContacts()
    {
        return $this->driver->fetchContacts();
    }
}