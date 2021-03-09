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

class Cities{

    const URIMUSEMENT = 'https://api.musement.com/api/v3/cities';
    const URIWEATHER = 'http://api.weatherapi.com/v1/forecast.json';
    const METHOD = 'GET';
    const OK = 200;
    const APIKEYWEATHERAPI = '4ed625728d8d435ca77124753211702';

    /**
     * @return array
     */
    public function execute(){
        $citiesList = $this->_getWeatherCitiesList();
        return $citiesList;
    }

    /**
     * Get cities list from musement
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function _getCitiesList(){
        $client = new Client();
        $res = $client->request(self::METHOD, self::URIMUSEMENT);
        $res->getHeader('content-type')[0];
        $citiesArray = [];
        if($res->getStatusCode() == self::OK){
            // 'application/json; charset=utf8'
            $cities = json_decode($res->getBody(), true);
            foreach($cities as $item){
                $citiesArray[$item['name']] = [
                    'lat' => $item['latitude'],
                    'lon' => $item['longitude']
                ];
            }

            return $citiesArray;
        }else{
            new \ExceptionOfTest\Error('Connection ERROR: ' . $res->getStatusCode());
        }
    }

    /**
     *
     * Get weather list by cities
     * @return array
     */
    private function _getWeatherCitiesList(){
        $client = new Client();
        $citiesList = $this->_getCitiesList();
        $list = [];
        $filter = '&days=2';
        if(count($citiesList) > 0){
            $uri = self::URIWEATHER . '?key=' . self::APIKEYWEATHERAPI;
            foreach($citiesList as $city => $data){
                $promises[$city] = $client->getAsync($uri . "&q=" . $city . $filter);
            }

            $responses = Promise\Utils::settle($promises)->wait();

            foreach($responses as $response => $v){
                if(isset($v['value'])){
                    $weathers = [];
                    $responseVal = json_decode($v['value']->getBody()->getContents(), true);
                    foreach($responseVal['forecast']['forecastday'] as $item){
                        $weathers[] = isset($item['day']['condition']['text']) ? $item['day']['condition']['text'] : '';
                    }
                    $list[$response] = implode(" - " , $weathers);
                }else{
                    $list[$response] = "No results!";
                }
            }
        }else{
            new \ExceptionOfTest\Error('Cities List not found!');
        }

        return $list;
    }

}