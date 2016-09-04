<?php

namespace ContactsGrabber\Driver;

abstract class AbstractDriver
{
    abstract public function fetchContacts();
}