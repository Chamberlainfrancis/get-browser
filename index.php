<?php 

  require("vendor/autoload.php");

  use ipinfo\ipinfo\IPinfo;

  $access_token = 'api-access-token-here';
  $client = new IPinfo($access_token);
  $ip_address = '216.239.36.21';
  $details = $client->getDetails($ip_address);

  // echo $details->country_name;

  $userAgent = $_SERVER["HTTP_USER_AGENT"];
  $browser_name = "";
  $browser_version = "";
  $OS = "";

  // Get the name of the Browsers serperately
  // browser array;
  $browserArray = array(
    'Windows Mobile'    => 'IEMobile',
    'Android Mobile'    => 'Android',
    'iPhone Mobile'     => 'iPhone',
    'Firefox'           => 'Firefox',
    'Google Chrome'     => 'Chrome',
    'Netscape'          => 'Netscape',
    'Internet Explorer' => 'MSIE',
    'Opera'             => 'Opera',
    'Safari'            => 'Safari'
  );
  foreach($browserArray as $key => $value){
    if(preg_match("/$value/", $userAgent)){
      break;
    }else{
      $key = "Unknown Browser";
    }
  }

  $browser_name = $key;

  // lets get the operating system of the user
  //OSArray
  $OSArray = array(
          'iPhone'        => 'iphone',
          'Android'       => 'android',
          'Windows 98'    => '(Win98)|(Windows 98)',
          'Windows 2000'  => '(Windows 2000)|(Windows NT 5.0)',
          'Windows ME'    => 'Windows ME',
          'Windows XP'    => '(Windows XP)|(Windows NT 5.1)',
          'Windows Vista' => 'Windows NT 6.0',
          'Windows 7'     => 'Windows NT 6.1',
          'Windows 8'     => 'Windows NT 6.2',
          'Windows 10'    => 'Windows NT 10.0',
          'Linux'         => '(X11)|(Linux)',
          'Mac OS'        => '(Mac_PowerPC)|(Macintosh)|(Mac OS)'
  );
  foreach($OSArray as $key => $value){
    if(preg_match("/$value/", $userAgent)){
      break;
    }else{
      $key = "Unknown Operating system";
    }
  }

  $OS = $key;

  // Lets Get the browser version
  // $browser version array
  $versionArray = array(
    'IEMobile' => 'IEMobile',
    'Android' => 'Android',
    'iPhone' => 'iPhone',
    'Firefox' => 'Firefox',
    'Chrome' => 'Chrome',
    'Netscape' => 'Netscape',
    'MSIE' => 'MSIE',
    'Opera' => 'Opera',
    'Safari' => 'Safari'
  );

  foreach($versionArray as $key => $value){
    if(preg_match("/$value/", $userAgent)){
      break;
    }else{
      $key = "Unknown Browser version";
    }
  }

  $browser_version = $key;

  //Lets get the correct version number of our browser
  $getVersion = array("version", $browser_version, "other");
    $platform = '#(?<browser>'. join('|',$getVersion) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($platform, $userAgent, $match)){
      //No matching number lets continue
    }

    // Lets see how many we have
    $i = count($match['browser']);
    if($i != 1){
      //We will have two matching result since we are not using other arguement yet
      // lets see if version is before or after the name
      if(strripos($userAgent, "version") < strripos($userAgent, $browser_version)){
        $browser_version = $match['version'][0];
      }else{
        $browser_version = $match['version'][1];
      }
    }else{
      $browser_version = $match['version'][0];
    }

    // lets check if we have found a number/ version
    if ($browser_version == null || $browser_version == "") {
      $browser_version = "unknown";
    }

    $result = array(
      "IP" => $details->ip,
      "COuntry" => $details->country_name,
      "City" => $details->city,
      "Region" => $details->region,
      "Browser" => $browser_name,
      "Browser Version" => $browser_version,
      "OS" => $OS
    );

    print_r($result);


 ?>
