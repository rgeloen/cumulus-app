<?php

  session_start();

  //set error handler
  require_once('../partials-php/handle_error.php');


  include '../partials-php/teleport.php';
  $city = $_SESSION['city'];
  $weather_api_key = "ffb213d8e533aa83417d69806f5ebce1";

  //WEATHER OF TODAY
  // if city has been found, call weather api for this city
  if (isset($city)) {
  $weather_today_url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city.'&units=metric&appid='.$weather_api_key.'';
  $weather_week_url = 'http://api.openweathermap.org/data/2.5/forecast?q='.$city.'&units=metric&appid='.$weather_api_key.'';
    //if city has been found on weather api, get informations
    if (isset($weather_today_url) && isset($weather_week_url)) {
      $weather_today = file_get_contents($weather_today_url);
      $weather_today = json_decode($weather_today, true);
      $weather_week = file_get_contents($weather_week_url);
      $weather_week = json_decode($weather_week, true);
    };
  };


  //set error handler
  set_error_handler("handle_error");
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="description" content="Document">
  <title>Cumulus</title>
  <link rel="stylesheet" href="../styles/reset.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../styles/results.css">
</head>

<body>

<!-- GENERAL RESULTS PAGE -->
  <div class="page-results">
    <span class="title">Cumulus in <?= $city ?> </span>
    <div class="buttons">
      <button type="button" class="button-today active" name="button">Today</button>
      <button type="button" class="button-week" name="button">Week Forecast</button>
      <button type="button" class="button-infos" name="button">More infos</button>
    </div>

      <!-- WEATHER TODAY DISPLAY -->
      <div class="weather-today active">
        <div class="today-global">
        <div class="date today-element">
          <p><?= date("Y-m-d" , $weather_today['dt']) ?></p>
        </div>
        <div class="temperature today-element">
          <p>Minimum= <?= $weather_today['main']['temp_min'] ?>°C</p>
          <p>Maximum = <?= $weather_today['main']['temp_max'] ?>°C</p>
        </div>
        <div class="weather today-element">
          <img class="today-image"  alt="img_weather" src="http://openweathermap.org/img/w/<?=$weather_today['weather'][0]['icon'] ?>.png"
              width="50px"
              height="50px">
          </img>
        </div>
        <div class="wind today-element">
          <p>Wind : <?= $weather_today['wind']['speed'] ?> km/h</p>
        </div>
        <div class="sun today-element">
          <p>Lever du soleil : <?= date("H:i", $weather_today['sys']['sunrise']) ?> </p>
          <p>Coucher du soleil <?= date("H:i", $weather_today['sys']['sunset']) ?></p>
        </div>
        </div>
        <div class="spotify-player">
          <p>Your today's playlist</p>
          <?php if ($weather_today['weather'][0]['main'] == "Clouds"): ?>
            <iframe src="https://open.spotify.com/user/digster.fr/playlist/6xwCH60hsGvo2tLk1j07Ud?si=fv7Ue6vLTTaU29NJ0emJXQ" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
          <?php endif; ?>
          <?php if ($weather_today['weather'][0]['main'] == "Rain"): ?>
            <iframe src="https://open.spotify.com/embed?uri=spotify:user:spotify:playlist:37i9dQZF1DXbvABJXBIyiY" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
          <?php endif; ?>
          <?php if ($weather_today['weather'][0]['main'] == "Sun"): ?>
            <iframe src="https://open.spotify.com/user/spotify/playlist/37i9dQZF1DWVlm7xgnWdvJ?si=ypAlESZiTwKH8KYnMndakg" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
          <?php endif; ?>
          <?php if ($weather_today['weather'][0]['main'] == "Snow"): ?>
            <iframe src="https://open.spotify.com/user/spotify/playlist/37i9dQZF1DX4H7FFUM2osB?si=SDepFNkrShO2oT7cP42eAg" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
          <?php endif; ?>
        </div>
    </div>

      <!-- WEATHER FORECAST FOR WEEK DISPLAY -->
      <div class="week-results">
              <!-- we take only the hours that we want -->
        <?php foreach ($weather_week['list'] as $_week) : ?>
          <?php $today = date("Y-m-d"); ?>
          <?php if(date('Y-m-d',$_week['dt']) == $today): ?>
            <div class="week-result">
              <div class="date week-element">
                <p><?= date("Y-m-d H:i" , $_week['dt']) ?></p>
              </div>
              <div class="temperature week-element">
                <p>Temperature <?= $_week['main']['temp'] ?>°C</p>
              </div>
              <div class=" weather week-element">
                <!-- taking icon from openweathermap API-->
                <img class="forecast-image"  alt="img_weather" src="http://openweathermap.org/img/w/<?= $_week['weather'][0]['icon']?>.png"
                    width="50px"
                    height="50px">
                </img>
              </div>
              <div class="wind week-element">
                <p>Wind : <?= $_week['wind']['speed']?> m/s</p>
              </div>
            </div>
          <?php endif ?>
        <?php endforeach ?>
      </div>

      <!-- MORE INFOS DISPLAY (Teleport API) -->
      <div class="more-infos">
        <h1 class="title">Data recorded for <?= $city ?></h1>

        <div class="housing-info info">
          <h2>Housing</h2>
          <span><?= round($city_infos['categories'][0]['score_out_of_10']); ?></span>
        </div>

        <div class="cost-info  info">
          <h2> Cost of Living </h2>
          <span><?= round($city_infos['categories'][1]['score_out_of_10']); ?></span>
        </div>

        <div class="transports-info info">
          <h2> Transports </h2>
          <span><?= round($city_infos['categories'][4]['score_out_of_10']); ?></span>
        </div>

        <div class="business-info info">
          <h2> Business Freedom </h2>
          <span><?= round($city_infos['categories'][6]['score_out_of_10']); ?></span>
        </div>

        <div class="safety-info info">
          <h2> Safety </h2>
          <span><?= round($city_infos['categories'][7]['score_out_of_10']); ?></span>
        </div>

        <div class="healthcare-info info">
          <h2> Healthcare </h2>
          <span><?= round($city_infos['categories'][8]['score_out_of_10']); ?></span>
        </div>

        <div class="safety-info info">
          <h2> Education </h2>
          <span><?= round($city_infos['categories'][9]['score_out_of_10']); ?></span>
        </div>

        <div class="ecology-info info">
          <h2> Ecology </h2>
          <span><?= round($city_infos['categories'][10]['score_out_of_10']); ?></span>
        </div>

        <div class="internet-info info">
          <h2> Internet Access </h2>
          <span><?= round($city_infos['categories'][13]['score_out_of_10']); ?></span>
        </div>

        <div class="culture-info info">
          <h2> Culture </h2>
          <span><?= round($city_infos['categories'][14]['score_out_of_10']); ?></span>
        </div>

        <div class="tolerance-info info">
          <h2> Tolerance </h2>
          <span><?= round($city_infos['categories'][15]['score_out_of_10']); ?></span>
        </div>
        
      </div>
    </div>
  <script type="text/javascript" src="../scripts/index.js"></script>

  </body>

  </html>
