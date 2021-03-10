##MUSEMENT

This project was developed to receive information about the weather in cities

Composer was used to install the project vendor using GruzzleHttp for the REST and Fast-route API calls to be able to make the different calls pointing to a specific route.

##Requirements
<ul><li>composer</li></ul>

##Steps
<br />In project root, run:


```
1.composer install
2.composer dump-autoload
```

###Task #2
Please check file swagger.yaml and swagger.json in root directory. <br />This content is supposed to be integrated with [https://api.musement.com/swagger_3.5.0.json](https://api.musement.com/swagger_3.5.0.json)

##CONFIGS

After cloning the repository, create a virtual host in the local environment and run the composer installation command.

##EXAMPLE FOR USE PROJECT

You can call:
<ul><li>[DNS/IP address]/weatherCitiesList </li>
<li>[DNS/IP address]/getWeatherCity/[CITY_NAME]/[COUNTRY_NAME]</li>
</ul>


##CODE BLOCKS

```php
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r){
    $r->addRoute('GET', '/weatherCitiesList', [\Api\CallMusement::class, 'getWeatherListCities']);
    $r->addRoute('GET', '/getWeatherCity/{city:[a-zA-Z]+}[/{country:[a-zA-Z]+}]', [\Api\CallMusement::class, 'getWeatherCity']);
});
```

You can call:
```
 [DNS/IP address]/weatherCitiesList returns the list of cities with their weather in the range of two consecutive days.
 [DNS/IP address]/getWeatherCity/[city name] return the weather of specific city.
```


```php
    /**
     * City constructor.
     * @param $params
     */
    public function __construct($params){
        $this->_cityName = ucfirst($params[0]);
        isset($params[1]) ? $this->_countryName = $params[1] : '';
    }
```

Class City can receive two params: city name is mandatory and country name for specific city. <br /><br />Ex. If you search for Milan, you will receive cities because in API Musement it is possible that the search was done with a LIKE condition: in this case "Milan%".

##DIAGRAM

Mermaid diagram:

```mermaid
graph LR;
    A[Call weatherCitiesList] --> B{Does it work?}
    B -- Yes --> C{see list}
    B -- No --> D{see exception}
    D -- > A
```

```mermaid
graph LR;
    A[Call getWeatherCity with city name and country name] --> B{Does it work?}
    B -- Yes --> C{see list}
    B -- No --> D{see exception}
    D -- > A
```


