<?php

namespace ContactsGrabber\Driver;

use Carbon\Carbon;
use ContactsGrabber\AuthFlow\OAuthInterface;
use ContactsGrabber\Contact;
use ContactsGrabber\Country;
use ContactsGrabber\Date;
use ContactsGrabber\Metacontact;
use ContactsGrabber\Utils;
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
     * @var array
     */
    protected $apiCountriesList;

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

        $response = Utils::makeJsonRequest($requestUrl);
        $items = Utils::getFromArray($response, 'response.items', []);

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

        $response = Utils::makeJsonRequest($requestUrl);

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
            $gender = $genderMap[Utils::getFromArray($user, 'sex', 0)];

            $metacontact->setSourceId(Utils::getFromArray($user, 'id'));
            $metacontact->setFirstName(Utils::getFromArray($user, 'first_name'));
            $metacontact->setLastName(Utils::getFromArray($user, 'last_name'));
            $metacontact->setNickName(Utils::getFromArray($user, 'nick_name'));
            $metacontact->setCountry($this->getCountry(Utils::getFromArray($user, 'country')));
            $metacontact->setCity(Utils::getFromArray($user, 'city'));
            $metacontact->setPhotoUrl(Utils::getFromArray($user, 'photo_200_orig'));
            $metacontact->setGender($gender);

            $birthdayDate = Utils::getFromArray($user, 'bdate');
            if ($birthdayDate) {
                $metacontact->addDate(new Date(Date::TYPE_BIRTHDAY, Carbon::createFromFormat(mb_substr_count($birthdayDate, '.') == 1 ? 'd.m' : 'd.m.Y', $birthdayDate)));
            }

            $homePhone = Utils::getFromArray($user, 'home_phone');
            if ($homePhone) {
                $metacontact->addContact(new Contact\Phone($homePhone, Contact\Phone::TYPE_HOME, $metacontact->getCountry()));
            }

            $userId = Utils::getFromArray($user, 'id');
            $metacontact->addContact(new Contact\Vkontakte($userId));

            $result[] = $metacontact;
        }

        return $result;
    }

    /**
     * Try to get county ISO code
     * @param string|null $country
     * @return null|Country
     */
    protected function getCountry($country)
    {
        $cid = $country['id'] ?? null;
        $title = $country['title'] ?? null;
        $iso = $this->getIsoByCid($cid);

        if (is_null($cid) || is_null($title)) {
            return null;
        }

        return new Country(
            $iso ?? $title,
            !is_null($iso)
        );
    }

    /**
     * @param $cid
     * @return mixed|null
     */
    private function getIsoByCid($cid)
    {
        $map = $this->getCidToIsoMap();

        return $map[$cid] ?? null;
    }

    /**
     * @return array
     */
    private function getCidToIsoMap()
    {
        return [
            1 => 'RU',
            2 => 'UA',
            3 => 'BY',
            4 => 'KZ',
            5 => 'AZ',
            6 => 'AM',
            7 => 'GE',
            8 => 'IL',
            9 => 'US',
            10 => 'CA',
            11 => 'KG',
            12 => 'LV',
            13 => 'LT',
            14 => 'EE',
            15 => 'MD',
            16 => 'TJ',
            17 => 'TM',
            18 => 'UZ',
            19 => 'AU',
            20 => 'AT',
            21 => 'AL',
            22 => 'DZ',
            23 => 'AS',
            24 => 'AI',
            25 => 'AO',
            26 => 'AD',
            27 => 'AG',
            28 => 'AR',
            29 => 'AW',
            30 => 'AF',
            31 => 'BS',
            32 => 'BD',
            33 => 'BB',
            34 => 'BH',
            35 => 'BZ',
            36 => 'BE',
            37 => 'BJ',
            38 => 'BM',
            39 => 'BG',
            40 => 'BO',
            41 => 'BA',
            42 => 'BW',
            43 => 'BR',
            44 => 'BN',
            45 => 'BF',
            46 => 'BI',
            47 => 'BT',
            48 => 'VU',
            49 => 'GB',
            50 => 'HU',
            51 => 'VE',
            52 => 'VG',
            53 => 'VI',
            54 => 'TL',
            55 => 'VN',
            56 => 'GA',
            57 => 'HT',
            58 => 'GY',
            59 => 'GM',
            60 => 'GH',
            61 => 'GP',
            62 => 'GT',
            63 => 'GN',
            64 => 'GW',
            65 => 'DE',
            66 => 'GI',
            67 => 'HN',
            68 => 'HK',
            69 => 'GD',
            70 => 'GL',
            71 => 'GR',
            72 => 'GU',
            73 => 'DK',
            74 => 'DM',
            75 => 'DO',
            76 => 'EG',
            77 => 'ZM',
            78 => 'EH',
            79 => 'ZW',
            80 => 'IN',
            81 => 'ID',
            82 => 'JO',
            83 => 'IQ',
            84 => 'IR',
            85 => 'IE',
            86 => 'IS',
            87 => 'ES',
            88 => 'IT',
            89 => 'YE',
            90 => 'CV',
            91 => 'KH',
            92 => 'CM',
            93 => 'QA',
            94 => 'KE',
            95 => 'CY',
            96 => 'KI',
            97 => 'CN',
            98 => 'CO',
            99 => 'KM',
            100 => 'CG',
            101 => 'CD',
            102 => 'CR',
            103 => 'CI',
            104 => 'CU',
            105 => 'KW',
            106 => 'LA',
            107 => 'LS',
            108 => 'LR',
            109 => 'LB',
            110 => 'LY',
            111 => 'LI',
            112 => 'LU',
            113 => 'MU',
            114 => 'MR',
            115 => 'MG',
            116 => 'MO',
            117 => 'MK',
            118 => 'MW',
            119 => 'MY',
            120 => 'ML',
            121 => 'MV',
            122 => 'MT',
            123 => 'MA',
            124 => 'MQ',
            125 => 'MH',
            126 => 'MX',
            127 => 'FM',
            128 => 'MZ',
            129 => 'MC',
            130 => 'MN',
            131 => 'MS',
            132 => 'MM',
            133 => 'NA',
            134 => 'NR',
            135 => 'NP',
            136 => 'NE',
            137 => 'NG',
            138 => 'CW',
            139 => 'NL',
            140 => 'NI',
            141 => 'NU',
            142 => 'NZ',
            143 => 'NC',
            144 => 'NO',
            145 => 'AE',
            146 => 'OM',
            147 => 'IM',
            148 => 'NF',
            149 => 'KY',
            150 => 'CK',
            151 => 'TC',
            152 => 'PK',
            153 => 'PW',
            154 => 'PS',
            155 => 'PA',
            156 => 'PG',
            157 => 'PY',
            158 => 'PE',
            159 => 'PN',
            160 => 'PL',
            161 => 'PT',
            162 => 'PR',
            163 => 'RE',
            164 => 'RW',
            165 => 'RO',
            166 => 'SV',
            167 => 'WS',
            168 => 'SM',
            169 => 'ST',
            170 => 'SA',
            171 => 'SZ',
            172 => 'SH',
            173 => 'KP',
            174 => 'MP',
            175 => 'SC',
            176 => 'SN',
            177 => 'VC',
            178 => 'KN',
            179 => 'LC',
            180 => 'PM',
            181 => 'RS',
            182 => 'SG',
            183 => 'SY',
            184 => 'SK',
            185 => 'SI',
            186 => 'SB',
            187 => 'SO',
            188 => 'SD',
            189 => 'SR',
            190 => 'SL',
            191 => 'TH',
            192 => 'TW',
            193 => 'TZ',
            194 => 'TG',
            195 => 'TK',
            196 => 'TO',
            197 => 'TT',
            198 => 'TV',
            199 => 'TN',
            200 => 'TR',
            201 => 'UG',
            202 => 'WF',
            203 => 'UY',
            204 => 'FO',
            205 => 'FJ',
            206 => 'PH',
            207 => 'FI',
            208 => 'FK',
            209 => 'FR',
            210 => 'GF',
            211 => 'PF',
            212 => 'HR',
            213 => 'CF',
            214 => 'TD',
            215 => 'CZ',
            216 => 'CL',
            217 => 'CH',
            218 => 'SE',
            219 => 'SJ',
            220 => 'LK',
            221 => 'EC',
            222 => 'GQ',
            223 => 'ER',
            224 => 'ET',
            226 => 'KR',
            227 => 'ZA',
            228 => 'JM',
            229 => 'JP',
            230 => 'ME',
            231 => 'DJ',
            232 => 'SS',
            233 => 'VA',
            234 => 'SX',
            235 => 'BQ',
            236 => 'GG',
            237 => 'JE',
        ];
    }
}