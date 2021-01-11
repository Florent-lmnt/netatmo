<?php

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

include_once('src/Netatmo/autoload.php');
//Client configuration from Config.php
$config = array();
$config['client_id'] = '5ff42a0d5139ec148135b31c';
$config['client_secret'] = 'ftedNFlsLQMcWmrSmQ091TILYcQtzz8lWuyw6h2evOY';
$config['scope'] = 'read_station read_thermostat write_thermostat';
$client = new Netatmo\Clients\NAApiClient($config);

//Retrieve access token
$username = 'florent.luminet@gmail.com';
$pwd = '@Codingpepe1@';
$client->setVariable('username', $username);
$client->setVariable('password', $pwd);
try
{
    $tokens = $client->getAccessToken();
    $refresh_token = $tokens['refresh_token'];
    $access_token = $tokens['access_token'];
}
catch(Netatmo\Exceptions\NAClientException $ex)
{
    echo "An error occcured while trying to retrive your tokens \n";
}

try{
    $params = [
        'lat_ne' => '50.8838492',
        'lon_ne' => '8.0209591',
        'lat_sw' => '42.5999',
        'lon_sw' => '-5.57175'
    ];
    $response = $client->api('getpublicdata','GET',$params);
    $response = json_encode($response);
}

catch(Netatmo\Exceptions\NAClientException $ex)
{
    echo "An error occcured while trying to retrive your tokens \n";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Get Weather</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <style>
        html {
            background: #181818;
        }

        #mapid {
            height: 800px;
            width: 80%;
            margin: auto;
        }

        @import url("https://fonts.googleapis.com/css?family=Roboto:400,400i,700");

        * {
            font-family: Roboto, sans-serif;
            padding: 0;
            margin: 0;
        }

        .flexbox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search {
            margin-bottom: 45px;
            margin-top: 30px;
        }

        .search > h3 {
            font-weight: normal;
        }

        .search > h1,
        .search > h3 {
            color: white;
            margin-bottom: 15px;
            text-shadow: 0 1px #303030;
        }

        .search > div {
            display: inline-block;
            position: relative;
            filter: drop-shadow(0 1px #181818);
        }

        .search > div:after {
            content: "";
            background: white;
            width: 4px;
            height: 20px;
            position: absolute;
            top: 40px;
            right: 2px;
            transform: rotate(135deg);
        }

        .search > div > input {
            color: white;
            font-size: 16px;
            background: transparent;
            width: 25px;
            height: 25px;
            padding: 10px;
            border: solid 3px white;
            outline: none;
            border-radius: 35px;
            transition: width 0.5s;
        }

        .search > div > input::placeholder {
            color: #efefef;
            opacity: 0;
            transition: opacity 150ms ease-out;
        }

        .search > div > input:focus::placeholder {
            opacity: 1;
        }

        .search > div > input:focus,
        .search > div > input:not(:placeholder-shown) {
            width: 410px;
        }
    </style>
</head>
<body>
<div class="flexbox">
    <div class="search">
        <h1>Quel temps fait-il chez vous ?</h1>
        <div>
            <input type="text" placeholder="Rechercher . . ." required>
        </div>
    </div>
</div>
<div id="mapid"></div>
<script>
    var mymap = L.map('mapid').setView([46.3630104, 2.9846608], 6);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(mymap);
</script>
</body>
</html>

