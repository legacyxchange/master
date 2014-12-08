<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<?php

if ($places->status == 'ZERO_RESULTS')
{
	echo $this->alerts->alert("No results found");
}
elseif ($places->status == 'OK')
{
	$mapPointers = array();

	//print_r($places);
	foreach ($places->results as $k => $r)
	{
		$active = true;
		
		$website = $phone = $deactivateButton = $img = null;
		$distance = 0;
	
		$skip = $update = false;
	
		// if location has a type that we do not want
		// it will skip
		if (!empty($r->types))
		{
			foreach ($r->types as $type)
			{
				if (in_array($type, $this->config->item('disqualify_types')))
				{
					$skip = true;
					break;
				}
			}
		}
		
		if ($skip) continue;
		
		try
		{
			$locationID = $this->dojos->checkGoogleLocationExists($r->id);
			
			if ($locationID === false)
			{
				// gets location detailssss
				$details = $this->places->details($r->reference);
				
				//$address = $details->result->address_components[0]->long_name . ' ' . $details->result->address_components[1]->long_name;
			
				$addressDisplay = $details->result->formatted_address;
				
				$phone = $details->result->formatted_address;
				$website = $details->result->website;
				
				$address = $this->dojos->determineAddress($details->result->address_components);
				
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
				
				if (empty($address->pobox))
				{
					$data['address'] = $address->streetNumber . ' ' . $address->route;
				}
				else
				{
					$data['address'] = "PO Box " . $address->pobox;
					$data['address2'] = $address->streetNumber . ' ' . $address->route;
				}
				
				$locationID = $this->profile->insertLocation($data);
				
				//error_log("Photo Ref: {$r->photos[0]->photo_reference}");
				
				// downloads photo for location
				if (!empty($r->photos[0]->photo_reference)) $this->places->photoRequest($r->photos[0]->photo_reference, $locationID);
				
				// insert reviews
				$this->dojos->saveGoogleReviews($locationID, $details->result->reviews);
				
			}
			else
			{
				// checks if location should be updated from Google
				$update = $this->dojos->checkLocationNeedUpdating($locationID);
				
				// update is required, gets latest data from gougle
				if ($update) $this->dojos->updateLocationFromGooglePlaces($locationID);
			
				// checks if location is active
				$active = $this->dojos->checkLocationActive($locationID);
			
				// get current location information
				$info = $this->dojos->getLocationInfo($locationID);
				
				
				
				
                $addressDisplay = (!empty($info->formattedAddress)) ? $info->formattedAddress : "{$info->address} {$info->city}, {$info->state} {$info->postalCode}";

                $phone = $info->phone;
				$website = $info->websiteUrl;
				// update listeing possibly
		
            
                // skips location if set to deleted
                if ((bool) $info->deleted == true) continue;
            }
			
			// loads view with stars for average rating
			$avgRating = $this->dojos->avgReviews($locationID);
			$bodyRating['avg'] = $avgRating;
			$ratingHtml = $this->load->view('dojos/listavgrating', $bodyRating, true);

		}
		catch (Exception $e)
		{
			$this->functions->sendStackTrace($e);
			continue;
		}
		// skips location row if location is not active
		if (!$active) continue;
		
		// gets distance from user
		$distance = $this->functions->distance($lat, $lng, $r->geometry->location->lat, $r->geometry->location->lng);
		$distance = number_format($distance, 2);
		
		if ($this->session->userdata('admin'))
		{
			$deactivateButton = "<button type='button' class='btn btn-xs btn-danger deactiveBtn' onclick=\"dojos.deactivate(this, {$locationID});\"><i class='fa fa-trash-o'></i></button>" . PHP_EOL;
		}
		
		
		echo <<< EOS

    <div class='row'>
        <div class='col-md-12 listing'>
        
        		<input type='hidden' name='listingID' id='listingID' value='{$locationID}'>

                <div class='listRight pull-right'>
                {$distance} miles<br>
<!--                    <a href='javascript:void(0);'><i class='fa fa-star-o addFavStar'></i> Add to favorites</a><br> //-->
<!--                    <a href='javascript:void(0);'><i class='fa fa-map-marker pinPointMarker'></i> Pinpoint</a> -->
				
                {$ratingHtml}
				
				{$deactivateButton}

                <span class='reviewsTxt'>{$reviews} {$reviewTxt}</span>
            </div> <!-- .listRight -->



            <div class='listImg' onclick="profile.editlisting({$locationID});"><img src='/dojos/img/{$locationID}/100'><div class='clearfix'></div></div>
            
            <div class='listContent' onclick="dojos.viewlisting({$locationID});">
                <h3>{$r->name}</h3>

                <p class='locAddress'><span>Location :</span> {$addressDisplay}</p>
                <div class='clearfix'></div>
            </div> <!-- .listContent -->


        </div> <!-- .listing -->
    </div> <!-- .row -->

EOS;

		if (!empty($website)) $websiteDisplay = "<p style='margin-bottom:2px;'><a href='{$website}' target='_blank'>{$website}</a></p>";
		if (!empty($phone)) $phoneDisplay = "<p style='margin-bottom:2px;'>{$phone}</p>";
		
		// hidden marker for google map
		echo "<input type='hidden' class='gmMarker' lat='{$r->geometry->location->lat}' lng='{$r->geometry->location->lng}' title=\"{$r->name}\" contentString=\"<h5>{$r->name}</h5>{$websiteDisplay}{$phoneDisplay}<p>{$addressDisplay}</p>\" loaded='0'>" . PHP_EOL;
	}
	
	
	echo "<input type='hidden' name='next_page_token' id='next_page_token' value='{$places->next_page_token}'>" . PHP_EOL;
}
?>
