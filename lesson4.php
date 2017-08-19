<?php
date_default_timezone_set('America/Chicago');
$format = "l: F jS, Y h:i A";
$city = "Dallas, TX";
$url = "http://api.openweathermap.org/data/2.5/weather?id=4684888&units=imperial&appid=540a6bb97799940883f7994a59ac6ef1";
//$weather = json_decode(file_get_contents ($url));

if(is_file('cache.txt') && filemtime('cache.txt') > time() - 3600)
{
    $weather = file_get_contents('cache.txt');
}
else 
{ 
    $weather = file_get_contents($url);
    file_put_contents('cache.txt', $weather);
}

$weather = json_decode($weather);

/*echo '<pre>';
print_r($weather);*/

$current_temp = $weather -> main -> temp;
$current_weather = $weather -> weather[0] -> main;
$current_description = $weather -> weather[0] -> description;
$current_pressure = $weather -> main -> pressure;
$current_humidity = $weather -> main -> humidity;
$current_wind = $weather -> wind -> speed;
$current_degrees = $weather -> wind -> deg;

switch ($current_degrees) {
    case 0:
        $direction = "North";
        break;
    case ($current_degrees > 0 && $current_degrees < 90):
        $direction = "North-east";
        break;
    case 90:
        $direction = "East";
        break;
    case ($current_degrees > 90 && $current_degrees < 180):
        $direction = "South-east";
        break;
    case 180:
        $direction = "South";
        break;
    case ($current_degrees > 180 && $current_degrees < 270):
        $direction = "South-west";
        break;
    case 270:
        $direction = "West";
        break;
    case ($current_degrees > 270 && $current_degrees < 360):
        $direction = "North-west";
        break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PHP: Lesson 4</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<h1>Weather in <?= $city ?></h1>
<table>
<tr>
	<td>Date &amp; Time</td>
	<td><?= date($format) ?></td>
</tr>
<tr>
<td>Weather conditions</td>
<td><?= $current_weather.": ".$current_description ?></td>
</tr>
<tr>
    <td>Temperature</td>
    <td><?= $current_temp." "."&deg;F" ?></td>
</tr>
<tr>
    <td>Pressure</td>
    <td><?= $current_pressure." "."hpa" ?></td>
</tr>
<tr>
    <td>Humidity</td>
    <td><?= $current_humidity." "."%" ?></td>
</tr>
<tr>
    <td>Wind</td>
    <td><?= $direction." ".$current_wind." "."m/h" ?></td>
</tr>
</table>
</body>
</html>


