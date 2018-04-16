<?php

    $city = $_SESSION['city'];

    $city_name_url = 'https://api.teleport.org/api/cities/?search='.$city.'&limit=1';

    $city_name = file_get_contents($city_name_url);
    $city_name = json_decode($city_name, true);

    $city_id_url = $city_name['_embedded']['city:search-results'][0]['_links']['city:item']['href'];
    $city_id = file_get_contents($city_id_url);
    $city_id = json_decode($city_id, true);

    $id = $city_id['_links']['city:urban_area']['href'];

    $city_infos_url = $id.'scores';
    $city_infos= file_get_contents($city_infos_url);
    $city_infos = json_decode($city_infos, true);

 ?>
