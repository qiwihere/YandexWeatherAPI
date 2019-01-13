# YandexWeatherAPI

<h3>API погоды Yandex</h3>
Класс YandexWeather является простым обработчиком XML данных которые в открытом доступе предоставляет Яндекс. 
Позволяет без ограничений и дополнительных ключей аутентификации получать погоду в выбранном городе.

Включает два статичных метода:

<i>YandexWeather::get_region_id($city)</i> - обращается к <a>https://pogoda.yandex.ru/static/cities.xml</a> и возвращает код региона выбранного города $city
<br>
<i>YandexWeather::get_weather($region_id)</i> - обращается к <a>https://pogoda.yandex.ru/static/cities.xml</a> и возвращает прогноз погоды в $region_id
<br><br>
Пример:<br>
<pre>
<code>
$city_id = YandexWeather::get_region_id('Санкт-Петербург');
$weather = YandexWeather::get_weather($city_id);
</code>
</pre>
<i>var_dump($weather_id);</i>Вернет:
<pre>
<code>
array(5) {
  ["now"]=>
  array(4) {
    ["type"]=>
    string(8) "ясно"
    ["wind_speed"]=>
    string(1) "2"
    ["wind_direction"]=>
    string(17) "юго-запад"
    ["temperature"]=>
    string(2) "-7"
  }
  ["morning"]=>
  array(1) {
    ["temperature"]=>
    string(15) "от -7 до -5"
  }
  ["daytime"]=>
  array(1) {
    ["temperature"]=>
    string(2) "-5"
  }
  ["evening"]=>
  array(1) {
    ["temperature"]=>
    string(15) "от -4 до -3"
  }
  ["night"]=>
  array(1) {
    ["temperature"]=>
    string(2) "-3"
  }
}
</code>
</pre>
