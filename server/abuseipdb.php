<?php

$key = $_ENV["ABUSEIPDB"];

$client = new GuzzleHttp\Client([
    'base_uri' => 'https://api.abuseipdb.com/api/v2/'
  ]);
  
  $response = $client->request('GET', 'blacklist', [

      'headers' => [
          'Accept' => 'application/json',
          'Key' => $key
    ],
  ]);
  
  $output = $response->getBody();

  $f = fopen("cache.json", "w") or die("Failed to open file");
  fwrite($f, $output);
  fclose($f);