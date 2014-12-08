var gm = {}

gm.map;
gm.markers = [];
gm.circles = [];
gm.infoWindows = [];

gm.initialize = function (mapDivID, lat, lng, zoom, allowAddPoint)
{
    if (mapDivID == undefined) mapDivID = 'map';
    
    if (lat == undefined || lat == 0) lat = 38.18719164156577;
    if (lng == undefined || lng == 0) lng = -452.900921875;
    if (zoom == undefined || zoom == 0) zoom = 4;

    if (allowAddPoint == undefined) allowAddPoint = true;

    // console.log("map zoom: " + zoom);


    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: parseInt(zoom),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };

    gm.map = new google.maps.Map(document.getElementById(mapDivID),mapOptions);

    if (allowAddPoint == true)
    {
        google.maps.event.addListener(gm.map, 'click', function(e){
            gm.addPoint(e.latLng);
        });
    }

    return gm.map;
}


gm.addPoint = function (location, includeCircle, radius, draggable, editable, circleColor, opacity, title, contentString)
{

	var infowindow = null;


    if (includeCircle == undefined) includeCircle = true;

    if (radius == undefined) radius = 25000;

    if (draggable == undefined) draggable = true;
    if (editable == undefined) editable = true;

    if (circleColor == undefined || circleColor == '') circleColor = 'red';
    if (opacity == undefined || opacity == '') opacity = 0.8;

	if (title == undefined) title = '';

	if (contentString == undefined) contentString = '';


	var infowindow = new google.maps.InfoWindow({
		content: contentString
  	});

  	
  	gm.infoWindows.push(infowindow);

	
    var marker = new google.maps.Marker({
        position:location,
        draggable:draggable,
        animation: google.maps.Animation.DROP,
        map:gm.map,
        title: title,
        infowindow:infowindow,
        //icon: new google.maps.MarkerImage('/public/images/gst_mapping.svg', null, null, null, new google.maps.Size(30,45))
    });


	google.maps.event.addListener(marker, 'click', function() {
		//infowindow.open(gm.map, marker);
		gm.clearAllMarkers();
		
		infowindow.open(gm.map, this);
	});


    if (includeCircle == true)
    {

        // var circleColor = "red";
        // var opacity = 0.8;

        // checks for color
        if ($('#googleMapCircleColor').exists())
        {
            circleColor = '#' + $('#googleMapCircleColor').attr('hex');
        }

        // checks for custom opacity setting
        if ($('#googleMapCircleOpacity').exists())
        {
            opacity = parseInt($('#googleMapCircleOpacity').val())  / 100;
        }


        var circle = new google.maps.Circle({
            center: location,
            map:gm.map,
            radius:parseInt(radius),
            strokeColor:circleColor,
            // strokeColor:"red",
            strokeOpacity:opacity,
            strokeWeight:2,
            // fillColor:"red",
            fillColor:circleColor,
            editable:editable
        });

        circle.bindTo('center', marker, 'position');

    }

    if (editable == true)
    {
        // only if editable will they be able to remove markers
        google.maps.event.addListener(marker, 'rightclick', function(e){
            this.setMap(null);
            this.setVisible(false);

            if (includeCircle == true)
            {
                circle.setMap(null);
            }
        });
    }
    gm.markers.push(marker);

    if (includeCircle == true)
    {
        gm.circles.push(circle);
    }
    
    // connects markers and info windows
}

gm.clearAllMarkers = function ()
{
	for (var i = 0; i < gm.infoWindows.length; i++)
	{
		gm.infoWindows[i].close();
	}
}


gm.loadSavedMarkers = function (includeCircle, draggable, editable, div, autocenter)
{
    if (div == undefined) div = '#savedMarkers';

	if (autocenter == undefined) autocenter = true;

    if ($(div).exists())
    {
        $(div).find("input").each(function(index, item)
        {
            // console.log('rad: ' + $(item).attr('radius'));
            gm.addPoint(new google.maps.LatLng($(item).attr('lat'),$(item).attr('lng')), includeCircle, $(item).attr('radius'), draggable, editable, $(item).attr('color'), $(item).attr('opacity'), $(item).attr('title'), $(item).attr('contentString'));
        });
        
        if (autocenter == true) gm.autoCenter();
    }
}

gm.autoCenter = function () 
{
	//  Create a new viewpoint bound
	var bounds = new google.maps.LatLngBounds();
	
	//  Go through each...
	$.each(gm.markers, function (index, marker) {
		bounds.extend(marker.position);
	});
	
	//  Fit these bounds to the map
	gm.map.fitBounds(bounds);
}

gm.displayRoute = function ()
{
    var start = new google.maps.LatLng(28.694004, 77.110291);
    var end = new google.maps.LatLng(28.72082, 77.107241);

    var directionsDisplay = new google.maps.DirectionsRenderer();// also, constructor can get "DirectionsRendererOptions" object
    directionsDisplay.setMap(gm.map); // map should be already initialized.

    var request = {
        origin : start,
        destination : end,
        travelMode : google.maps.TravelMode.DRIVING
    };

    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}
