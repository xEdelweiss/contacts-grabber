<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @link http://data.okfn.org/data/core/country-list/r/data.json
 */
$source_okfn = [
    "Afghanistan" => "AF",
    "Åland Islands" => "AX",
    "Albania" => "AL",
    "Algeria" => "DZ",
    "American Samoa" => "AS",
    "Andorra" => "AD",
    "Angola" => "AO",
    "Anguilla" => "AI",
    "Antarctica" => "AQ",
    "Antigua and Barbuda" => "AG",
    "Argentina" => "AR",
    "Armenia" => "AM",
    "Aruba" => "AW",
    "Australia" => "AU",
    "Austria" => "AT",
    "Azerbaijan" => "AZ",
    "Bahamas" => "BS",
    "Bahrain" => "BH",
    "Bangladesh" => "BD",
    "Barbados" => "BB",
    "Belarus" => "BY",
    "Belgium" => "BE",
    "Belize" => "BZ",
    "Benin" => "BJ",
    "Bermuda" => "BM",
    "Bhutan" => "BT",
    "Bolivia, Plurinational State of" => "BO",
    "Bonaire, Sint Eustatius and Saba" => "BQ",
    "Bosnia and Herzegovina" => "BA",
    "Botswana" => "BW",
    "Bouvet Island" => "BV",
    "Brazil" => "BR",
    "British Indian Ocean Territory" => "IO",
    "Brunei Darussalam" => "BN",
    "Bulgaria" => "BG",
    "Burkina Faso" => "BF",
    "Burundi" => "BI",
    "Cambodia" => "KH",
    "Cameroon" => "CM",
    "Canada" => "CA",
    "Cape Verde" => "CV",
    "Cayman Islands" => "KY",
    "Central African Republic" => "CF",
    "Chad" => "TD",
    "Chile" => "CL",
    "China" => "CN",
    "Christmas Island" => "CX",
    "Cocos (Keeling) Islands" => "CC",
    "Colombia" => "CO",
    "Comoros" => "KM",
    "Congo" => "CG",
    "Congo, the Democratic Republic of the" => "CD",
    "Cook Islands" => "CK",
    "Costa Rica" => "CR",
    "Côte d`Ivoire" => "CI",
    "Croatia" => "HR",
    "Cuba" => "CU",
    "Curaçao" => "CW",
    "Cyprus" => "CY",
    "Czech Republic" => "CZ",
    "Denmark" => "DK",
    "Djibouti" => "DJ",
    "Dominica" => "DM",
    "Dominican Republic" => "DO",
    "Ecuador" => "EC",
    "Egypt" => "EG",
    "El Salvador" => "SV",
    "Equatorial Guinea" => "GQ",
    "Eritrea" => "ER",
    "Estonia" => "EE",
    "Ethiopia" => "ET",
    "Falkland Islands (Malvinas)" => "FK",
    "Faroe Islands" => "FO",
    "Fiji" => "FJ",
    "Finland" => "FI",
    "France" => "FR",
    "French Guiana" => "GF",
    "French Polynesia" => "PF",
    "French Southern Territories" => "TF",
    "Gabon" => "GA",
    "Gambia" => "GM",
    "Georgia" => "GE",
    "Germany" => "DE",
    "Ghana" => "GH",
    "Gibraltar" => "GI",
    "Greece" => "GR",
    "Greenland" => "GL",
    "Grenada" => "GD",
    "Guadeloupe" => "GP",
    "Guam" => "GU",
    "Guatemala" => "GT",
    "Guernsey" => "GG",
    "Guinea" => "GN",
    "Guinea-Bissau" => "GW",
    "Guyana" => "GY",
    "Haiti" => "HT",
    "Heard Island and McDonald Islands" => "HM",
    "Holy See (Vatican City State)" => "VA",
    "Honduras" => "HN",
    "Hong Kong" => "HK",
    "Hungary" => "HU",
    "Iceland" => "IS",
    "India" => "IN",
    "Indonesia" => "ID",
    "Iran, Islamic Republic of" => "IR",
    "Iraq" => "IQ",
    "Ireland" => "IE",
    "Isle of Man" => "IM",
    "Israel" => "IL",
    "Italy" => "IT",
    "Jamaica" => "JM",
    "Japan" => "JP",
    "Jersey" => "JE",
    "Jordan" => "JO",
    "Kazakhstan" => "KZ",
    "Kenya" => "KE",
    "Kiribati" => "KI",
    "Korea, Democratic People`s Republic of" => "KP",
    "Korea, Republic of" => "KR",
    "Kuwait" => "KW",
    "Kyrgyzstan" => "KG",
    "Lao People`s Democratic Republic" => "LA",
    "Latvia" => "LV",
    "Lebanon" => "LB",
    "Lesotho" => "LS",
    "Liberia" => "LR",
    "Libya" => "LY",
    "Liechtenstein" => "LI",
    "Lithuania" => "LT",
    "Luxembourg" => "LU",
    "Macao" => "MO",
    "Macedonia, the Former Yugoslav Republic of" => "MK",
    "Madagascar" => "MG",
    "Malawi" => "MW",
    "Malaysia" => "MY",
    "Maldives" => "MV",
    "Mali" => "ML",
    "Malta" => "MT",
    "Marshall Islands" => "MH",
    "Martinique" => "MQ",
    "Mauritania" => "MR",
    "Mauritius" => "MU",
    "Mayotte" => "YT",
    "Mexico" => "MX",
    "Micronesia, Federated States of" => "FM",
    "Moldova, Republic of" => "MD",
    "Monaco" => "MC",
    "Mongolia" => "MN",
    "Montenegro" => "ME",
    "Montserrat" => "MS",
    "Morocco" => "MA",
    "Mozambique" => "MZ",
    "Myanmar" => "MM",
    "Namibia" => "NA",
    "Nauru" => "NR",
    "Nepal" => "NP",
    "Netherlands" => "NL",
    "New Caledonia" => "NC",
    "New Zealand" => "NZ",
    "Nicaragua" => "NI",
    "Niger" => "NE",
    "Nigeria" => "NG",
    "Niue" => "NU",
    "Norfolk Island" => "NF",
    "Northern Mariana Islands" => "MP",
    "Norway" => "NO",
    "Oman" => "OM",
    "Pakistan" => "PK",
    "Palau" => "PW",
    "Palestine, State of" => "PS",
    "Panama" => "PA",
    "Papua New Guinea" => "PG",
    "Paraguay" => "PY",
    "Peru" => "PE",
    "Philippines" => "PH",
    "Pitcairn" => "PN",
    "Poland" => "PL",
    "Portugal" => "PT",
    "Puerto Rico" => "PR",
    "Qatar" => "QA",
    "Réunion" => "RE",
    "Romania" => "RO",
    "Russian Federation" => "RU",
    "Rwanda" => "RW",
    "Saint Barthélemy" => "BL",
    "Saint Helena, Ascension and Tristan da Cunha" => "SH",
    "Saint Kitts and Nevis" => "KN",
    "Saint Lucia" => "LC",
    "Saint Martin (French part)" => "MF",
    "Saint Pierre and Miquelon" => "PM",
    "Saint Vincent and the Grenadines" => "VC",
    "Samoa" => "WS",
    "San Marino" => "SM",
    "Sao Tome and Principe" => "ST",
    "Saudi Arabia" => "SA",
    "Senegal" => "SN",
    "Serbia" => "RS",
    "Seychelles" => "SC",
    "Sierra Leone" => "SL",
    "Singapore" => "SG",
    "Sint Maarten (Dutch part)" => "SX",
    "Slovakia" => "SK",
    "Slovenia" => "SI",
    "Solomon Islands" => "SB",
    "Somalia" => "SO",
    "South Africa" => "ZA",
    "South Georgia and the South Sandwich Islands" => "GS",
    "South Sudan" => "SS",
    "Spain" => "ES",
    "Sri Lanka" => "LK",
    "Sudan" => "SD",
    "Suriname" => "SR",
    "Svalbard and Jan Mayen" => "SJ",
    "Swaziland" => "SZ",
    "Sweden" => "SE",
    "Switzerland" => "CH",
    "Syrian Arab Republic" => "SY",
    "Taiwan, Province of China" => "TW",
    "Tajikistan" => "TJ",
    "Tanzania, United Republic of" => "TZ",
    "Thailand" => "TH",
    "Timor-Leste" => "TL",
    "Togo" => "TG",
    "Tokelau" => "TK",
    "Tonga" => "TO",
    "Trinidad and Tobago" => "TT",
    "Tunisia" => "TN",
    "Turkey" => "TR",
    "Turkmenistan" => "TM",
    "Turks and Caicos Islands" => "TC",
    "Tuvalu" => "TV",
    "Uganda" => "UG",
    "Ukraine" => "UA",
    "United Arab Emirates" => "AE",
    "United Kingdom" => "GB",
    "United States" => "US",
    "United States Minor Outlying Islands" => "UM",
    "Uruguay" => "UY",
    "Uzbekistan" => "UZ",
    "Vanuatu" => "VU",
    "Venezuela, Bolivarian Republic of" => "VE",
    "Viet Nam" => "VN",
    "Virgin Islands, British" => "VG",
    "Virgin Islands, U.S." => "VI",
    "Wallis and Futuna" => "WF",
    "Western Sahara" => "EH",
    "Yemen" => "YE",
    "Zambia" => "ZM",
    "Zimbabwe" => "ZW",
];
/**
 * @link https://vk.com/dev/country_codes
 */
$source_vk = [
    'Australia' => 'AU',
    'Austria' => 'AT',
    'Azerbaijan' => 'AZ',
    'Aland Islands' => 'AX',
    'Albania' => 'AL',
    'Algeria' => 'DZ',
    'Minor Outlying Islands (U.S.)' => 'UM',
    'U.S. Virgin Islands' => 'VI',
    'American Samoa' => 'AS',
    'Anguilla' => 'AI',
    'Angola' => 'AO',
    'Andorra' => 'AD',
    'Antarctica' => 'AQ',
    'Antigua and Barbuda' => 'AG',
    'Argentina' => 'AR',
    'Armenia' => 'AM',
    'Aruba' => 'AW',
    'Afghanistan' => 'AF',
    'Bahamas' => 'BS',
    'Bangladesh' => 'BD',
    'Barbados' => 'BB',
    'Bahrain' => 'BH',
    'Belize' => 'BZ',
    'Belarus' => 'BY',
    'Belgium' => 'BE',
    'Benin' => 'BJ',
    'Bermuda' => 'BM',
    'Bulgaria' => 'BG',
    'Bolivia' => 'BO',
    'Bosnia and Herzegovina' => 'BA',
    'Botswana' => 'BW',
    'Brazil' => 'BR',
    'British Indian Ocean Territory' => 'IO',
    'British Virgin Islands' => 'VG',
    'Brunei' => 'BN',
    'Burkina Faso' => 'BF',
    'Burundi' => 'BI',
    'Bhutan' => 'BT',
    'Vanuatu' => 'VU',
    'Vatican' => 'VA',
    'United Kingdom' => 'GB',
    'Hungary' => 'HU',
    'Venezuela' => 'VE',
    'East Timor' => 'TL',
    'Vietnam' => 'VN',
    'Gabon' => 'GA',
    'Haiti' => 'HT',
    'Guyana' => 'GY',
    'Gambia' => 'GM',
    'Ghana' => 'GH',
    'Guadeloupe' => 'GP',
    'Guatemala' => 'GT',
    'Guinea' => 'GN',
    'Guinea-Bissau' => 'GW',
    'Germany' => 'DE',
    'Gibraltar' => 'GI',
    'Honduras' => 'HN',
    'Hong Kong' => 'HK',
    'Grenada' => 'GD',
    'Greenland' => 'GL',
    'Greece' => 'GR',
    'Georgia' => 'GE',
    'Guam' => 'GU',
    'Denmark' => 'DK',
    'DR Congo' => 'CD',
    'Djibouti' => 'DJ',
    'Dominica' => 'DM',
    'Dominican Republic' => 'DO',
    'European Union' => 'EU',
    'Egypt' => 'EG',
    'Zambia' => 'ZM',
    'Western Sahara' => 'EH',
    'Zimbabwe' => 'ZW',
    'Israel' => 'IL',
    'India' => 'IN',
    'Indonesia' => 'ID',
    'Jordan' => 'JO',
    'Iraq' => 'IQ',
    'Iran' => 'IR',
    'Ireland' => 'IE',
    'Iceland' => 'IS',
    'Spain' => 'ES',
    'Italy' => 'IT',
    'Yemen' => 'YE',
    'North Korea' => 'KP',
    'Cape Verde' => 'CV',
    'Kazakhstan' => 'KZ',
    'Cayman Islands' => 'KY',
    'Cambodia' => 'KH',
    'Cameroon' => 'CM',
    'Canada' => 'CA',
    'Qatar' => 'QA',
    'Kenya' => 'KE',
    'Cyprus' => 'CY',
    'Kyrgyzstan' => 'KG',
    'Kiribati' => 'KI',
    'China' => 'CN',
    'Cocos Islands' => 'CC',
    'Colombia' => 'CO',
    'Comoros' => 'KM',
    'Costa Rica' => 'CR',
    'Ivory Coast' => 'CI',
    'Cuba' => 'CU',
    'Kuwait' => 'KW',
    'Laos' => 'LA',
    'Latvia' => 'LV',
    'Lesotho' => 'LS',
    'Liberia' => 'LR',
    'Lebanon' => 'LB',
    'Libya' => 'LY',
    'Lithuania' => 'LT',
    'Liechtenstein' => 'LI',
    'Luxembourg' => 'LU',
    'Mauritius' => 'MU',
    'Mauritania' => 'MR',
    'Madagascar' => 'MG',
    'Mayotte' => 'YT',
    'Macau' => 'MO',
    'Republic of Macedonia' => 'MK',
    'Malawi' => 'MW',
    'Malaysia' => 'MY',
    'Mali' => 'ML',
    'Maldives' => 'MV',
    'Malta' => 'MT',
    'Morocco' => 'MA',
    'Martinique' => 'MQ',
    'Marshall Islands' => 'MH',
    'Mexico' => 'MX',
    'Mozambique' => 'MZ',
    'Moldova' => 'MD',
    'Monaco' => 'MC',
    'Mongolia' => 'MN',
    'Montserrat' => 'MS',
    'Myanmar' => 'MM',
    'Namibia' => 'NA',
    'Nauru' => 'NR',
    'Nepal' => 'NP',
    'Niger' => 'NE',
    'Nigeria' => 'NG',
    'Netherlands Antilles' => 'AN',
    'The Netherlands' => 'NL',
    'Nicaragua' => 'NI',
    'Niue' => 'NU',
    'New Caledonia' => 'NC',
    'New Zealand' => 'NZ',
    'Norway' => 'NO',
    'UAE' => 'AE',
    'Oman' => 'OM',
    'Christmas Island' => 'CX',
    'Cook Islands' => 'CK',
    'Heard Island and McDonald Islands' => 'HM',
    'Pakistan' => 'PK',
    'Palau' => 'PW',
    'Palestine' => 'PS',
    'Panama' => 'PA',
    'Papua - New Guinea' => 'PG',
    'Paraguay' => 'PY',
    'Peru' => 'PE',
    'Pitcairn Islands' => 'PN',
    'Poland' => 'PL',
    'Portugal' => 'PT',
    'Puerto Rico' => 'PR',
    'Republic of the Congo' => 'CG',
    'Reunion' => 'RE',
    'Russia' => 'RU',
    'Rwanda' => 'RW',
    'Romania' => 'RO',
    'USA' => 'US',
    'El Salvador' => 'SV',
    'Samoa' => 'WS',
    'San Marino' => 'SM',
    'Sao Tome and Principe' => 'ST',
    'Saudi Arabia' => 'SA',
    'Swaziland' => 'SZ',
    'Svalbard and Jan Mayen' => 'SJ',
    'Northern Mariana Islands' => 'MP',
    'Seychelles' => 'SC',
    'Senegal' => 'SN',
    'St. Vincent and the Grenadines' => 'VC',
    'Saint Kitts and Nevis' => 'KN',
    'Saint Lucia' => 'LC',
    'Saint Pierre and Miquelon' => 'PM',
    'Serbia' => 'RS',
    'Serbia and Montenegro (valid until September 2006)' => 'CS',
    'Singapore' => 'SG',
    'Syria' => 'SY',
    'Slovakia' => 'SK',
    'Slovenia' => 'SI',
    'Solomon Islands' => 'SB',
    'Somalia' => 'SO',
    'Sudan' => 'SD',
    'Suriname' => 'SR',
    'Sierra Leone' => 'SL',
    'USSR (valid until September 1992)' => 'SU',
    'Tajikistan' => 'TJ',
    'Thailand' => 'TH',
    'Republic of China' => 'TW',
    'Tanzania' => 'TZ',
    'Togo' => 'TG',
    'Tokelau' => 'TK',
    'Tonga' => 'TO',
    'Trinidad and Tobago' => 'TT',
    'Tuvalu' => 'TV',
    'Tunisia' => 'TN',
    'Turkmenistan' => 'TM',
    'Turkey' => 'TR',
    'Uganda' => 'UG',
    'Uzbekistan' => 'UZ',
    'Ukraine' => 'UA',
    'Uruguay' => 'UY',
    'Faroe Islands' => 'FO',
    'Micronesia' => 'FM',
    'Fiji' => 'FJ',
    'Philippines' => 'PH',
    'Finland' => 'FI',
    'Falkland Islands' => 'FK',
    'France' => 'FR',
    'French Guiana' => 'GF',
    'French Polynesia' => 'PF',
    'French Southern and Antarctic Lands' => 'TF',
    'Croatia' => 'HR',
    'CAR' => 'CF',
    'Chad' => 'TD',
    'Montenegro' => 'ME',
    'Czech Republic' => 'CZ',
    'Chile' => 'CL',
    'Switzerland' => 'CH',
    'Sweden' => 'SE',
    'Sri Lanka' => 'LK',
    'Ecuador' => 'EC',
    'Equatorial Guinea' => 'GQ',
    'Eritrea' => 'ER',
    'Estonia' => 'EE',
    'Ethiopia' => 'ET',
    'South Africa' => 'ZA',
    'Republic of Korea' => 'KR',
    'South Georgia and the South Sandwich Islands' => 'GS',
    'Jamaica' => 'JM',
    'Japan' => 'JP',
    'Bouvet Island' => 'BV',
    'Norfolk' => 'NF',
    'Saint Helena' => 'SH',
    'Turks and Caicos Islands' => 'TC',
    'Wallis and Futuna' => 'WF',
];
/**
 * @link https://gist.github.com/vxnick/380904
 * @link https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
$source_manual = [
    'Congo, Democratic Republic' => 'CD',
    'Macedonia' => 'MK',
    'São Tomé and Príncipe' => 'ST',
    'Sint Maarten' => 'SX',
    'South Korea' => 'KR',
    'Taiwan' => 'TW',
    'US Virgin Islands' => 'VI',
];

$titleToISO = array_merge($source_okfn, $source_vk, $source_manual);

$response = json_decode(file_get_contents('http://api.vk.com/method/database.getCountries?need_all=1&lang=en&count=1000'))->response;

$vkCIDtoISO = [];
$notFound = [];

foreach ($response as $country) {
    $cid = $country->cid;
    $title = $country->title;

    if (!isset($titleToISO[$title])) {
        $notFound[$title] = '';
        continue;
    }

    if (isset($vkCIDtoISO[$cid])) {
        var_dump(['duplicate', $country, $vkCIDtoISO[$cid]]);
    }

    $vkCIDtoISO[$cid] = $titleToISO[$title];
}

if (!empty($notFound)) {
    var_export($notFound);
}

ksort($vkCIDtoISO);
//asort($vkCIDtoISO);
var_export($vkCIDtoISO);