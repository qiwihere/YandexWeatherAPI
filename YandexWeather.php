<?php

class YandexWeather
{
    /**
     * @param $city
     * @return mixed
     */
    public static function get_region_id($city)
    {
        $city = mb_strtolower($city);

        $xml_cities = file_get_contents('https://pogoda.yandex.ru/static/cities.xml');
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml_cities, $vals, $index);
        xml_parser_free($p);

        foreach ($vals as $k => $val) {
            $cur_city = mb_strtolower($val['value']);
            if (stristr($cur_city, $city) or $city == $cur_city) {
                if ($vals[$k]['attributes']['ID']) {
                    $region = $vals[$k]['attributes']['REGION'];
                }

            }
        }
        return $region;
    }

    /**
     * @param int $region result of get_region_id
     * @return mixed
     */
    public static function get_weather($region)
    {
        $path = 'https://export.yandex.ru/bar/reginfo.xml?region=' . $region;
        $xmlfile = file_get_contents($path);
        $ob = simplexml_load_string($xmlfile);
        $json = json_encode($ob);
        $configData = json_decode($json, true);

        $day_frames = ['now', 'morning', 'daytime', 'evening', 'night'];
        $weather = $configData['weather']['day']['day_part'];

        foreach ($day_frames as $k => $frame) {
            $weather_now = $weather[$k];
            if ($frame == 'now') {
                $arr_weather[$frame] = [
                    'type' => $weather_now['weather_type'],
                    'wind_speed' => $weather_now['wind_speed'],
                    'wind_direction' => $weather_now['wind_direction'],
                    'temperature' => $weather_now['temperature']
                ];
            } else {
                if (array_key_exists('temperature', $weather_now)) {
                    $arr_weather[$frame] = [
                        'temperature' => $weather_now['temperature']
                    ];
                } else {
                    $arr_weather[$frame] = [
                        'temperature' => 'от ' . $weather_now["temperature_from"] . ' до ' . $weather_now["temperature_to"]
                    ];
                }
            }
        }

        return $arr_weather;
    }
}
