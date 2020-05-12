<?php
//GET TIMEZOME FUNCTION
//function getTime($timezone) {
//  date_default_timezone_set($timezone);
//  $time = time();
//  $real = date("g:i a", $time);
//  return $real; 
//}
//GET BITCOIN PRICE FUNCTION
//function getBit() {
//  $json = file_get_contents("https://blockchain.info/ticker");
//  $data = json_decode($json, TRUE);
//  $rate = $data["USD"]["15m"];
//  return $rate;
//}
function getIP() {
  if (array_key_exists('X-Forwarded-For', $_SERVER) && filter_var($_SERVER['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    $ip = $_SERVER['X-Forwarded-For'];
  } 
  elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
  }
  else {  
    $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
  }
  return $ip;
}
function checkIP($cip){
  $err = "<span style='color:#2EB82E;'>UNKNOWN</span>";
  $flag = "<span style='color:#CC2900;'>VPN&nbsp;(FLAGGED IP)</span>";
  $may = "<span style='color:#2EB82E;'>PROBABLY VPN&nbsp(NEW IP)</span>";
  $yes = "<span style='color:#2EB82E;'>VPN (CLEAN IP)</span>";
  $no = "<span style='color:#2EB82E;'>NO VPN</span>";
  $fix = "<span style='color:#E6E600;'>ERROR</span>";
  $res = @file_get_contents("http://check.getipintel.net/check.php?ip={$cip}&contact=info@d34d.co&flags=m");
  switch (TRUE) {
    case ($res == 1):
      echo $flag;
	  break;
    case ($res >= 0.76):
      echo $yes;
	  break;
    case ($res >= 0.53):
      echo $may;
	  break;
    case ($res >= 0):
      echo $no;
	  break;
	case ($res == -1):
	  echo $err;
	  break;
	case ($res == -2):
	  echo $err;
	  break;
  	case ($res == -3):
  	  echo $err;
  	  break;
  	case ($res == -4):
  	  echo $err;
  	  break;
  	case ($res == -5):
  	  echo $err;
  	  break;
  }
}
function getGeo($uno){
  if ($details = json_decode(@file_get_contents("http://ip-api.com/json/{$uno}"))){
    if (empty($details->as)):
      $out['isp'] = "unknown";
    else:
      $out['isp'] = trim($details->as);
    endif;
    if (empty($details->city) || empty($details->regionName) || empty($details->country)):
      $out['geo'] = "unknown";
    elseif(strpos($details->regionName,", City of")):
      $out['geo'] = "<span>" . trim($details->city) . ", " . trim(str_replace(", City of","",$details->regionName)) . ", " . trim($details->country) . "</span>";
    else:
      $out['geo'] = "<span>" . trim($details->city) . ", " . trim($details->regionName) . ", " . trim($details->country) . "</span>";
    endif;
    return $out;
  }
  else {
    $out['isp'] = "404";
    $out['geo'] = "404";
    return $out;
  }
}
//THIS FUNCTION IS OUTDATED AND IS PROBABLY BROKEN
/*function getPlatform() {
  $agent = $_SERVER["HTTP_USER_AGENT"];
  $windows = "Windows<br><img src='icons/windows.png' height='64' width='64'>";
  $mac = "Mac OS X<br><img src='icons/apple.png' height='64' width='64'>";
  $linux = "Linux<br><img src='icons/linux.png' height='64' width='64'>";
  $android = "Android<br><img src='icons/android.png' height='66' width='66'>";
  $ios = "iOS<br><img src='icons/apple.png' height='64' width='64'>";
  $unsupported = "unsupported<br><img src='icons/unknown.png' height='66' width='66'>";
  $os = explode(";", $agent);
  if (strpos($os[0], 'Windows') !== false):
    return $windows;
    elseif (strpos($os[2], 'Windows') !== false):
      return $windows;
      elseif (strpos($os[0], 'Macintosh') !== false):
        return $mac;
        elseif (strpos($os[0], 'X11') !== false):
          return $linux;
          elseif (strpos($os[0], 'Android') !== false):
            return $android;
            elseif (strpos($os[0], 'iPhone') !== false):
              return $ios;
              elseif (strpos($os[0], 'iPad') !== false):
                return $ios;
                elseif (strpos($os[0], 'Linux') !== false):
                  if (strpos($os[1], 'Android') !== false):
                    return $android;
                  endif;
                else:
                  return $unsupported;
                endif;
}
//THIS FUNCTION IS OUTDATED AND IS PROBABLY BROKEN
function getBrowser() {
  $agent = $_SERVER["HTTP_USER_AGENT"];
  $firefox = "Firefox<br><img src='icons/firefox.png' height='64' width='64'>";
  $chrome = "Chrome<br><img src='icons/chrome.png' height='64' width='64'>";
  $safari = "Safari<br><img src='icons/safari.png' height='64' width='64'>";
  $opera = "Opera<br><img src='icons/opera.png' height='64' width='64'>";
  $msie = "Internet Explorer<br><img src='icons/msie.png' height='64' width='64'>";
  $unsupported = "unsupported<br><img src='icons/unknown.png' height='66' width='66'>";
  if (strpos($agent, 'Firefox') !== false):
    return $firefox;
    elseif (strpos($agent, 'OPR') !== false):
      return $opera;
      elseif (strpos($agent, 'MSIE') !== false):
        return $msie;
        elseif (strpos($agent, 'Trident') !== false):
          return $msie;
          elseif (strpos($agent, 'Safari') !== false):
            if (strpos($agent, 'Chrome') !== false):
              return $chrome;
              elseif (strpos($agent, 'CriOS') !== false):
                return $chrome;
              else:
                return $safari;
              endif;
            else:
              return $unsupported;
            endif;
}
*/
//YOU ARE VERY CLOSE TO CHAOS
//STOP NOW DONT DO IT
$version = "1.1";
$ip = getIP();
$info = getGeo($ip);
//YOU ARE VERY CLOSE TO CHAOS
//START OUTPUT TO BROWSER NOW!!!
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>D34D</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
  </head>
  <body class="landing">
      <div id="page-wrapper">
          <header id="header" class="alt">
            <h1><a href="index.html">D34D</a></h1>
            <nav id="nav">
              <ul>
                <li class="special">
                  <a href="#menu" class="menuToggle"><span>Menu</span></a>
                  <div id="menu">
                    <ul>
                      <li><a href="index.php">Home</a></li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </header>
          
          <section id="banner">
            <div class="inner">
              <h2>identity</h2>
              <p><?php echo $ip, "</p>";
              echo "<p>", $info['isp'], "</p>";
              echo "<p>",$info['geo'], "</p>";
              echo "<p>",checkIP($ip), "</p>"; ?>
              <!-- <ul class="actions">
                <li><a href="#" class="button special">Activate</a></li>
              </ul>-->
            </div>
            <a href="#one" class="more scrolly">About D34D</a>
          </section>
          
          <section id="one" class="wrapper style1 special">
            <div class="inner">
              <header class="major">
                <h2>Welcome</h2>
                <p>Use D34D to find your identity information.</p>
              </header>
            </div>
          </section>

          <section id="two" class="wrapper alt style2">
            <section class="spotlight">
              <div class="image"><img src="images/a1.jpg" alt="" /></div><div class="content">
                <h2>Secure</h2>
                <p>We NEVER store any generated info! This data comes from an api!<br /><br />
                We NEVER use analytics! Because your privacy is more important.</p>
              </div>
            </section>
            <section class="spotlight">
              <div class="image"><img src="images/a2.jpg" alt="" /></div><div class="content">
                <h2>Version 1.1</h2>
                <p>Major cosmetics overhaul obviously =0<br />
                Minor backend changes to accommodate styles.<br />
                Expanded some functions with bug fixes.<br />
                Fully responsive mobile HTML5/CSS3 layout.</p>
              </div>
            </section>
          </section>

          <footer id="footer">
            <ul class="copyright">
              <li>&copy; D34D <?php echo date("Y"); ?></li>
            </ul>
          </footer>
          
      </div>

      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/jquery.scrollex.min.js"></script>
      <script src="assets/js/jquery.scrolly.min.js"></script>
      <script src="assets/js/skel.min.js"></script>
      <script src="assets/js/util.js"></script>
      <script src="assets/js/main.js"></script>

  </body>
</html>
