<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliweedmaps extends CI_Controller
{
    private $location_file;
    private $menu_file;
    private $reviews_file;
    
    public function Cliweedmaps()
    {
        parent::__construct();
        $this->load->database();
    }
    public function importLocations()
    {
        error_reporting(-1);
        $handle = fopen("public/data_mining/dispensaries.csv", "r");
        $test = array();
        $allowed_keys = array(
            0,
            1,
            234
        );
        while (!feof($handle))
        {
            $arr_values = explode('"', fgets($handle, 8096));
            //print_r($arr_values);
            foreach ($arr_values as $key => $val)
            {
                if (in_array($key, $allowed_keys))
                {
                    
                    foreach (explode(',', $val) as $new_val)
                    {
                        $test[] = $this->db->escape_str(trim($new_val));
                    }
                }
            }
            $full_address = $test[4] . ', ' . $test[5] . ', ' . $test[6];
            //$geocode = json_decode($this->functions->geoCodeAddress($full_address));
            /*
             * Mapquest integration
             * Google GeoCode keeps dying from usage
             */
            $geocode = $this->mapQuestGeoCode($full_address);
            echo $full_address . PHP_EOL;
            $id = intval($test[0]);
            if ($id > 0)
            {
                if ($geocode)
                {
                    $lat = $geocode['lat'];
                    $lng = $geocode['lng'];
                    $formatted_address = $this->db->escape_str($geocode->results[0]->formatted_address);
                    $statezip = explode(' ', $test[6]);
                    $url = isset($test[8]) ? $test[8] : '';
                    $phone = isset($test[10]) ? $test[10] : '';
                    $email = isset($test[9]) ? $test[9] : '';
                    $query = "
                        REPLACE INTO locations
                        (
                                dispensaryid
                            ,   datestamp
                            ,   createdBy
                            ,   company
                            ,   StoreID
                            ,   name
                            ,   address
                            ,   city
                            ,   state
                            ,   postalCode
                            ,   phone
                            ,   websiteURL
                            ,   email
                            ,   lat
                            ,   lng
                            ,   formattedAddress
                            ,   lastUpdated
                        )
                        VALUES
                        (
                                $id
                            ,   NOW()
                            ,   0
                            ,   41
                            ,   0
                            ,   '$test[1]'
                            ,   '$test[4]'
                            ,   '$test[5]'
                            ,   '$statezip[0]'
                            ,   '$statezip[1]'
                            ,   '$phone'
                            ,   '$url'
                            ,   '$email'
                            ,   $lat
                            ,   $lng
                            ,   '$formatted_address'
                            ,   NOW()
                        )
                    ";
                    echo "INSERTING ($test[0])$test[1]" . PHP_EOL;
                    $this->db->query($query);
                }
                else
                {
                    echo "SKIPPING BAD FORMAT - $test[0]" . PHP_EOL;
                }
            }
            else
            {
                echo "SKIPPING BAD ID" . PHP_EOL;
            }
            $query = '';
            $test = array();
            sleep(1);
        }
        fclose($handle);
    }
    
    public function importMenus()
    {
        error_reporting(-1);
        $handle = fopen("public/data_mining/menus.csv", "r");
        $test = array();
        $item_types = array(
            'Indica'        => 1,
            'Sativa'        => 2,
            'Hybrid'        => 3,
            'Edible'        => 4,
            'Concentrate'   => 5,
            'Drink'         => 6,
            'Tincture'      => 7,
            'Topicals'      => 8,
            'Preroll'       => 9,
            'Wax'           => 10,
            'Gear'          => 11,
            'Seed'          => 12,
            'Clone'         => 15,
        );
        $this->db->select('id, dispensaryid');
        $this->db->from('locations');
        $query = $this->db->get();
        $dispensary_ids = array();
        foreach ($query->result() as $result)
        {
            $dispensary_ids[$result->dispensaryid] = $result->id;
        }
        $query_str = "
            INSERT INTO item_menu
            (
                    locationid
                ,   strainid
                ,   userid
                ,   item_type
                ,   description
                ,   per_g
                ,   per_eighth
                ,   per_quarter
                ,   per_half
                ,   per_oz
                ,   per_each
                ,   active
            )
            VALUES
        ";
        fgets($handle, 8096);
        $query_array = array();
        while (!feof($handle))
        {
            $arr_values = explode(',', fgets($handle, 8096));
            $each = floatval(array_pop($arr_values));
            $oz = floatval(array_pop($arr_values));
            $half = floatval(array_pop($arr_values));
            $quarter = floatval(array_pop($arr_values));
            $eighth = floatval(array_pop($arr_values));
            $gram = floatval(array_pop($arr_values));
            $dispensaryid = intval(array_shift($arr_values));
            $locationid = (array_key_exists($dispensaryid, $dispensary_ids)) ? $dispensary_ids[$dispensaryid] : 0;
            if ($locationid > 0)
            {
                array_shift($arr_values);
                $item_type = array_shift($arr_values);
                $item_type_id = (array_key_exists($item_type, $item_types) ? $item_types[$item_type] : 0);
                $description = $this->db->escape_str(trim(implode(',', $arr_values), '"'));
                $query_array[] = "
                    (
                            $locationid
                        ,   0
                        ,   0
                        ,   $item_type_id
                        ,   '$description'
                        ,   $gram
                        ,   $eighth
                        ,   $quarter
                        ,   $half
                        ,   $oz
                        ,   $each
                        ,   1
                    )
                ";
                if (count($query_array) == 100)
                {
                    $this->db->query($query_str . implode(",", $query_array));
                    $query_array = array();
                    echo "INSERTING 100 rows" . PHP_EOL;
                    sleep(1);
                }
            }
        }
        if (count($query_array) > 1)
        {
            $this->db->query($query_str . implode(",", $query_array));
            echo "INSERTING " . count($query_array) . " rows";
        }
    }
    
    public function mapQuestGeoCode($address)
    {
        $key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
        $address = urlencode($address);
        $json = substr(file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=' . $address . '&callback=renderGeocode&outFormat=json'), 14, -2);
        $json = json_decode($json);
        $lat = isset($json->results[0]->locations[0]->latLng->lat) ? $json->results[0]->locations[0]->latLng->lat : false;
        $lng = isset($json->results[0]->locations[0]->latLng->lng) ? $json->results[0]->locations[0]->latLng->lng : false;
        return ($lat && $lng) ? array('lat' => $lat, 'lng' => $lng) : false;
    }
}