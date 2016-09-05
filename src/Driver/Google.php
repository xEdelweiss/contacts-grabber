<?php

namespace ContactsGrabber\Driver;

use ContactsGrabber\AuthFlow\OAuthInterface;
use ContactsGrabber\Contact\Email;
use ContactsGrabber\Contact\Phone;
use ContactsGrabber\Metacontact;
use ContactsGrabber\Utils;
use SimpleXMLElement;

class Google extends AbstractDriver implements OAuthInterface
{
    /**
     * @var null
     */
    protected $clientId;
    /**
     * @var null
     */
    protected $clientSecret;
    /**
     * @var null
     */
    protected $redirectUrl;
    /**
     * @var string
     */
    protected $scope;
    /**
     * @var string
     */
    protected $responseType;
    /**
     * @var string
     */
    protected $code;
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * Google constructor.
     *
     * @param null $clientId
     * @param null $clientSecret
     * @param null $redirectUrl
     * @param string $scope
     * @param string $responseType
     */
    public function __construct($clientId = null, $clientSecret = null, $redirectUrl = null, $scope = \Google_Service_People::CONTACTS_READONLY, $responseType = 'code')
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUrl($redirectUrl);
        $this->setScope($scope);
        $this->setResponseType($responseType);
    }

    public function fetchContacts()
    {
        $accessToken = $this->getAccessToken();

        if (is_null($accessToken)) {
            throw new \Exception('Unauthorized. Access Token is required');
        }

        $client = new \Google_Client();
        $client->setAccessToken($accessToken);

        $httpClient = $client->authorize();
        $response = $httpClient->request('GET', 'https://www.google.com/m8/feeds/contacts/default/full?max-results=10000&updated-min=2007-03-16T00:00:00');

        $xml = simplexml_load_string((string)$response->getBody());
        $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');

        return $this->responseToEntities($xml->entry);
    }

    /*
     * OAuthInterface implementation
     */

    public function getAuthorizationRequestUrl($clientId = null, $redirectUrl = null, $scope = null, $responseType = null) : string
    {
        $clientId = $clientId ?: $this->getClientId();
        $redirectUrl = $redirectUrl ?: $this->getRedirectUrl();
        $scope = $scope ?: $this->getScope();

        $this->setRedirectUrl($redirectUrl);

        $client = new \Google_Client();
        $client->setClientId($clientId);
        $client->setRedirectUri($redirectUrl);
        $client->addScope($scope);
        return $client->createAuthUrl();
    }

    public function setAuthorizationGrantCode($code)
    {
        $this->code = $code;
    }

    public function getAuthorizationGrantCode()
    {
        return $this->code;
    }

    public function fetchAccessToken($code = null, $clientId = null, $clientSecret = null, $redirectUrl = null)
    {
        $code = $code ?: $this->getAuthorizationGrantCode();

        if (is_null($code)) {
            throw new \Exception('Authorization Grant code is required');
        }

        $clientId = $clientId ?: $this->getClientId();
        $clientSecret = $clientSecret ?: $this->getClientSecret();
        $redirectUrl = $redirectUrl ?: $this->getRedirectUrl();

        $client = new \Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        return $client->fetchAccessTokenWithAuthCode($code);
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /*
     * Getter/Setters
     */

    /**
     * @return null
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param null $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return null
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param null $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return null
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param null $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope(string $scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @param string $responseType
     */
    public function setResponseType(string $responseType)
    {
        $this->responseType = $responseType;
    }

    /**
     * @param $response
     *
     * @link https://github.com/rapidwebltd/php-google-contacts-v3-api
     * @return Metacontact[]
     */
    protected function responseToEntities($response)
    {
        $result = [];

        /**
         * @var SimpleXMLElement[] $response
         */
        foreach ($response as $user) {
            $metacontact = new Metacontact();
            $title = (string)$user->title;

            $metacontact->setSourceId((string)$user->id);
            $metacontact->setFirstName(Utils::getFromArray(explode(' ', $title, 2), '0'));
            $metacontact->setLastName(Utils::getFromArray(explode(' ', $title, 2), '1'));

            /**
             * @var SimpleXMLElement[] $contacts
             */
            $contacts = $user->children('http://schemas.google.com/g/2005');
            foreach ($contacts as $key => $value) {
                switch ($key) {
                    case 'email':
                        $attributes = $value->attributes();
                        $emailAddress = (string) $attributes['address'];
                        $emailType = substr(strstr($attributes['rel'], '#'), 1);
                        $metacontact->addContact(new Email($emailAddress, $emailType));
                        break;
                    case 'phoneNumber':
                        $attributes = $value->attributes();
                        $uri = (string) $attributes['uri'];
                        $phoneType = substr(strstr($attributes['rel'], '#'), 1);
                        $phoneNumber = substr(strstr($uri, ':'), 1);
                        $metacontact->addContact(new Phone($phoneNumber, $phoneType));
                        break;
                }
            }

            $result[] = $metacontact;
        }

        return $result;
    }

}