<?php

namespace ContactsGrabber\Contact;

use ContactsGrabber\Contact;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Phone extends Contact
{
    const TYPE_HOME = 'home';
    const TYPE_MOBILE = 'mobile';
    const TYPE_OTHER = 'other';

    /**
     * @var string|null
     */
    private $possibleCountry;

    /**
     * Phone constructor.
     * @param $value
     * @param null $type
     * @param null $possibleCountry ISO code
     */
    public function __construct($value, $type = null, $possibleCountry = null)
    {
        $this->setValue($value);
        $this->setType($type);
        $this->setPossibleCountry($possibleCountry);
    }

    /**
     * @return null
     */
    public function getPossibleCountry()
    {
        return $this->possibleCountry;
    }

    /**
     * @param null $possibleCountry
     */
    public function setPossibleCountry($possibleCountry)
    {
        $this->possibleCountry = $possibleCountry;
    }

    /**
     * @param string $country ISO code
     * @return null|bool
     * @throws \Exception
     */
    public function isValidNumber($country = null)
    {
        $number = $this->parsePhoneNumber($country);

        if (is_null($number)) {
            return false;
        }

        return $this->getPhoneUtil()->isValidNumber($number);
    }

    public function getFormattedValue($country = null)
    {
        $number = $this->parsePhoneNumber($country);

        if (is_null($number)) {
            return null;
        }

        return $this->getPhoneUtil()->format($number, PhoneNumberFormat::INTERNATIONAL);
    }

    /**
     * @param $country
     * @return \libphonenumber\PhoneNumber
     * @throws \Exception
     */
    protected function parsePhoneNumber($country)
    {
        $phoneUtil = $this->getPhoneUtil();
        $country = $country ?? $this->getPossibleCountry();

        if (is_null($country)) {
            throw new \Exception('Country ISO code is required for phone number formatting');
        }

        try {
            return $phoneUtil->parse($this->getValue(), $country);
        } catch (\libphonenumber\NumberParseException $e) {
            return null;
        }
    }

    private function getPhoneUtil()
    {
        return PhoneNumberUtil::getInstance();
    }

}