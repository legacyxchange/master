<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Places {

    private $ci;

    public function __construct() {
        $this->ci = & get_instance();

        // $this->ci->load->library('session');
        // if connect to DB
        if (class_exists('CI_DB')) {
            
        }
    }

    public function search($lat, $lng, $q) {
        $q = urlencode($q);

        // they did not enter a search parameter
        // get all styles from codes and search for those
        if (empty($q)) {
            /*
              $styles = $this->ci->functions->getCodes(26, $this->ci->config->item('bmsCompanyID'));

              $stylesArray = array();

              if (!empty($styles))
              {
              foreach ($styles as $r)
              {
              $stylesArray[] = $r->display;
              }
              }

              //$q = implode(',', $stylesArray);


             */

            $q = "Marijuana";

            //error_log("Styles q: {$q}");
        }

        //$url = "https://maps.googleapis.com/maps/api/place/radarsearch/json?location={$lat},{$lng}&radius=32186&keyword={$q}&sensor=false&key=" . $this->ci->config->item('google_api_key');

        $url = "https://maps.googleapis.com/maps/api/place/search/json?location={$lat},{$lng}&radius=32186&types=school|establishment|health&keyword={$q}&rankby=prominence&sensor=true&key=" . $this->ci->config->item('google_api_key');
        //error_log($url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $results = file_get_contents($url);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $results = json_decode($results);

        if ($results->status !== 'OK')
            throw new Exception("Error getting Google Place Details: " . $results->status . PHP_EOL . PHP_EOL . $url);

        return $results;
    }

    /**
     * gets photo for a paticular location
     */
    public function photoRequest($reference, $location, $maxWidth = 1000) {
        if (empty($reference))
            throw new Exception("Google Photo Reference is empty!");
        if (empty($location))
            throw new Exception("Location ID is empty!");

        $path = 'public' . DS . 'uploads' . DS . 'locationImages' . DS . $location . DS;

        $this->ci->functions->createDir($path);

        $path = $_SERVER['DOCUMENT_ROOT'] . $path;

        $filename = uniqid() . '.jpg';

        $url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference={$reference}&sensor=true&key=" . $this->ci->config->item('google_api_key');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        $results = file_get_contents($url); //curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $fp = fopen($path . $filename, 'x');

        $write = fwrite($fp, $results);

        if ($write === false)
            throw new Exception("Unable to write location image from google: {$path}{$filename}");

        fclose($fp);

        // save image

        $data = array(
            'location' => $location,
            'fileName' => $filename,
            'order' => 0
        );

        $this->ci->profile->insertLocationImage($data);

        return true;
    }

    public function details($reference) {
        if (empty($reference))
            throw new Exception("Google location Reference is empty!");

        $url = "https://maps.googleapis.com/maps/api/place/details/json?reference={$reference}&sensor=true&key=" . $this->ci->config->item('google_api_key');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $results = file_get_contents($url); //curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $results = json_decode($results);

        if ($results->status !== 'OK')
            throw new Exception("Error getting Google Place Details: " . $results->status);

        return $results;
    }

    /*
     * gets the next page of listings from google places search
     */

    public function getNextPage($next_page_token) {
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken={$next_page_token}&sensor=false&key=" . $this->ci->config->item('google_api_key');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $results = file_get_contents($url); //curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $results = json_decode($results);

        return $results;
    }

    public function addPlace($p) {
        $url = "https://maps.googleapis.com/maps/api/place/add/json?sensor=false&key=" . $this->ci->config->item('google_api_key');

        $JSON = "{
  'location': {
    'lat': {$p['lat']},
    'lng': {$p['lng']}
  },
  'accuracy': 50,
  'name': \"{$p['name']}\",
  'types': ['establishment'],
  'language': 'en'
}";
        error_log($JSON);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Legnth: ' . strlen($JSON)));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON); // adds JSON string to add location to google places

        $results = file_get_contents($url); //curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $results = json_decode($results);

        return $results;
    }

    public function deleteLocation($reference) {
        if (empty($reference))
            throw new Exception("Reference is empty!");

        $url = "https://maps.googleapis.com/maps/api/place/delete/json?sensor=false&key=" . $this->ci->config->item('google_api_key');

        $JSON = "{
        'reference': '{$reference}'
        }";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Legnth: ' . strlen($JSON)));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON); // adds JSON string to add location to google places

        $results = file_get_contents($url); //curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        $results = json_decode($results);


        if ($results->status !== 'OK')
            throw new Exception("Unable to remove location from Google Places! {$results->status}");

        return true;
    }

}
