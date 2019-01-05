<?php
/**
 * Created by PhpStorm.
 * User: xutongle
 * Date: 2018-08-02
 * Time: 12:36
 */

namespace App\Utils;

use Illuminate\Support\Facades\App;
use Locale;

/**
 * Map of codes from ISO 3166.
 * Credits: https://github.com/julien-c/iso3166/blob/master/src/Codes.php
 */
class ISO3166
{
    /**
     * 国家简码
     * @var array
     */
    public static $countries = [
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua and Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BQ' => 'Bonaire, Saint Eustatius and Saba',
        'BA' => 'Bosnia and Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'VG' => 'British Virgin Islands',
        'BN' => 'Brunei',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curacao',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'CD' => 'Democratic Republic of the Congo',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island and McDonald Islands',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'CI' => 'Ivory Coast',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'XK' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Laos',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'KP' => 'North Korea',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'CG' => 'Republic of the Congo',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts and Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre and Miquelon',
        'VC' => 'Saint Vincent and the Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'Sint Maarten',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'KR' => 'South Korea',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard and Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syria',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad and Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'VI' => 'U.S. Virgin Islands',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VA' => 'Vatican',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis and Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
        'YU' => 'Socialist Federal Republic of Yugoslavia',
        'KT' => 'Ivory Coast',
    ];

    /**
     * 国家首都经纬度
     * @var array
     */
    public static $positions = [
        // lat / lon
        'AF' => [69.11, 34.28],
        'AX' => [60.17, 19.91],
        'AL' => [19.49, 41.18],
        'DZ' => [3.08, 36.42],
        'AS' => [-170.43, -14.16],
        'AD' => [1.32, 42.31],
        'AO' => [13.15, -8.50],
        'AI' => [18.22, -63.07],
        'AQ' => [65, 360],
        'AG' => [-61.48, 17.20],
        'AR' => [-60.00, -36.30],
        'AM' => [44.31, 40.10],
        'AW' => [-70.02, 12.32],
        'AU' => [149.08, -35.15],
        'AT' => [16.22, 48.12],
        'AZ' => [49.56, 40.29],
        'BS' => [-77.20, 25.05],
        'BH' => [50.30, 26.10],
        'BD' => [90.26, 23.43],
        'BB' => [-59.30, 13.05],
        'BY' => [27.30, 53.52],
        'BE' => [4.21, 50.51],
        'BZ' => [-88.30, 17.18],
        'BJ' => [2.42, 6.23],
        'BM' => [32.30, -64.78],
        'BT' => [89.45, 27.31],
        'BO' => [-68.10, -16.20],
        'BQ' => [-68.29, 12.21],
        'BA' => [18.26, 43.52],
        'BW' => [25.57, -24.45],
        'BV' => [-54.42, 3.41],
        'BR' => [-47.55, -15.47],
        'IO' => [-6.34, 71.87],
        'VG' => [-64.37, 18.27],
        'BN' => [115.00, 4.52],
        'BG' => [23.20, 42.45],
        'BF' => [-1.30, 12.15],
        'BI' => [29.18, -3.16],
        'KH' => [104.55, 11.33],
        'CM' => [11.35, 3.50],
        'CA' => [-75.42, 45.27],
        'CV' => [-23.34, 15.02],
        'KY' => [-81.24, 19.20],
        'CF' => [18.35, 4.23],
        'TD' => [14.59, 12.10],
        'CL' => [-70.40, -33.24],
        'CN' => [39.904, 116.408],
        'CX' => [-10.44, 105.69],
        'CC' => [-12.16, 96.87],
        'CO' => [-74.00, 4.34],
        'KM' => [43.16, -11.40],
        'CK' => [-21.22, -159.77],
        'CR' => [-84.02, 9.55],
        'HR' => [15.58, 45.50],
        'CU' => [-82.22, 23.08],
        'CW' => [12.16, -68.99],
        'CY' => [33.25, 35.10],
        'CZ' => [14.22, 50.05],
        'CD' => [15.12, -4.09],
        'DK' => [12.34, 55.41],
        'DJ' => [42.20, 11.08],
        'DM' => [-61.24, 15.20],
        'DO' => [-69.59, 18.30],
        'EC' => [-78.35, -0.15],
        'EG' => [31.14, 30.01],
        'SV' => [-89.10, 13.40],
        'GQ' => [8.50, 3.45],
        'ER' => [38.55, 15.19],
        'EE' => [24.48, 59.22],
        'ET' => [38.42, 9.02],
        'FK' => [-59.51, -51.40],
        'FO' => [-6.56, 62.05],
        'FJ' => [178.30, -18.06],
        'FI' => [25.03, 60.15],
        'FR' => [2.20, 48.50],
        'GF' => [-52.18, 5.05],
        'PF' => [-149.34, -17.32],
        'TF' => [-49.28, 69.34],
        'GA' => [9.26, 0.25],
        'GM' => [-16.40, 13.28],
        'GE' => [44.50, 41.43],
        'DE' => [13.25, 52.30],
        'GH' => [-0.06, 5.35],
        'GI' => [36.14, -5.35],
        'GR' => [23.46, 37.58],
        'GL' => [-51.35, 64.10],
        'GD' => [12.11, -61.69],
        'GP' => [-61.44, 16.00],
        'GU' => [15.19, 145.76],
        'GT' => [-90.22, 14.40],
        'GG' => [-2.33, 49.26],
        'GN' => [-13.49, 9.29],
        'GW' => [-15.45, 11.45],
        'GY' => [-58.12, 6.50],
        'HT' => [-72.20, 18.40],
        'HM' => [74.00, -53.00],
        'HN' => [-87.14, 14.05],
        'HK' => [31.29, 120.58],
        'HU' => [19.05, 47.29],
        'IS' => [-21.57, 64.10],
        'IN' => [77.13, 28.37],
        'ID' => [106.49, -6.09],
        'IR' => [51.30, 35.44],
        'IQ' => [44.30, 33.20],
        'IE' => [-6.15, 53.21],
        'IM' => [54.15, -4.49],
        'IL' => [35.12, 31.47],
        'IT' => [12.29, 41.54],
        'CI' => [7.54, -5.54],
        'JM' => [-76.50, 18.00],
        'JP' => [36.20, 138.25],
        'JE' => [49.21, -2.13],
        'JO' => [35.52, 31.57],
        'KZ' => [71.30, 51.10],
        'KE' => [36.48, -1.17],
        'KI' => [173.00, 1.30],
        'XK' => [42.60, 20.90],
        'KW' => [48.00, 29.30],
        'KG' => [74.46, 42.54],
        'LA' => [102.36, 17.58],
        'LV' => [24.08, 56.53],
        'LB' => [35.31, 33.53],
        'LS' => [27.30, -29.18],
        'LR' => [-10.47, 6.18],
        'LY' => [13.07, 32.49],
        'LI' => [9.31, 47.08],
        'LT' => [25.19, 54.38],
        'LU' => [6.09, 49.37],
        'MO' => [22.19, 113.54],
        'MK' => [21.26, 42.01],
        'MG' => [47.31, -18.55],
        'MW' => [33.48, -14.00],
        'MY' => [101.41, 3.09],
        'MV' => [73.28, 4.00],
        'ML' => [-7.55, 12.34],
        'MT' => [14.31, 35.54],
        'MH' => [7.11, 171.08],
        'MQ' => [-61.02, 14.36],
        'MR' => [57.30, -20.10],
        'MU' => [-20.25, 57.55],
        'YT' => [45.14, -12.48],
        'MX' => [-99.10, 19.20],
        'FM' => [158.09, 6.55],
        'MD' => [28.50, 47.02],
        'MC' => [43.73, 7.42],
        'MN' => [46.86, 103.83],
        'ME' => [42.69, 19.43],
        'MS' => [16.74, -62.18],
        'MA' => [31.43, -6.40],
        'MZ' => [32.32, -25.58],
        'MM' => [96.20, 16.45],
        'NA' => [17.04, -22.35],
        'NR' => [-0.52, 166.92],
        'NP' => [85.20, 27.45],
        'NL' => [04.54, 52.23],
        'AN' => [-69.00, 12.05],
        'NC' => [166.30, -22.17],
        'NZ' => [174.46, -41.19],
        'NI' => [-86.20, 12.06],
        'NE' => [2.06, 13.27],
        'NG' => [7.32, 9.05],
        'NU' => [-19.05, -169.86],
        'NF' => [168.43, -45.20],
        'KP' => [125.30, 39.09],
        'MP' => [145.45, 15.12],
        'NO' => [10.45, 59.55],
        'OM' => [58.36, 23.37],
        'PK' => [73.10, 33.40],
        'PW' => [134.28, 7.20],
        'PS' => [31.94, 35.22],
        'PA' => [-79.25, 9.00],
        'PG' => [147.08, -9.24],
        'PY' => [-57.30, -25.10],
        'PE' => [-77.00, -12.00],
        'PH' => [121.03, 14.40],
        'PN' => [-24.70, -127.43],
        'PL' => [21.00, 52.13],
        'PT' => [-9.10, 38.42],
        'PR' => [-66.07, 18.28],
        'QA' => [51.35, 25.15],
        'CG' => [15.15, -4.20],
        'RE' => [-21.11, 55.53],
        'RO' => [26.10, 44.27],
        'RU' => [37.35, 55.45],
        'RW' => [30.04, -1.59],
        'BL' => [17.9, -62.83],
        'SH' => [-24.14, -10.03],
        'KN' => [-62.43, 17.17],
        'LC' => [-60.58, 14.02],
        'MF' => [18.08, -63.05],
        'PM' => [-56.12, 46.46],
        'VC' => [-61.10, 13.10],
        'WS' => [-171.50, -13.50],
        'SM' => [12.30, 43.55],
        'ST' => [6.39, 0.10],
        'SA' => [46.42, 24.41],
        'SN' => [-17.29, 14.34],
        'RS' => [44.04, 20.91],
        'SC' => [-4.68, 55.48],
        'SL' => [-13.17, 8.30],
        'SG' => [1.35, 103.81],
        'SX' => [18.04, -63.05],
        'SK' => [17.07, 48.10],
        'SI' => [14.33, 46.04],
        'SB' => [159.57, -9.27],
        'SO' => [45.25, 2.02],
        'ZA' => [28.12, -25.44],
        'GS' => [26.90, 60.10],
        'KR' => [126.58, 37.31],
        'SS' => [33.87, 35.86],
        'ES' => [-3.45, 40.25],
        'LK' => [7.87, 80.78],
        'SD' => [32.35, 15.31],
        'SR' => [3.91, -56.03],
        'SJ' => [77.55, 23.67],
        'SZ' => [31.06, -26.18],
        'SE' => [18.03, 59.20],
        'CH' => [7.28, 46.57],
        'SY' => [36.18, 33.30],
        'TW' => [25.03, 121.56],
        'TJ' => [68.48, 38.33],
        'TZ' => [35.45, -6.08],
        'TH' => [100.35, 13.45],
        'TL' => [125.34, -8.29],
        'TG' => [1.20, 6.09],
        'TK' => [-9.38, -171.25],
        'TO' => [-174.00, -21.10],
        'TT' => [10.43, -61.41],
        'TN' => [10.11, 36.50],
        'TR' => [32.54, 39.57],
        'TM' => [57.50, 38.00],
        'TC' => [21.79, -71.74],
        'TV' => [179.13, -8.31],
        'VI' => [-64.56, 18.21],
        'UG' => [32.30, 0.20],
        'UA' => [30.28, 50.30],
        'AE' => [54.22, 24.28],
        'GB' => [-0.05, 51.36],
        'US' => [-77.02, 39.91],
        'UM' => [-77.02, 39.91],
        'UY' => [-56.11, -34.50],
        'UZ' => [69.10, 41.20],
        'VU' => [168.18, -17.45],
        'VA' => [41.90, 12.45],
        'VE' => [-66.55, 10.30],
        'VN' => [105.55, 21.05],
        'WF' => [-14.29, -178.11],
        'EH' => [24.21, -12.88],
        'YE' => [15.79, 47.85],
        'ZM' => [28.16, -15.28],
        'ZW' => [31.02, -17.43],
        'YU' => [20.37, 44.50],
        'KT' => [-5.17, 6.49],
    ];

    /**
     * 国际区号
     * @var array
     */
    public static $phoneCodes = [
        "AF" => "93",
        "AX" => "358",
        "AL" => "355",
        "DZ" => "213",
        "AD" => "376",
        "AO" => "244",
        "AQ" => "672",
        "AG" => "1268",
        "AR" => "54",
        "AM" => "374",
        "AW" => "297",
        "AU" => "61",
        "AT" => "43",
        "AZ" => "994",
        "BS" => "1242",
        "BH" => "973",
        "BD" => "880",
        "BB" => "1246",
        "BY" => "375",
        "BE" => "32",
        "BZ" => "501",
        "BJ" => "229",
        "BM" => "1441",
        "BT" => "975",
        "BO" => "591",
        "BQ" => "5997",
        "BA" => "387",
        "BW" => "267",
        "BR" => "55",
        "IO" => "246",
        "BN" => "673",
        "BG" => "359",
        "BF" => "226",
        "BI" => "257",
        "KH" => "855",
        "CM" => "237",
        "CA" => "1",
        "CV" => "238",
        "KY" => "1345",
        "CF" => "236",
        "TD" => "235",
        "CL" => "56",
        "CN" => "86",
        "CX" => "61",
        "CC" => "61891",
        "CO" => "57",
        "KM" => "269",
        "CG" => "242",
        "CD" => "243",
        "CK" => "682",
        "CR" => "506",
        "HR" => "385",
        "CU" => "53",
        "CW" => "599",
        "CY" => "357",
        "CZ" => "420",
        "DK" => "45",
        "DJ" => "253",
        "DM" => "1767",
        "EC" => "593",
        "EG" => "20",
        "SV" => "503",
        "GQ" => "240",
        "ER" => "291",
        "EE" => "372",
        "ET" => "251",
        "FK" => "500",
        "FO" => "298",
        "FJ" => "679",
        "FI" => "358",
        "FR" => "33",
        "GF" => "594",
        "PF" => "689",
        "TF" => "596",
        "GA" => "241",
        "GM" => "220",
        "GE" => "995",
        "DE" => "49",
        "GH" => "233",
        "GI" => "350",
        "GR" => "30",
        "GL" => "299",
        "GD" => "1473",
        "GP" => "590",
        "GU" => "1671",
        "GT" => "502",
        "GG" => "441481",
        "GN" => "224",
        "GW" => "245",
        "GY" => "592",
        "HT" => "509",
        "HN" => "504",
        "HK" => "852",
        "HU" => "36",
        "IS" => "354",
        "IN" => "91",
        "ID" => "62",
        "IR" => "98",
        "IQ" => "964",
        "IE" => "353",
        "IM" => "441624",
        "IL" => "972",
        "IT" => "39",
        "CI" => "225",
        "JM" => "1876",
        "JP" => "81",
        "JE" => "441534",
        "JO" => "962",
        "KZ" => "7",
        "KE" => "254",
        "KI" => "686",
        "KP" => "850",
        "KR" => "82",
        "XK" => "383",
        "KW" => "965",
        "KG" => "996",
        "LA" => "856",
        "LV" => "371",
        "LB" => "961",
        "LS" => "266",
        "LR" => "231",
        "LY" => "218",
        "LI" => "423",
        "LT" => "370",
        "LU" => "352",
        "MO" => "853",
        "MK" => "389",
        "MG" => "261",
        "MW" => "265",
        "MY" => "60",
        "MV" => "960",
        "ML" => "223",
        "MT" => "356",
        "MH" => "692",
        "MQ" => "596",
        "MR" => "222",
        "MU" => "230",
        "YT" => "269",
        "MX" => "52",
        "FM" => "691",
        "MD" => "373",
        "MC" => "377",
        "MN" => "976",
        "ME" => "382",
        "MS" => "1664",
        "MA" => "212",
        "MZ" => "258",
        "MM" => "95",
        "NA" => "264",
        "NR" => "674",
        "NP" => "977",
        "NL" => "31",
        "AN" => "599",
        "NC" => "687",
        "NZ" => "64",
        "NI" => "505",
        "NE" => "227",
        "NG" => "234",
        "NU" => "683",
        "NF" => "672",
        "MP" => "1670",
        "NO" => "47",
        "OM" => "968",
        "PK" => "92",
        "PW" => "680",
        "PS" => "970",
        "PA" => "507",
        "PG" => "675",
        "PY" => "595",
        "PE" => "51",
        "PH" => "63",
        "PN" => "64",
        "PL" => "48",
        "PT" => "351",
        "QA" => "974",
        "RE" => "262",
        "RO" => "40",
        "RU" => "7",
        "RW" => "250",
        "BL" => "590",
        "SH" => "290",
        "KN" => "1869",
        "LC" => "1758",
        "MF" => "590",
        "PM" => "508",
        "VC" => "1784",
        "WS" => "685",
        "SM" => "378",
        "ST" => "239",
        "SA" => "966",
        "SN" => "221",
        "RS" => "381",
        "SC" => "248",
        "SL" => "232",
        "SG" => "65",
        "SX" => "1721",
        "SK" => "421",
        "SI" => "386",
        "SB" => "677",
        "SO" => "252",
        "ZA" => "27",
        "GS" => "500",
        "SS" => "211",
        "ES" => "34",
        "LK" => "94",
        "SD" => "249",
        "SR" => "597",
        "SJ" => "47",
        "SZ" => "268",
        "SE" => "46",
        "CH" => "41",
        "SY" => "963",
        "TW" => "886",
        "TJ" => "992",
        "TZ" => "255",
        "TH" => "66",
        "TL" => "670",
        "TG" => "228",
        "TK" => "690",
        "TO" => "676",
        "TT" => "1868",
        "TN" => "216",
        "TR" => "90",
        "TM" => "993",
        "TC" => "1649",
        "TV" => "688",
        "UG" => "256",
        "UA" => "380",
        "AE" => "971",
        "GB" => "44",
        "US" => "1",
        "UY" => "598",
        "UZ" => "998",
        "VU" => "678",
        "VA" => "379",
        "VE" => "58",
        "VN" => "84",
        "VI" => "1340",
        "VG" => "1284",
        "WF" => "681",
        "EH" => "212",
        "YE" => "967",
        "ZM" => "260",
        "ZW" => "263",
        "YU" => "338",
        "KT" => "225",
    ];

    /**
     * 国家名称中英文对照表
     * @var array
     */
    public static $countryCodes = [
        '阿富汗' => 'AF',
        '奥兰群岛' => 'AX',
        '阿尔巴尼亚' => 'AL',
        '阿尔及利亚' => 'DZ',
        '美属萨摩亚' => 'AS',
        '安道尔' => 'AD',
        '安哥拉' => 'AO',
        '安圭拉' => 'AI',
        '南极洲' => 'AQ',
        '安提瓜和巴布达' => 'AG',
        '阿根廷' => 'AR',
        '亚美尼亚' => 'AM',
        '阿鲁巴' => 'AW',
        '澳大利亚' => 'AU',
        '奥地利' => 'AT',
        '阿塞拜疆' => 'AZ',
        '巴哈马' => 'BS',
        '巴林' => 'BH',
        '孟加拉国' => 'BD',
        '巴巴多斯' => 'BB',
        '白俄罗斯' => 'BY',
        '比利时' => 'BE',
        '伯利兹' => 'BZ',
        '贝宁' => 'BJ',
        '百慕大' => 'BM',
        '不丹' => 'BT',
        '玻利维亚' => 'BO',
        '荷兰加勒比区' => 'BQ',
        '波斯尼亚和黑塞哥维那' => 'BA',
        '博茨瓦纳' => 'BW',
        '布维岛' => 'BV',
        '巴西' => 'BR',
        '英属印度洋领地' => 'IO',
        '英属维京群岛' => 'VG',
        '文莱' => 'BN',
        '保加利亚' => 'BG',
        '布基纳法索' => 'BF',
        '布隆迪' => 'BI',
        '柬埔寨' => 'KH',
        '喀麦隆' => 'CM',
        '加拿大' => 'CA',
        '佛得角' => 'CV',
        '开曼群岛' => 'KY',
        '中非共和国' => 'CF',
        '乍得' => 'TD',
        '智利' => 'CL',
        '中国' => 'CN',
        '圣诞岛' => 'CX',
        '科科斯（基林）群岛' => 'CC',
        '哥伦比亚' => 'CO',
        '科摩罗' => 'KM',
        '库克群岛' => 'CK',
        '哥斯达黎加' => 'CR',
        '克罗地亚' => 'HR',
        '古巴' => 'CU',
        '库拉索' => 'CW',
        '塞浦路斯' => 'CY',
        '捷克共和国' => 'CZ',
        '刚果（金）' => 'CD',
        '丹麦' => 'DK',
        '吉布提' => 'DJ',
        '多米尼克' => 'DM',
        '多米尼加共和国' => 'DO',
        '厄瓜多尔' => 'EC',
        '埃及' => 'EG',
        '萨尔瓦多' => 'SV',
        '赤道几内亚' => 'GQ',
        '厄立特里亚' => 'ER',
        '爱沙尼亚' => 'EE',
        '埃塞俄比亚' => 'ET',
        '福克兰群岛' => 'FK',
        '法罗群岛' => 'FO',
        '斐济' => 'FJ',
        '芬兰' => 'FI',
        '法国' => 'FR',
        '法属圭亚那' => 'GF',
        '法属波利尼西亚' => 'PF',
        '法属南部领地' => 'TF',
        '加蓬' => 'GA',
        '冈比亚' => 'GM',
        '格鲁吉亚' => 'GE',
        '德国' => 'DE',
        '加纳' => 'GH',
        '直布罗陀' => 'GI',
        '希腊' => 'GR',
        '格陵兰' => 'GL',
        '格林纳达' => 'GD',
        '瓜德罗普' => 'GP',
        '关岛' => 'GU',
        '危地马拉' => 'GT',
        '根西岛' => 'GG',
        '几内亚' => 'GN',
        '几内亚比绍' => 'GW',
        '圭亚那' => 'GY',
        '海地' => 'HT',
        '赫德岛和麦克唐纳群岛' => 'HM',
        '洪都拉斯' => 'HN',
        '中国香港特别行政区' => 'HK',
        '匈牙利' => 'HU',
        '冰岛' => 'IS',
        '印度' => 'IN',
        '印度尼西亚' => 'ID',
        '伊朗' => 'IR',
        '伊拉克' => 'IQ',
        '爱尔兰' => 'IE',
        '曼岛' => 'IM',
        '以色列' => 'IL',
        '意大利' => 'IT',
        '科特迪瓦' => 'CI',
        '牙买加' => 'JM',
        '日本' => 'JP',
        '泽西岛' => 'JE',
        '约旦' => 'JO',
        '哈萨克斯坦' => 'KZ',
        '肯尼亚' => 'KE',
        '基里巴斯' => 'KI',
        '科索沃' => 'XK',
        '科威特' => 'KW',
        '吉尔吉斯斯坦' => 'KG',
        '老挝' => 'LA',
        '拉脱维亚' => 'LV',
        '黎巴嫩' => 'LB',
        '莱索托' => 'LS',
        '利比里亚' => 'LR',
        '利比亚' => 'LY',
        '列支敦士登' => 'LI',
        '立陶宛' => 'LT',
        '卢森堡' => 'LU',
        '中国澳门特别行政区' => 'MO',
        '马其顿' => 'MK',
        '马达加斯加' => 'MG',
        '马拉维' => 'MW',
        '马来西亚' => 'MY',
        '马尔代夫' => 'MV',
        '马里' => 'ML',
        '马耳他' => 'MT',
        '马绍尔群岛' => 'MH',
        '马提尼克' => 'MQ',
        '毛里塔尼亚' => 'MR',
        '毛里求斯' => 'MU',
        '马约特' => 'YT',
        '墨西哥' => 'MX',
        '密克罗尼西亚' => 'FM',
        '摩尔多瓦' => 'MD',
        '摩纳哥' => 'MC',
        '蒙古' => 'MN',
        '黑山' => 'ME',
        '蒙特塞拉特' => 'MS',
        '摩洛哥' => 'MA',
        '莫桑比克' => 'MZ',
        '缅甸' => 'MM',
        '纳米比亚' => 'NA',
        '瑙鲁' => 'NR',
        '尼泊尔' => 'NP',
        '荷兰' => 'NL',
        '库拉索' => 'AN',
        '新喀里多尼亚' => 'NC',
        '新西兰' => 'NZ',
        '尼加拉瓜' => 'NI',
        '尼日尔' => 'NE',
        '尼日利亚' => 'NG',
        '纽埃' => 'NU',
        '诺福克岛' => 'NF',
        '朝鲜' => 'KP',
        '北马里亚纳群岛' => 'MP',
        '挪威' => 'NO',
        '阿曼' => 'OM',
        '巴基斯坦' => 'PK',
        '帕劳' => 'PW',
        '巴勒斯坦领土' => 'PS',
        '巴拿马' => 'PA',
        '巴布亚新几内亚' => 'PG',
        '巴拉圭' => 'PY',
        '秘鲁' => 'PE',
        '菲律宾' => 'PH',
        '皮特凯恩群岛' => 'PN',
        '波兰' => 'PL',
        '葡萄牙' => 'PT',
        '波多黎各' => 'PR',
        '卡塔尔' => 'QA',
        '刚果（布）' => 'CG',
        '留尼汪' => 'RE',
        '罗马尼亚' => 'RO',
        '俄罗斯' => 'RU',
        '卢旺达' => 'RW',
        '圣巴泰勒米' => 'BL',
        '圣赫勒拿' => 'SH',
        '圣基茨和尼维斯' => 'KN',
        '圣卢西亚' => 'LC',
        '法属圣马丁' => 'MF',
        '圣皮埃尔和密克隆群岛' => 'PM',
        '圣文森特和格林纳丁斯' => 'VC',
        '萨摩亚' => 'WS',
        '圣马力诺' => 'SM',
        '圣多美和普林西比' => 'ST',
        '沙特阿拉伯' => 'SA',
        '塞内加尔' => 'SN',
        '塞尔维亚' => 'RS',
        '塞舌尔' => 'SC',
        '塞拉利昂' => 'SL',
        '新加坡' => 'SG',
        '荷属圣马丁' => 'SX',
        '斯洛伐克' => 'SK',
        '斯洛文尼亚' => 'SI',
        '所罗门群岛' => 'SB',
        '索马里' => 'SO',
        '南非' => 'ZA',
        '南乔治亚岛和南桑威齐群岛' => 'GS',
        '韩国' => 'KR',
        '南苏丹' => 'SS',
        '西班牙' => 'ES',
        '斯里兰卡' => 'LK',
        '苏丹' => 'SD',
        '苏里南' => 'SR',
        '斯瓦尔巴特和扬马延' => 'SJ',
        '斯威士兰' => 'SZ',
        '瑞典' => 'SE',
        '瑞士' => 'CH',
        '叙利亚' => 'SY',
        '台湾' => 'TW',
        '塔吉克斯坦' => 'TJ',
        '坦桑尼亚' => 'TZ',
        '泰国' => 'TH',
        '东帝汶' => 'TL',
        '多哥' => 'TG',
        '托克劳' => 'TK',
        '汤加' => 'TO',
        '特立尼达和多巴哥' => 'TT',
        '突尼斯' => 'TN',
        '土耳其' => 'TR',
        '土库曼斯坦' => 'TM',
        '特克斯和凯科斯群岛' => 'TC',
        '图瓦卢' => 'TV',
        '美属维京群岛' => 'VI',
        '乌干达' => 'UG',
        '乌克兰' => 'UA',
        '阿拉伯联合酋长国' => 'AE',
        '英国' => 'GB',
        '美国' => 'US',
        '美国本土外小岛屿' => 'UM',
        '乌拉圭' => 'UY',
        '乌兹别克斯坦' => 'UZ',
        '瓦努阿图' => 'VU',
        '梵蒂冈' => 'VA',
        '委内瑞拉' => 'VE',
        '越南' => 'VN',
        '瓦利斯和富图纳' => 'WF',
        '西撒哈拉' => 'EH',
        '也门' => 'YE',
        '赞比亚' => 'ZM',
        '津巴布韦' => 'ZW',
    ];

    /**
     * 获取国家名称
     * @param string $code
     * @param bool $translate
     * @return string
     */
    public static function country($code, $translate = true): string
    {
        return Locale::getDisplayRegion("_$code", $translate ? App::getLocale() : 'en');
    }

    /**
     * 获取 Country Code 通过中文的国家名称
     * @param $country
     * @return string|null
     */
    public static function countryCode($country)
    {
        if (is_null($country) || empty($country)) {
            return null;
        }
        return isset(static::$countryCodes[$country]) ? static::$countryCodes[$country] : null;
    }

    /**
     * 获取国家首都经纬度
     * @param string $code
     * @return array
     */
    public static function position($code)
    {
        return isset(static::$positions[strtoupper($code)]) ? static::$positions[strtoupper($code)] : [39.904, 116.408];
    }

    /**
     * 获取国际区号
     * @param string $code
     * @return mixed|string
     */
    public static function phoneCode($code): string
    {
        return isset(static::$phoneCodes[strtoupper($code)]) ? static::$phoneCodes[strtoupper($code)] : 'N/A';
    }

    /**
     * 验证国家代码是否存在
     * @param string $code
     * @return bool
     */
    public static function isValid($code): bool
    {
        return isset(static::$countries[strtoupper($code)]);
    }
}