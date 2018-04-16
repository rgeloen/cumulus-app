<?php
  session_start();

    //set error handler
  require_once('./partials-php/handle_error.php');
  set_error_handler("handle_error");

  $weather_api_key = "ffb213d8e533aa83417d69806f5ebce1";
  $city = "";

  // if correct city syntax has been POST, call weather api for this city
  if (isset($_POST['city']) && !empty($_POST['city']) && preg_match('/^[a-z ]+$/i', $_POST['city'])) {
    $cityValid = $_POST['city'];
    $weather_today_url = 'http://api.openweathermap.org/data/2.5/weather?q='.$cityValid.'&units=metric&appid='.$weather_api_key.'';
    $weather_today = file_get_contents($weather_today_url);
    $weather_today = json_decode($weather_today, true);
    $weather_week_url = 'http://api.openweathermap.org/data/2.5/forecast?q='.$cityValid.'&units=metric&appid='.$weather_api_key.'';
    $weather_week = file_get_contents($weather_week_url);
    $weather_week = json_decode($weather_week, true);
    // condition to know if city is valid (see openweathermap api for more) (thx quentin cettier for helping me with that)
    if($weather_today['cod'] == 200) {
      //set city to global session var
      $_SESSION['city'] = $cityValid;
      header('location: ./pages/results.php');
      exit();
      $city_signal = true;
    } else {
      $city_signal = "error";
    }
  }



 ?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="description" content="Document">
  <title>Cumulus</title>
  <link rel="stylesheet" href="./styles/reset.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./styles/index.css">
</head>

<body>
  <div class="homepage">
    <img class="homepage-sun" src="images/sun.png" alt="">
    <div class="title">
      <h1>Cumulus</h1>
      <h2>To know which way the wind blows </h2>
    </div>
    <div class="center">
      <form action="#" class="city" method="post">
        <input autocomplete="off" maxlength="40" class="input-city" type="text" id="city" name="city" value="<?= $city ?>" required>
        <input type="submit" class="hidden" name="submit" value="">
          <?php if ($_POST && !empty($city_signal)) { ?>
            <label style="color = red"> Wrong city name <label>
          <?php } else { ?>
              <label> Enter a city name <label>
            <?php } ?>
      </form>
    </div>
  </div>
</body>
</html>
