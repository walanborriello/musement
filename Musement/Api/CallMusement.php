<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 18/02/2021
 * Time: 11:59
 */

namespace Api;

class CallMusement{

    public function getWeatherListCities(){
        $citiesObj = new \ExtRequest\Cities();
        $stdout = fopen('php://output', 'w');
        foreach($citiesObj->execute() as $k => $v){
            fwrite($stdout, '<p>Processed city ' . $k . " | " . $v . "</p>");
        }
        fclose($stdout);
    }

    /**
     * @param array ...$params
     */
    public function getWeatherCity(...$params){
        $cityObj = new \ExtRequest\City($params);
        $stdout = fopen('php://output', 'w');
        fwrite($stdout, '<p>Processed city ' . $cityObj->execute() . "</p>");
        fclose($stdout);
    }

}