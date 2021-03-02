<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 18/02/2021
 * Time: 15:11
 */

namespace ExtRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class City{

    const URIMUSEMENT = 'https://api.musement.com/api/v3/cities';
    const URIWEATHER = 'http://api.weatherapi.com/v1/forecast.json';
    const METHOD = 'GET';
    const OK = 200;
    const APIKEYWEATHERAPI = '4ed625728d8d435ca77124753211702';

    protected $_cityName;
    protected $_countryName;

    /**
     * City constructor.
     * @param $params
     */
    public function __construct($params){
        $this->_cityName = ucfirst($params[0]);
        isset($params[1]) ? $this->_countryName = $params[1] : '';
    }

    /**
     * @return string
     */
    public function execute(){
        $citiesList = $this->_getWeatherCity();
        return $citiesList;
    }


    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function _getWeatherCity(){
        $client = new Client();
        $filter = '&days=2&q=' . $this->_cityName;
        if(strlen($country = $this->_countryName) > 0){
            $filter .= ',' . $country;
        }
        $uri = self::URIWEATHER . '?key=' . self::APIKEYWEATHERAPI . $filter;
        $res = $client->request(self::METHOD, $uri);
        $res->getHeader('content-type')[0];

        if($res->getStatusCode() == self::OK){

            $resp = json_decode($res->getBody(), true);

            echo "<pre>";
            foreach($resp['forecast']['forecastday'] as $item){
                $weathersDays[] = $item['day']['condition']['text'];
            }

            return $resp['location']['name'] . " | " . implode(' - ', $weathersDays);
        }else{
            new \ExceptionOfTest\Error('Connection ERROR: ' . $res->getStatusCode());
        }
    }


}