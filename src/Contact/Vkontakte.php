<?php

namespace ContactsGrabber\Contact;

use ContactsGrabber\Contact;
use ContactsGrabber\Utils;

class Vkontakte extends Contact
{
    /**
     * @var string
     */
    protected $apiDomain = 'https://api.vk.com/';

    /**
     * Vkontakte constructor.
     */
    public function __construct($userId)
    {
        $this->setValue($userId);
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        $data = Utils::makeJsonRequest($this->apiDomain . 'method/users.get?' . http_build_query([
           'user_ids' => $this->getValue(),
            'fields' => 'domain',
        ]));

        return Utils::getFromArray($data, 'response.0.domain');
    }
}