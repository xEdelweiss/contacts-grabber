<?php

namespace ContactsGrabber;

class Metacontact
{
    const GENDER_FEMALE = 'female';
    const GENDER_MALE = 'male';

    /**
     * Identifier provided (or not) by driver
     * @var mixed
     */
    protected $sourceId;
    protected $firstName;
    protected $lastName;
    protected $nickName;
    protected $country;
    protected $city;
    protected $photoUrl;
    protected $gender;

    /**
     * @var Date[]
     */
    protected $dates = [];
    /**
     * @var Contact[]
     */
    protected $contacts = [];

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param mixed $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * @return Contact
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param mixed $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param Date $date
     */
    public function addDate(Date $date)
    {
        $this->dates[] = $date;
    }

    /**
     * @return Date[]
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @return mixed
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param mixed $sourceId
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
    }
}