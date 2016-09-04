<?php

namespace ContactsGrabber\Driver;

use Carbon\Carbon;
use ContactsGrabber\AuthFlow\OAuthInterface;
use ContactsGrabber\Contact;
use ContactsGrabber\Date;
use ContactsGrabber\Metacontact;
use GuzzleHttp\Client;

class Vkontakte extends AbstractDriver implements OAuthInterface
{
    /**
     * @var string
     */
    protected $authDomain = 'https://oauth.vk.com/';
    /**
     * @var string
     */
    protected $apiDomain = 'https://api.vk.com/';
    /**
     * @var string
     */
    protected $version = "5.53";
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
    protected $display;
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
     * Vkontakte constructor.
     *
     * @param null $clientId
     * @param null $clientSecret
     * @param null $redirectUrl
     * @param string $scope
     * @param string $display
     * @param string $responseType
     * @param string $version
     */
    public function __construct($clientId = null, $clientSecret = null, $redirectUrl = null, $scope = 'friends', $display = 'popup', $responseType = 'code', $version = "5.53")
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUrl($redirectUrl);
        $this->setScope($scope);
        $this->setDisplay($display);
        $this->setResponseType($responseType);
        $this->setVersion($version);
    }

    /**
     * @return \ContactsGrabber\Metacontact[]
     * @throws \Exception
     */
    public function fetchContacts()
    {
        $accessToken = $this->getAccessToken();

        $requestUrl = $this->getApiDomain() . 'method/friends.get?' . http_build_query([
            'order' => 'name',
            'fields' => 'nickname,sex,bdate,city,country,timezone,photo_200_orig,has_mobile,contacts',
            'access_token' => $accessToken,
            'v' => $this->getVersion(),
        ]);

        if (is_null($accessToken)) {
            throw new \Exception('Unauthorized. Access Token is required');
        }

        $response = $this->makeRequest($requestUrl);
        $items = $this->getFromArray($response['response'], 'items', []);

        return $this->responseToEntities($items);
    }

    /*
     * OAuthInterface implementation
     */

    public function getAuthorizationRequestUrl($clientId = null, $redirectUrl = null, $scope = null, $responseType = null) : string
    {
        $clientId = $clientId ?: $this->getClientId();
        $redirectUrl = $redirectUrl ?: $this->getRedirectUrl();
        $scope = $scope ?: $this->getScope();
        $responseType = $responseType ?: $this->getResponseType();

        $display = $this->getDisplay();
        $version = $this->getVersion();

        $this->setRedirectUrl($redirectUrl);

        return $this->getAuthDomain() . 'authorize?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUrl,
            'display' => $display,
            'scope' => $scope,
            'response_type' => $responseType,
            'v' => $version
        ]);
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

        $requestUrl = $this->getAuthDomain() . 'access_token?' . http_build_query([
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUrl,
        ]);

        $response = $this->makeRequest($requestUrl);

        if (!isset($response['access_token'])) {
            throw new \Exception('Access token fetch failed');
        }

        return $response['access_token'];
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
    public function getDisplay(): string
    {
        return $this->display;
    }

    /**
     * @param string $display
     */
    public function setDisplay(string $display)
    {
        $this->display = $display;
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
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getApiDomain(): string
    {
        return $this->apiDomain;
    }

    /**
     * @param string $apiDomain
     */
    public function setApiDomain(string $apiDomain)
    {
        $this->apiDomain = $apiDomain;
    }


    /**
     * @return string
     */
    public function getAuthDomain(): string
    {
        return $this->authDomain;
    }

    /**
     * @param string $authDomain
     */
    public function setAuthDomain(string $authDomain)
    {
        $this->authDomain = $authDomain;
    }

    /*
     * Low level methods
     */

    protected function makeRequest($url, $method = 'GET', $options = [])
    {
        $client = new Client([
            'timeout' => 5,
        ]);

        $response = $client->request($method, $url, $options);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Request failed');
        }

        $data = json_decode((string)$response->getBody(), true);

        return $data;
    }

    protected function getFromArray($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * @param array $response
     * @return Metacontact[]
     */
    protected function responseToEntities(array $response)
    {
        $result = [];
        $genderMap = [
            '0' => null,
            '1' => Metacontact::GENDER_FEMALE,
            '2' => Metacontact::GENDER_MALE,
        ];

        foreach ($response as $user) {
            $metacontact = new Metacontact();
            $gender = $genderMap[$this->getFromArray($user, 'sex', 0)];

            $metacontact->setFirstName($this->getFromArray($user, 'first_name'));
            $metacontact->setLastName($this->getFromArray($user, 'last_name'));
            $metacontact->setNickName($this->getFromArray($user, 'nick_name'));
            $metacontact->setCountry($this->getFromArray($user, 'country')); // @fixme
            $metacontact->setCity($this->getFromArray($user, 'city')); // @fixme
            $metacontact->setPhotoUrl($this->getFromArray($user, 'photo_200_orig')); // @fixme
            $metacontact->setGender($gender);

            $birthdayDate = $this->getFromArray($user, 'bdate');
            if ($birthdayDate) {
                $metacontact->addDate(new Date(Date::TYPE_BIRTHDAY, Carbon::createFromFormat(mb_substr_count($birthdayDate, '.') == 1 ? 'd.m' : 'd.m.Y', $birthdayDate)));
            }

            $homePhone = $this->getFromArray($user, 'home_phone');
            if ($homePhone) {
                $metacontact->addContact(Contact::make(
                    Contact::PHONE,
                    $homePhone,
                    Contact::PHONE_PURPOSE_HOME
                ));
            }

            $userId = $this->getFromArray($user, 'id');
            $metacontact->addContact(Contact::make(
                Contact::VKONTAKTE,
                $userId
            ));

            $result[] = $metacontact;
        }

        return $result;
    }
}