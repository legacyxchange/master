<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

//var_dump($places); exit;

if ($places->status == 'ZERO_RESULTS') {
    echo $this->alerts->alert("No results found");
} elseif ($places->status == 'OK') {
    $mapPointers = array();

    echo <<< EOS
<div id="listContent"> 
EOS;
    
    foreach ($places->results as $k => $r) { 
    	
    	$active = true;
        $website = $phone = $deactivateButton = $img = null;
        $distance = 0;

        $skip = $update = false;

        // if location has a type that we do not want
        // it will skip
        if (!empty($r->types)) {
            foreach ($r->types as $type) {
                if (in_array($type, $this->config->item('disqualify_types'))) {
                    $skip = true;
                    break;
                }
            }
        }

        if ($skip)
            continue;

        try {
            $locationID = $this->search->checkGoogleLocationExists($r->id);

            if ($locationID === false) {
                // gets location detailssss
                $details = $this->places->details($r->reference);

                $addressDisplay = $details->result->formatted_address;

                $phone = $details->result->formatted_address;
                $website = $details->result->website;

                $address = $this->search->determineAddress($details->result->address_components);

                // create new listing
                $data = array
                    (
                    'name' => $r->name,
                    'address' => $address,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postalCode' => $address->postalCode,
                    'phone' => $details->result->formatted_phone_number,
                    'website' => $details->result->website,
                    'lat' => $r->geometry->location->lat,
                    'lng' => $r->geometry->location->lng,
                    'googleID' => $r->id,
                    'googleReference' => $r->reference,
                    'formattedAddress' => $details->result->formatted_address,
                    'googleHTMLAddress' => $details->result->adr_address
                );

                if (empty($address->pobox)) {
                    $data['address'] = $address->streetNumber . ' ' . $address->route;
                } else {
                    $data['address'] = "PO Box " . $address->pobox;
                    $data['address2'] = $address->streetNumber . ' ' . $address->route;
                }

                $locationID = $this->profile->insertLocation($data);
           
                // downloads photos from details
                if (!empty($details->result->photos)) {
                    foreach ($details->result->photos as $k => $v) {
                        $this->places->photoRequest($v->photo_reference, $locationID);
                    }
                }

                // downloads photo for location
                //if (!empty($r->photos[0]->photo_reference)) $this->places->photoRequest($r->photos[0]->photo_reference, $locationID);
                // insert reviews
                $this->search->saveGoogleReviews($locationID, $details->result->reviews);
            } else {
                // checks if location should be updated from Google
                $update = $this->search->checkLocationNeedUpdating($locationID);

                // update is required, gets latest data from gougle
                if ($update)
                    $this->search->updateLocationFromGooglePlaces($locationID);

                // checks if location is active
                $active = $this->search->checkLocationActive($locationID);

                // get current location information
                $info = $this->search->getLocationInfo($locationID);

                $addressDisplay = (!empty($info->formattedAddress)) ? $info->formattedAddress : "{$info->address} {$info->city}, {$info->state} {$info->postalCode}";

                $phone = $info->phone;
                $website = $info->websiteUrl;
                // update listeing possibly
                // skips location if set to deleted
                if ((bool) $info->deleted == true)
                    continue;
            }
            // loads view with stars for average rating
            $avgRating = $this->search->avgReviews($locationID);
            $bodyRating['avg'] = $avgRating;
            $ratingHtml = $this->load->view('search/listavgrating', $bodyRating, true);
        } catch (Exception $e) {
            //var_dump($e->getMessage()); exit;
            continue;
        }
        // skips location row if location is not active
        if (!$active)
            continue;

        // gets distance from user

        $distance = $this->functions->distance($lat, $lng, $r->geometry->location->lat, $r->geometry->location->lng);
        $distance = number_format($distance, 2);

        if ($this->session->userdata('admin')) {
            $deactivateButton = "<button type='button' class='btn btn-xs btn-danger deactiveBtn' onclick=\"search.deactivate(this, {$locationID});\"><i class='fa fa-trash-o'></i></button>" . PHP_EOL;
        }

        $r->name = str_replace('"', '&quot;', $r->name);

echo <<< EOS
                
        	<div class="map_addr" onclick="location.href='/search/info/{$locationID}';">       
       			<div class="addr_title">{$r->name}<br /><span>{$distance} mi. away</span></div>
       			<div class="addr_reviews">{$ratingHtml}</a><br />{$numReviews} reviews</div>
       			<div class="clear"></div>
       			<div class="addr">{$addressDisplay}</div>
       			<input type='hidden' name='listingID' value='{$locationID}' />
       			<input type="hidden" id="numReviews-{$locationID}" value="{$numReviews}" />
    	    </div>

EOS;

        if (!empty($website))
            $websiteDisplay = "<p style='margin-bottom:2px;'><a href='{$website}' target='_blank'>{$website}</a></p>";
        if (!empty($phone))
            $phoneDisplay = "<p style='margin-bottom:2px;'>{$phone}</p>";

        $markerName = "<h5><a href='/search/info/{$locationID}?lat={$lat}&lng={$lng}&q=" . urldecode($_GET['q']) . "&location=" . urldecode($_GET['location']) . "'>{$r->name}</a></h5>";

        // hidden marker for google map
        echo "<input type='hidden' class='gmMarker' lat='{$r->geometry->location->lat}' lng='{$r->geometry->location->lng}' title=\"{$r->name}\" contentString=\"{$markerName}{$websiteDisplay}{$phoneDisplay}<p>{$addressDisplay}</p>\" loaded='0'>" . PHP_EOL;
    }
    echo '</div>';

    echo "<input type='hidden' name='next_page_token' id='next_page_token' value='{$places->next_page_token}'>" . PHP_EOL;
}
?>
</div>